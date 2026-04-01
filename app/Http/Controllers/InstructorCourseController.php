<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Review;
use App\Models\Section;
use App\Models\Video;
use App\Support\CloudflareR2Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;

class InstructorCourseController extends Controller
{
    public function showStep1(Request $request): View
    {
        $instructor = $request->user();
        $course = $this->resolveCourse($request, $instructor->id);

        return view('instructor.create_course', [
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
            'course' => $course,
            'learningTopicsText' => $course?->learning_topics ? implode(', ', $course->learning_topics) : '',
        ]);
    }

    public function showCurriculum(Request $request): View
    {
        $course = $this->resolveCourse($request, $request->user()->id)?->load([
            'sections' => fn ($query) => $query->orderBy('order_number'),
            'sections.videos' => fn ($query) => $query->orderBy('order_number'),
            'sections.videos.materials',
        ]);

        return view('instructor.curriculum_step_2', [
            'course' => $course,
        ]);
    }

    public function showPricing(Request $request): View
    {
        $course = $this->resolveCourse($request, $request->user()->id);

        return view('instructor.pricing_step_3', [
            'course' => $course,
        ]);
    }

    public function showReview(Request $request): View
    {
        $course = $this->resolveCourse($request, $request->user()->id);

        return view('instructor.review_step_4', [
            'course' => $course?->loadMissing([
                'category',
                'sections',
                'sections.videos',
                'sections.videos.materials',
            ]),
        ]);
    }

    public function showMyCourses(Request $request): View
    {
        $instructor = $request->user();
        $courses = Course::query()
            ->where('user_id', $instructor->id)
            ->with('category')
            ->withCount([
                'sections',
                'reviews',
                'enrollments as completed_enrollments_count' => fn ($query) => $query->where('status', 'completed'),
            ])
            ->withAvg('reviews', 'rating')
            ->withSum([
                'payments as completed_payments_sum' => fn ($query) => $query->where('status', 'completed'),
            ], 'amount')
            ->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'totalCourses' => Course::query()->where('user_id', $instructor->id)->count(),
            'publishedCourses' => Course::query()->where('user_id', $instructor->id)->where('status', 'published')->count(),
            'activeLearners' => Course::query()
                ->where('user_id', $instructor->id)
                ->withCount([
                    'enrollments as completed_enrollments_count' => fn ($query) => $query->where('status', 'completed'),
                ])->get()
                ->sum('completed_enrollments_count'),
            'monthlyEarnings' => Course::query()
                ->where('user_id', $instructor->id)
                ->withSum([
                    'payments as monthly_completed_payments_sum' => fn ($query) => $query
                        ->where('status', 'completed')
                        ->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year),
                ], 'amount')->get()
                ->sum('monthly_completed_payments_sum'),
            'averageRating' => round((float) Review::query()
                ->whereHas('course', fn ($query) => $query->where('user_id', $instructor->id))
                ->avg('rating'), 1),
            'totalReviews' => Review::query()
                ->whereHas('course', fn ($query) => $query->where('user_id', $instructor->id))
                ->count(),
        ];

        return view('instructor.mycourse', [
            'courses' => $courses,
            'summary' => $summary,
            'profileAvatar' => $instructor->avatarUrl(96),
            'instructorName' => $instructor->name,
        ]);
    }

    public function signVideoUpload(Request $request): JsonResponse|Response
    {
        $course = $this->findOwnedCourseOrFail($request);

        $validated = validator($request->query(), [
            'course_id' => ['required', 'integer', Rule::exists('courses', 'id')],
            'section_index' => ['required', 'integer', 'min:0'],
            'lesson_index' => ['required', 'integer', 'min:0'],
            'lesson_title' => ['nullable', 'string', 'max:255'],
        ])->validate();

        $accountId = (string) config('services.cloudflare_stream.account_id');
        $apiToken = (string) config('services.cloudflare_stream.api_token');
        $customerCode = (string) config('services.cloudflare_stream.customer_code');
        $maxDurationSeconds = max(60, (int) config('services.cloudflare_stream.max_duration_seconds', 14400));

        if ($accountId === '' || $apiToken === '' || $customerCode === '') {
            return response()->json([
                'message' => 'Cloudflare Stream is not configured. Add the Stream account, token, and customer code to continue.',
            ], 422);
        }

        $uploadLength = (string) $request->header('Upload-Length', '');
        $incomingMetadata = trim((string) $request->header('Upload-Metadata', ''));

        if (! ctype_digit($uploadLength) || (int) $uploadLength <= 0) {
            return response()->json([
                'message' => 'A valid upload length is required to start the resumable upload.',
            ], 422);
        }

        $lessonSlug = Str::slug((string) ($validated['lesson_title'] ?? 'lesson video'));
        $displayName = trim(Str::headline(str_replace('-', ' ', $lessonSlug !== '' ? $lessonSlug : 'lesson video')));
        $metadataParts = array_filter([
            $incomingMetadata,
            'maxDurationSeconds '.base64_encode((string) $maxDurationSeconds),
            'expiry '.base64_encode(now()->addHours(2)->toIso8601String()),
            'name '.base64_encode($displayName),
        ]);

        $response = Http::withToken($apiToken)
            ->withHeaders([
                'Tus-Resumable' => '1.0.0',
                'Upload-Length' => $uploadLength,
                'Upload-Metadata' => implode(',', $metadataParts),
            ])
            ->post("https://api.cloudflare.com/client/v4/accounts/{$accountId}/stream?direct_user=true");

        if ($response->status() < 200 || $response->status() >= 300) {
            return response()->json([
                'message' => $response->json('errors.0.message') ?: 'Unable to prepare the Cloudflare Stream resumable upload.',
            ], 422);
        }

        $streamUid = (string) ($response->header('stream-media-id') ?? '');
        $uploadUrl = (string) ($response->header('Location') ?? '');

        if ($streamUid === '' || $uploadUrl === '') {
            return response()->json([
                'message' => 'Cloudflare Stream did not return a valid resumable upload URL.',
            ], 422);
        }

        return response('', 201, [
            'Tus-Resumable' => '1.0.0',
            'Location' => $uploadUrl,
            'stream-media-id' => $streamUid,
            'x-stream-playback-url' => "https://customer-{$customerCode}.cloudflarestream.com/{$streamUid}/manifest/video.m3u8",
            'Access-Control-Expose-Headers' => 'Location,stream-media-id,x-stream-playback-url,Tus-Resumable',
        ]);
    }

    public function signMaterialUpload(Request $request): JsonResponse
    {
        $course = $this->findOwnedCourseOrFail($request);

        $validated = $request->validate([
            'course_id' => ['required', 'integer', Rule::exists('courses', 'id')],
            'section_index' => ['required', 'integer', 'min:0'],
            'lesson_index' => ['required', 'integer', 'min:0'],
            'material_index' => ['required', 'integer', 'min:0'],
            'material_title' => ['required', 'string', 'max:255'],
            'material_type' => ['required', Rule::in(['pdf', 'zip', 'docx'])],
            'file_name' => ['nullable', 'string', 'max:255'],
        ]);
        $expectedExtension = strtolower((string) $validated['material_type']);
        $folder = trim((string) config('services.cloudflare_r2.material_folder', 'lms/course-materials'), '/');
        $filename = Str::slug($course->slug)
            .'-section-'.($validated['section_index'] + 1)
            .'-lesson-'.($validated['lesson_index'] + 1)
            .'-resource-'.($validated['material_index'] + 1)
            .'-'.Str::slug($validated['material_title'])
            .'-'.Str::lower(Str::random(6))
            .'.'.$expectedExtension;
        $mimeType = match ($expectedExtension) {
            'pdf' => 'application/pdf',
            'zip' => 'application/zip',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            default => 'application/octet-stream',
        };
        $path = $folder.'/'.$filename;

        try {
            return response()->json(CloudflareR2Storage::createPresignedUpload($path, $mimeType, 30));
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function storeCurriculum(Request $request): RedirectResponse
    {
        $course = $this->findOwnedCourseOrFail($request);

        $validated = $request->validate([
            'course_id' => ['required', 'integer', Rule::exists('courses', 'id')],
            'content_status' => ['required', Rule::in(['pending', 'completed'])],
            'sections' => ['required', 'array', 'min:1'],
            'sections.*.id' => ['nullable', 'integer'],
            'sections.*.title' => ['required', 'string', 'max:255'],
            'sections.*.lessons' => ['required', 'array', 'min:1'],
            'sections.*.lessons.*.id' => ['nullable', 'integer'],
            'sections.*.lessons.*.title' => ['required', 'string', 'max:255'],
            'sections.*.lessons.*.existing_video_url' => ['nullable', 'url', 'max:2000'],
            'sections.*.lessons.*.existing_video_duration' => ['nullable', 'integer', 'min:0'],
            'sections.*.lessons.*.is_preview' => ['nullable', 'boolean'],
            'sections.*.lessons.*.materials' => ['nullable', 'array'],
            'sections.*.lessons.*.materials.*.id' => ['nullable', 'integer'],
            'sections.*.lessons.*.materials.*.title' => ['nullable', 'string', 'max:255'],
            'sections.*.lessons.*.materials.*.file_url' => ['nullable', 'url', 'max:2000'],
            'sections.*.lessons.*.materials.*.type' => ['nullable', Rule::in(['pdf', 'zip', 'docx'])],
            'sections.*.lessons.*.materials.*.is_downloadable' => ['nullable', 'boolean'],
        ], [
            'sections.required' => 'Add at least one section.',
            'sections.*.title.required' => 'Each section needs a title.',
            'sections.*.lessons.required' => 'Each section needs at least one lesson.',
            'sections.*.lessons.*.title.required' => 'Each lesson needs a title.',
        ]);

        foreach ($validated['sections'] as $sectionIndex => $sectionData) {
            foreach ($sectionData['lessons'] as $lessonIndex => $lessonData) {
                $existingVideoUrl = $lessonData['existing_video_url'] ?? null;

                if (! $existingVideoUrl) {
                    return back()
                        ->withErrors([
                            "sections.{$sectionIndex}.lessons.{$lessonIndex}.existing_video_url" => 'Upload a lesson video before continuing.',
                        ])
                        ->withInput();
                }

                foreach (($lessonData['materials'] ?? []) as $materialIndex => $materialData) {
                    $hasAnyMaterialField = filled($materialData['title'] ?? null)
                        || filled($materialData['file_url'] ?? null)
                        || filled($materialData['type'] ?? null);

                    if (! $hasAnyMaterialField) {
                        continue;
                    }

                    if (blank($materialData['title'] ?? null) || blank($materialData['file_url'] ?? null) || blank($materialData['type'] ?? null)) {
                        return back()
                            ->withErrors([
                                "sections.{$sectionIndex}.lessons.{$lessonIndex}.materials.{$materialIndex}.file_url" => 'Each resource needs a title, uploaded file, and type.',
                            ])
                            ->withInput();
                    }
                }
            }
        }

        try {
            DB::transaction(function () use ($request, $validated, $course) {
                $course->update([
                    'content_status' => $validated['content_status'],
                ]);

                $existingSections = $course->sections()->with(['videos.materials'])->get()->keyBy('id');
                $keptSectionIds = [];
                $keptVideoIds = [];
                $keptMaterialIds = [];

                foreach ($validated['sections'] as $sectionIndex => $sectionData) {
                    $sectionId = (int) ($sectionData['id'] ?? 0);
                    $section = $sectionId > 0 ? $existingSections->get($sectionId) : null;

                    if ($section) {
                        $section->update([
                            'title' => $sectionData['title'],
                            'order_number' => $sectionIndex + 1,
                        ]);
                    } else {
                        $section = Section::create([
                            'course_id' => $course->id,
                            'title' => $sectionData['title'],
                            'order_number' => $sectionIndex + 1,
                        ]);
                    }

                    $keptSectionIds[] = $section->id;
                    $existingVideos = $section->videos->keyBy('id');

                    foreach ($sectionData['lessons'] as $lessonIndex => $lessonData) {
                        $videoUrl = $lessonData['existing_video_url'] ?? '';
                        $lessonId = (int) ($lessonData['id'] ?? 0);
                        $video = $lessonId > 0 ? $existingVideos->get($lessonId) : null;

                        $videoAttributes = [
                            'section_id' => $section->id,
                            'upload_by' => $request->user()->id,
                            'title' => $lessonData['title'],
                            'thumbnail_url' => $video?->thumbnail_url,
                            'video_url' => $videoUrl ?: '',
                            'order_number' => $lessonIndex + 1,
                            'duration' => max(0, (int) ($lessonData['existing_video_duration'] ?? $video?->duration ?? 0)),
                            'is_preview' => (bool) ($lessonData['is_preview'] ?? false),
                        ];

                        if ($video) {
                            $video->update($videoAttributes);
                        } else {
                            $video = Video::create($videoAttributes);
                        }

                        $keptVideoIds[] = $video->id;
                        $existingMaterials = $video->materials->keyBy('id');

                        foreach (($lessonData['materials'] ?? []) as $materialData) {
                            if (blank($materialData['title'] ?? null) || blank($materialData['file_url'] ?? null) || blank($materialData['type'] ?? null)) {
                                continue;
                            }

                            $materialId = (int) ($materialData['id'] ?? 0);
                            $material = $materialId > 0 ? $existingMaterials->get($materialId) : null;
                            $materialAttributes = [
                                'video_id' => $video->id,
                                'title' => $materialData['title'],
                                'file_url' => $materialData['file_url'],
                                'type' => $materialData['type'],
                                'is_downloadable' => (bool) ($materialData['is_downloadable'] ?? false),
                            ];

                            if ($material) {
                                $material->update($materialAttributes);
                            } else {
                                $material = CourseMaterial::create($materialAttributes);
                            }

                            $keptMaterialIds[] = $material->id;
                        }
                    }
                }

                if (! empty($keptVideoIds)) {
                    CourseMaterial::query()
                        ->whereHas('video.section', fn ($query) => $query->where('course_id', $course->id))
                        ->whereNotIn('id', $keptMaterialIds)
                        ->delete();

                    Video::query()
                        ->whereHas('section', fn ($query) => $query->where('course_id', $course->id))
                        ->whereNotIn('id', $keptVideoIds)
                        ->delete();
                }

                Section::query()
                    ->where('course_id', $course->id)
                    ->whereNotIn('id', $keptSectionIds)
                    ->delete();
            });
        } catch (RuntimeException $exception) {
            return back()
                ->withErrors(['sections' => $exception->getMessage()])
                ->withInput();
        }

        return redirect()
            ->route('instructor.create-course.pricing', ['course' => $course->id])
            ->with('status', 'Curriculum saved successfully.');
    }

    public function storePricing(Request $request): RedirectResponse
    {
        $course = $this->findOwnedCourseOrFail($request);

        $validated = $request->validate([
            'course_id' => ['required', 'integer', Rule::exists('courses', 'id')],
            'pricing_model' => ['required', Rule::in(['one_time', 'subscription'])],
            'subscription_cycle' => ['nullable', Rule::in(['monthly', 'quarterly', 'yearly'])],
            'price' => ['required', 'numeric', 'min:0'],
            'validity_in_days' => ['nullable', 'integer', 'min:1'],
            'promotional_note' => ['nullable', 'string', 'max:255'],
        ], [
            'price.required' => 'Enter a course price.',
            'pricing_model.required' => 'Choose a pricing model.',
        ]);

        if ($validated['pricing_model'] === 'subscription' && blank($validated['subscription_cycle'] ?? null)) {
            return back()
                ->withErrors(['subscription_cycle' => 'Choose a billing cycle for the subscription plan.'])
                ->withInput();
        }

        $course->update([
            'price' => $validated['price'],
            'pricing_model' => $validated['pricing_model'],
            'subscription_cycle' => $validated['pricing_model'] === 'subscription' ? $validated['subscription_cycle'] : null,
            'validity_in_days' => $validated['pricing_model'] === 'one_time' ? ($validated['validity_in_days'] ?? null) : null,
            'promotional_note' => $validated['promotional_note'] ?? null,
        ]);

        return redirect()
            ->route('instructor.create-course.review', ['course' => $course->id])
            ->with('status', 'Pricing saved successfully.');
    }

    public function publish(Request $request): RedirectResponse
    {
        $course = $this->findOwnedCourseOrFail($request)?->loadCount(['sections']);

        if ($course->sections_count < 1) {
            return back()->withErrors([
                'publish' => 'Add at least one curriculum section before publishing.',
            ]);
        }

        $course->update([
            'status' => 'published',
        ]);

        return redirect()
            ->to('/instructor/mycourse')
            ->with('status', 'Course published successfully.');
    }

    public function storeStep1(Request $request): RedirectResponse
    {
        $instructor = $request->user();

        $validated = $request->validate([
            'course_id' => ['nullable', 'integer', Rule::exists('courses', 'id')],
            'title' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string'],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'level' => ['required', Rule::in(['beginner', 'intermediate', 'advanced'])],
            'language' => ['required', 'string', 'max:255'],
            'learning_topics' => ['nullable', 'string', 'max:2000'],
            'thumbnail' => ['nullable', 'image', 'max:10240'],
        ], [
            'title.required' => 'Enter a course title.',
            'details.required' => 'Add a course description.',
            'category_id.required' => 'Choose a category.',
            'level.required' => 'Choose the course level.',
            'language.required' => 'Choose the instruction language.',
            'thumbnail.image' => 'Upload a valid thumbnail image.',
            'thumbnail.max' => 'Thumbnail size must be 10MB or less.',
        ]);

        $course = null;

        if (! empty($validated['course_id'])) {
            $course = Course::query()
                ->where('id', $validated['course_id'])
                ->where('user_id', $instructor->id)
                ->first();
        }

        $topics = $this->parseLearningTopics($validated['learning_topics'] ?? '');

        if (! $course) {
            $course = new Course();
            $course->user_id = $instructor->id;
            $course->status = 'draft';
            $course->price = 0;
            $course->total_duration = 0;
        }

        $course->fill([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $this->generateUniqueSlug($validated['title'], $course->id),
            'details' => $validated['details'],
            'level' => $validated['level'],
            'language' => $validated['language'],
            'learning_topics' => $topics,
        ]);

        if ($request->hasFile('thumbnail')) {
            try {
                $course->thumbnail = $this->uploadThumbnailToR2(
                    $request->file('thumbnail'),
                    $course->slug ?: Str::slug($validated['title'])
                );
            } catch (RuntimeException $exception) {
                return back()
                    ->withErrors(['thumbnail' => $exception->getMessage()])
                    ->withInput();
            }
        }

        $course->save();

        return redirect()
            ->route('instructor.create-course.curriculum', ['course' => $course->id])
            ->with('status', 'Step 1 saved successfully.');
    }

    private function resolveCourse(Request $request, int $userId): ?Course
    {
        $courseId = $request->integer('course');

        if ($courseId > 0) {
            return Course::query()
                ->where('id', $courseId)
                ->where('user_id', $userId)
                ->first();
        }

        return Course::query()
            ->where('user_id', $userId)
            ->where('status', 'draft')
            ->latest('updated_at')
            ->first();
    }

    private function findOwnedCourseOrFail(Request $request): Course
    {
        $courseId = $request->integer('course_id', $request->integer('course'));

        abort_if($courseId <= 0, 404);

        return Course::query()
            ->where('id', $courseId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();
    }

    private function parseLearningTopics(string $value): array
    {
        return collect(explode(',', $value))
            ->map(fn ($topic) => trim($topic))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug !== '' ? $baseSlug : 'course';
        $counter = 1;

        while (
            Course::query()
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function uploadThumbnailToR2(UploadedFile $file, string $slug): string
    {
        $folder = trim((string) config('services.cloudflare_r2.thumbnail_folder', 'lms/course-thumbnails'), '/');
        $extension = strtolower((string) ($file->getClientOriginalExtension() ?: 'jpg'));
        $path = $folder.'/'.Str::slug($slug).'-thumbnail.'.$extension;

        return CloudflareR2Storage::uploadPublicFile($file, $path);
    }

}


