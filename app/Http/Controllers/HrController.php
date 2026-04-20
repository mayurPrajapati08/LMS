<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Category;
use App\Models\HomeSlide;
use App\Models\HomeFounderMedia;
use App\Models\HomeAchievement;
use App\Models\HomeStory;
use App\Models\JobOpening;
use App\Models\OfflineCourse;
use App\Models\PublicContact;
use App\Models\Role;
use App\Models\User;
use App\Models\Workshop;
use App\Support\CloudflareR2Storage;
use App\Support\PlatformSettings;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Illuminate\View\View;

class HrController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $hasPublicContactsTable = Schema::hasTable('public_contacts');
        $hasHomeSlidesTable = Schema::hasTable('home_slides');
        $hasHomeFounderMediaTable = Schema::hasTable('home_founder_media');
        $hasHomeStoriesTable = Schema::hasTable('home_stories');
        $hasHomeAchievementsTable = Schema::hasTable('home_achievements');
        $hasJobOpeningsTable = Schema::hasTable('job_openings');
        $hasWorkshopsTable = Schema::hasTable('workshops');
        $hasFacultyColumns = Schema::hasColumn('users', 'show_on_homepage');
        $hasContactStatusColumn = $hasPublicContactsTable && Schema::hasColumn('public_contacts', 'status');
        $hasContactTopicColumn = $hasPublicContactsTable && Schema::hasColumn('public_contacts', 'topic');

        $baseContacts = $hasPublicContactsTable ? PublicContact::query() : null;

        return view('hr.dashboard', [
            'user' => $user,
            'profileAvatar' => $user->avatarUrl(96),
            'stats' => [
                'slides' => $hasHomeSlidesTable ? HomeSlide::query()->where('is_active', true)->count() : 0,
                'founder_media' => $hasHomeFounderMediaTable ? HomeFounderMedia::query()->where('is_active', true)->count() : 0,
                'stories' => $hasHomeStoriesTable ? HomeStory::query()->where('is_active', true)->count() : 0,
                'achievements' => $hasHomeAchievementsTable ? HomeAchievement::query()->where('is_active', true)->count() : 0,
                'jobs' => $hasJobOpeningsTable ? JobOpening::query()->where('is_active', true)->count() : 0,
                'workshops' => $hasWorkshopsTable ? Workshop::query()->where('is_active', true)->count() : 0,
                'offline_courses' => Schema::hasTable('offline_courses') ? OfflineCourse::query()->where('is_active', true)->count() : 0,
                'featured_faculty' => $hasFacultyColumns ? User::query()->where('show_on_homepage', true)->count() : 0,
                'new_inquiries' => $baseContacts
                    ? ($hasContactStatusColumn ? (clone $baseContacts)->where('status', 'new')->count() : (clone $baseContacts)->count())
                    : 0,
                'workshop_leads' => $baseContacts
                    ? ($hasContactTopicColumn ? (clone $baseContacts)->where('topic', 'workshop')->count() : 0)
                    : 0,
                'career_leads' => $baseContacts
                    ? ($hasContactTopicColumn ? (clone $baseContacts)->where('topic', 'career')->count() : 0)
                    : 0,
                'mentorship_leads' => $baseContacts
                    ? ($hasContactTopicColumn ? (clone $baseContacts)->where('topic', 'mentorship')->count() : 0)
                    : 0,
            ],
            'recentContacts' => $hasPublicContactsTable
                ? PublicContact::query()->latest()->take(6)->get()
                : collect(),
        ]);
    }

    public function slides(Request $request): View
    {
        $user = $request->user();

        return view('hr.slides', [
            'user' => $user,
            'profileAvatar' => $user->avatarUrl(96),
            'slides' => Schema::hasTable('home_slides')
                ? HomeSlide::query()->orderBy('sort_order')->latest('id')->paginate(5)->withQueryString()->fragment('slides-table')
                : collect(),
            'editingSlide' => Schema::hasTable('home_slides') && $request->filled('edit')
                ? HomeSlide::query()->find($request->integer('edit'))
                : null,
        ]);
    }

    public function founderMedia(Request $request): View
    {
        $user = $request->user();

        return view('hr.founder-media', [
            'user' => $user,
            'profileAvatar' => $user->avatarUrl(96),
            'founderMedia' => Schema::hasTable('home_founder_media')
                ? HomeFounderMedia::query()->latest('id')->first()
                : null,
        ]);
    }

    public function updateFounderMedia(Request $request): RedirectResponse
    {
        abort_unless(Schema::hasTable('home_founder_media'), 503, 'Run migrations to enable founder media management.');

        $record = HomeFounderMedia::query()->latest('id')->first();

        try {
            $validated = $request->validate([
                'eyebrow' => ['nullable', 'string', 'max:255'],
                'title' => ['nullable', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:2000'],
                'badge' => ['nullable', 'string', 'max:255'],
                'video_provider' => ['nullable', 'in:url,local,cloud'],
                'video_url' => ['nullable', 'string', 'max:2000'],
                'video_file' => ['nullable', 'file', 'max:153600', 'mimetypes:video/mp4,video/webm,video/ogg,video/quicktime'],
                'poster_provider' => ['nullable', 'in:url,local,cloud'],
                'poster_url' => ['nullable', 'string', 'max:2000'],
                'poster_file' => ['nullable', 'file', 'max:51200', 'mimetypes:image/jpeg,image/png,image/webp,image/gif'],
                'is_active' => ['nullable', 'boolean'],
            ]);

            $validated['is_active'] = $request->boolean('is_active');
            $validated['video_provider'] = $validated['video_provider'] ?? ($record->video_provider ?? 'url');
            $validated['poster_provider'] = $validated['poster_provider'] ?? ($record->poster_provider ?? 'url');
            $validated['video_url'] = $this->resolveUploadedMedia(
                $request,
                'video_url',
                'video_file',
                $validated['video_provider'],
                'home/founder',
                ($validated['title'] ?? 'founder-video').'-video',
                $record->video_url ?? null
            );
            $validated['poster_url'] = $this->resolveUploadedMedia(
                $request,
                'poster_url',
                'poster_file',
                $validated['poster_provider'],
                'home/founder',
                ($validated['title'] ?? 'founder-video').'-poster',
                $record->poster_url ?? null
            );

            unset($validated['video_file'], $validated['poster_file']);

            if ($record) {
                $record->update($validated);
            } else {
                HomeFounderMedia::query()->create($validated);
            }
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->withErrors(['founder_media' => $exception->getMessage()]);
        }

        return redirect()->route('hr.founder-media')->with('status', 'Founder media updated successfully.');
    }

    public function storeSlide(Request $request): RedirectResponse
    {
        abort_unless(Schema::hasTable('home_slides'), 503, 'Run migrations to enable slide management.');
        HomeSlide::query()->create($this->validateSlide($request));

        return redirect()->route('hr.slides')->with('status', 'Home slide created successfully.');
    }

    public function updateSlide(Request $request, HomeSlide $slide): RedirectResponse
    {
        abort_unless(Schema::hasTable('home_slides'), 503, 'Run migrations to enable slide management.');
        $slide->update($this->validateSlide($request));

        return redirect()->route('hr.slides')->with('status', 'Home slide updated successfully.');
    }

    public function destroySlide(HomeSlide $slide): RedirectResponse
    {
        abort_unless(Schema::hasTable('home_slides'), 503, 'Run migrations to enable slide management.');
        $slide->delete();

        return redirect()->route('hr.slides')->with('status', 'Home slide removed successfully.');
    }

    public function jobs(Request $request): View
    {
        $user = $request->user();

        return view('hr.jobs', [
            'user' => $user,
            'profileAvatar' => $user->avatarUrl(96),
            'jobs' => Schema::hasTable('job_openings')
                ? JobOpening::query()->orderBy('sort_order')->latest('id')->paginate(5)->withQueryString()->fragment('jobs-table')
                : collect(),
            'editingJob' => Schema::hasTable('job_openings') && $request->filled('edit')
                ? JobOpening::query()->find($request->integer('edit'))
                : null,
        ]);
    }

    public function storeJob(Request $request): RedirectResponse
    {
        abort_unless(Schema::hasTable('job_openings'), 503, 'Run migrations to enable job management.');
        JobOpening::query()->create($this->validateJob($request));

        return redirect()->route('hr.jobs')->with('status', 'Job posting created successfully.');
    }

    public function updateJob(Request $request, JobOpening $job): RedirectResponse
    {
        abort_unless(Schema::hasTable('job_openings'), 503, 'Run migrations to enable job management.');
        $job->update($this->validateJob($request));

        return redirect()->route('hr.jobs')->with('status', 'Job posting updated successfully.');
    }

    public function destroyJob(JobOpening $job): RedirectResponse
    {
        abort_unless(Schema::hasTable('job_openings'), 503, 'Run migrations to enable job management.');
        $job->delete();

        return redirect()->route('hr.jobs')->with('status', 'Job posting removed successfully.');
    }

    public function stories(Request $request): View
    {
        $user = $request->user();
        $storyFilter = (string) $request->query('type', 'placement');
        if (! in_array($storyFilter, ['placement', 'success_story'], true)) {
            $storyFilter = 'placement';
        }

        return view('hr.stories', [
            'user' => $user,
            'profileAvatar' => $user->avatarUrl(96),
            'stories' => Schema::hasTable('home_stories')
                ? HomeStory::query()
                    ->where('type', $storyFilter)
                    ->orderBy('sort_order')
                    ->latest('id')
                    ->paginate(5)
                    ->withQueryString()
                    ->fragment('stories-table')
                : collect(),
            'storyFilter' => $storyFilter,
            'editingStory' => Schema::hasTable('home_stories') && $request->filled('edit')
                ? HomeStory::query()->find($request->integer('edit'))
                : null,
        ]);
    }

    public function storeStory(Request $request): RedirectResponse
    {
        abort_unless(Schema::hasTable('home_stories'), 503, 'Run migrations to enable story management.');

        try {
            HomeStory::query()->create($this->validateStory($request));
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->withErrors(['story' => $exception->getMessage()]);
        }

        return redirect()->route('hr.stories')->with('status', 'Homepage story created successfully.');
    }

    public function updateStory(Request $request, HomeStory $story): RedirectResponse
    {
        abort_unless(Schema::hasTable('home_stories'), 503, 'Run migrations to enable story management.');

        try {
            $story->update($this->validateStory($request, $story));
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->withErrors(['story' => $exception->getMessage()]);
        }

        return redirect()->route('hr.stories')->with('status', 'Homepage story updated successfully.');
    }

    public function destroyStory(HomeStory $story): RedirectResponse
    {
        abort_unless(Schema::hasTable('home_stories'), 503, 'Run migrations to enable story management.');
        $story->delete();

        return redirect()->route('hr.stories')->with('status', 'Homepage story removed successfully.');
    }

    public function achievements(Request $request): View
    {
        $user = $request->user();
        $achievementFilter = (string) $request->query('kind', 'gallery');
        $hasCategoryOrderColumn = Schema::hasTable('home_achievements') && Schema::hasColumn('home_achievements', 'gallery_category_order');
        if (! in_array($achievementFilter, ['gallery', 'showcase'], true)) {
            $achievementFilter = 'gallery';
        }

        return view('hr.achievements', [
            'user' => $user,
            'profileAvatar' => $user->avatarUrl(96),
            'achievements' => Schema::hasTable('home_achievements')
                ? HomeAchievement::query()
                    ->where('kind', $achievementFilter)
                    ->orderBy('sort_order')
                    ->latest('id')
                    ->paginate(5)
                    ->withQueryString()
                    ->fragment('achievements-table')
                : collect(),
            'achievementFilter' => $achievementFilter,
            'achievementCategories' => Schema::hasTable('home_achievements')
                ? HomeAchievement::query()
                    ->where('kind', 'gallery')
                    ->whereNotNull('gallery_category')
                    ->where('gallery_category', '!=', '')
                    ->when($hasCategoryOrderColumn, fn ($query) => $query->orderBy('gallery_category_order'))
                    ->orderBy('gallery_category')
                    ->distinct()
                    ->pluck('gallery_category')
                : collect(),
            'editingAchievement' => Schema::hasTable('home_achievements') && $request->filled('edit')
                ? HomeAchievement::query()->find($request->integer('edit'))
                : null,
        ]);
    }

    public function storeAchievement(Request $request): RedirectResponse
    {
        abort_unless(Schema::hasTable('home_achievements'), 503, 'Run migrations to enable achievement management.');

        try {
            HomeAchievement::query()->create($this->validateAchievement($request));
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->withErrors(['achievement' => $exception->getMessage()]);
        }

        return redirect()->route('hr.achievements')->with('status', 'Achievement content created successfully.');
    }

    public function updateAchievement(Request $request, HomeAchievement $achievement): RedirectResponse
    {
        abort_unless(Schema::hasTable('home_achievements'), 503, 'Run migrations to enable achievement management.');

        try {
            $achievement->update($this->validateAchievement($request, $achievement));
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->withErrors(['achievement' => $exception->getMessage()]);
        }

        return redirect()->route('hr.achievements')->with('status', 'Achievement content updated successfully.');
    }

    public function destroyAchievement(HomeAchievement $achievement): RedirectResponse
    {
        abort_unless(Schema::hasTable('home_achievements'), 503, 'Run migrations to enable achievement management.');
        $achievement->delete();

        return redirect()->route('hr.achievements')->with('status', 'Achievement content removed successfully.');
    }

    public function faculty(Request $request): View
    {
        $user = $request->user();
        $instructorRoleId = Role::query()->where('name', 'instructor')->value('id');

        return view('hr.faculty', [
            'user' => $user,
            'profileAvatar' => $user->avatarUrl(96),
            'facultyMembers' => $this->facultyMembers($instructorRoleId),
        ]);
    }

    public function updateFaculty(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role?->name === 'instructor', 404);
        abort_unless(
            Schema::hasColumn('users', 'show_on_homepage')
            && Schema::hasColumn('users', 'faculty_sort_order')
            && Schema::hasColumn('users', 'faculty_headline'),
            503,
            'Run migrations to enable faculty management.'
        );

        $validated = $request->validate([
            'show_on_homepage' => ['nullable', 'boolean'],
            'faculty_sort_order' => ['nullable', 'integer', 'min:0'],
            'faculty_headline' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update([
            'show_on_homepage' => $request->boolean('show_on_homepage'),
            'faculty_sort_order' => $validated['faculty_sort_order'] ?? 0,
            'faculty_headline' => $validated['faculty_headline'] ?? null,
            'bio' => $validated['bio'] ?? null,
        ]);

        return redirect()->route('hr.faculty')->with('status', 'Faculty card updated successfully.');
    }

    public function workshops(Request $request): View
    {
        $user = $request->user();

        return view('hr.workshops', [
            'user' => $user,
            'profileAvatar' => $user->avatarUrl(96),
            'workshops' => Schema::hasTable('workshops')
                ? Workshop::query()->orderBy('sort_order')->latest('id')->paginate(5)->withQueryString()->fragment('workshops-table')
                : collect(),
            'editingWorkshop' => Schema::hasTable('workshops') && $request->filled('edit')
                ? Workshop::query()->find($request->integer('edit'))
                : null,
        ]);
    }

    public function offlineCourses(Request $request): View
    {
        $user = $request->user();

        return view('hr.offline-courses', [
            'user' => $user,
            'profileAvatar' => $user->avatarUrl(96),
            'offlineCourses' => Schema::hasTable('offline_courses')
                ? OfflineCourse::query()
                    ->with('category:id,name')
                    ->orderBy('sort_order')
                    ->latest('id')
                    ->paginate(8)
                    ->withQueryString()
                    ->fragment('offline-courses-table')
                : collect(),
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
            'editingCourse' => Schema::hasTable('offline_courses') && $request->filled('edit')
                ? OfflineCourse::query()->find($request->integer('edit'))
                : null,
            'platformSettings' => [
                'catalog_default_mode' => PlatformSettings::string('catalog_default_mode', 'offline'),
                'catalog_online_enabled' => PlatformSettings::bool('catalog_online_enabled', false),
                'catalog_offline_enabled' => PlatformSettings::bool('catalog_offline_enabled', true),
                'online_student_access_mode' => PlatformSettings::string('online_student_access_mode', 'disabled'),
                'student_catalog_enabled' => PlatformSettings::bool('student_catalog_enabled', false),
                'student_wishlist_enabled' => PlatformSettings::bool('student_wishlist_enabled', false),
                'student_cart_enabled' => PlatformSettings::bool('student_cart_enabled', false),
                'student_checkout_enabled' => PlatformSettings::bool('student_checkout_enabled', false),
                'student_payments_enabled' => PlatformSettings::bool('student_payments_enabled', false),
            ],
        ]);
    }

    public function storeWorkshop(Request $request): RedirectResponse
    {
        abort_unless(Schema::hasTable('workshops'), 503, 'Run migrations to enable workshop management.');
        Workshop::query()->create($this->validateWorkshop($request));

        return redirect()->route('hr.workshops')->with('status', 'Workshop created successfully.');
    }

    public function updateWorkshop(Request $request, Workshop $workshop): RedirectResponse
    {
        abort_unless(Schema::hasTable('workshops'), 503, 'Run migrations to enable workshop management.');
        $workshop->update($this->validateWorkshop($request));

        return redirect()->route('hr.workshops')->with('status', 'Workshop updated successfully.');
    }

    public function destroyWorkshop(Workshop $workshop): RedirectResponse
    {
        abort_unless(Schema::hasTable('workshops'), 503, 'Run migrations to enable workshop management.');
        $workshop->delete();

        return redirect()->route('hr.workshops')->with('status', 'Workshop removed successfully.');
    }

    public function storeOfflineCourse(Request $request): RedirectResponse
    {
        abort_unless(Schema::hasTable('offline_courses'), 503, 'Run migrations to enable offline course management.');
        OfflineCourse::query()->create($this->validateOfflineCourse($request));

        return redirect()->route('hr.offline-courses')->with('status', 'Offline course created successfully.');
    }

    public function updateOfflineCourse(Request $request, OfflineCourse $offlineCourse): RedirectResponse
    {
        abort_unless(Schema::hasTable('offline_courses'), 503, 'Run migrations to enable offline course management.');
        $offlineCourse->update($this->validateOfflineCourse($request, $offlineCourse));

        return redirect()->route('hr.offline-courses')->with('status', 'Offline course updated successfully.');
    }

    public function destroyOfflineCourse(OfflineCourse $offlineCourse): RedirectResponse
    {
        abort_unless(Schema::hasTable('offline_courses'), 503, 'Run migrations to enable offline course management.');
        $offlineCourse->delete();

        return redirect()->route('hr.offline-courses')->with('status', 'Offline course removed successfully.');
    }

    public function updateCoursePlatformSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'catalog_default_mode' => ['required', 'in:offline,online'],
            'catalog_online_enabled' => ['nullable', 'boolean'],
            'catalog_offline_enabled' => ['nullable', 'boolean'],
            'online_student_access_mode' => ['required', 'in:disabled,limited'],
            'student_catalog_enabled' => ['nullable', 'boolean'],
            'student_wishlist_enabled' => ['nullable', 'boolean'],
            'student_cart_enabled' => ['nullable', 'boolean'],
            'student_checkout_enabled' => ['nullable', 'boolean'],
            'student_payments_enabled' => ['nullable', 'boolean'],
        ]);

        if (! $request->boolean('catalog_online_enabled') && $validated['online_student_access_mode'] === 'disabled') {
            $validated['student_catalog_enabled'] = false;
            $validated['student_wishlist_enabled'] = false;
            $validated['student_cart_enabled'] = false;
            $validated['student_checkout_enabled'] = false;
            $validated['student_payments_enabled'] = false;
        }

        foreach ([
            'catalog_default_mode',
            'online_student_access_mode',
            'catalog_online_enabled',
            'catalog_offline_enabled',
            'student_catalog_enabled',
            'student_wishlist_enabled',
            'student_cart_enabled',
            'student_checkout_enabled',
            'student_payments_enabled',
        ] as $key) {
            $value = in_array($key, [
                'catalog_online_enabled',
                'catalog_offline_enabled',
                'student_catalog_enabled',
                'student_wishlist_enabled',
                'student_cart_enabled',
                'student_checkout_enabled',
                'student_payments_enabled',
            ], true)
                ? ($request->boolean($key) ? '1' : '0')
                : (string) ($validated[$key] ?? '');

            AppSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Log::info('HR updated course platform settings', [
            'user_id' => $request->user()->id,
            'email' => $request->user()->email,
        ]);

        return redirect()->route('hr.offline-courses')->with('status', 'Course platform settings updated successfully.');
    }

    public function inquiries(Request $request): View
    {
        $user = $request->user();
        $topic = (string) $request->query('topic', '');
        $hasPublicContactsTable = Schema::hasTable('public_contacts');
        $hasAssignedToColumn = $hasPublicContactsTable && Schema::hasColumn('public_contacts', 'assigned_to');
        $hasTopicColumn = $hasPublicContactsTable && Schema::hasColumn('public_contacts', 'topic');

        return view('hr.inquiries', [
            'user' => $user,
            'profileAvatar' => $user->avatarUrl(96),
            'contacts' => $hasPublicContactsTable
                ? PublicContact::query()
                    ->with(array_filter([
                        'course:id,title',
                        $hasAssignedToColumn ? 'assignee:id,name' : null,
                    ]))
                    ->when($topic !== '' && $hasTopicColumn, fn ($query) => $query->where('topic', $topic))
                    ->latest()
                    ->paginate(12)
                    ->withQueryString()
                : $this->emptyPaginator(),
            'filterTopic' => $topic,
            'hrUsers' => User::query()
                ->whereHas('role', fn ($query) => $query->whereIn('name', ['hr team', 'admin', 'super admin']))
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function mentorship(Request $request): View
    {
        $request->merge(['topic' => 'mentorship']);

        return $this->inquiries($request);
    }

    public function workshopLeads(Request $request): View
    {
        $request->merge(['topic' => 'workshop']);

        return $this->inquiries($request);
    }

    public function careerLeads(Request $request): View
    {
        $request->merge(['topic' => 'career']);

        return $this->inquiries($request);
    }

    public function updateInquiry(Request $request, PublicContact $contact): RedirectResponse
    {
        abort_unless(
            Schema::hasTable('public_contacts')
            && Schema::hasColumn('public_contacts', 'status')
            && Schema::hasColumn('public_contacts', 'assigned_to')
            && Schema::hasColumn('public_contacts', 'follow_up_at')
            && Schema::hasColumn('public_contacts', 'internal_notes'),
            503,
            'Run migrations to enable inquiry management.'
        );

        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,follow_up,closed'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
            'follow_up_at' => ['nullable', 'date'],
            'internal_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $contact->update([
            'status' => $validated['status'],
            'assigned_to' => $validated['assigned_to'] ?? null,
            'follow_up_at' => $validated['follow_up_at'] ?? null,
            'internal_notes' => $validated['internal_notes'] ?? null,
            'contacted_at' => $validated['status'] === 'contacted' ? now() : $contact->contacted_at,
        ]);

        return redirect()->back()->with('status', 'Inquiry updated successfully.');
    }

    private function validateSlide(Request $request): array
    {
        $validated = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'highlight' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'badge' => ['nullable', 'string', 'max:255'],
            'accent' => ['nullable', 'string', 'max:255'],
            'stat_label' => ['nullable', 'string', 'max:255'],
            'stat_value' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:2000'],
            'primary_url' => ['nullable', 'string', 'max:2000'],
            'primary_label' => ['nullable', 'string', 'max:255'],
            'secondary_url' => ['nullable', 'string', 'max:2000'],
            'secondary_label' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        return $validated;
    }

    private function validateJob(Request $request): array
    {
        $validated = $request->validate([
            'badge' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:255'],
            'work_mode' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'string', 'max:255'],
            'salary' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:3000'],
            'skills' => ['nullable', 'string', 'max:3000'],
            'color' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['skills'] = $this->normalizeListInput($validated['skills'] ?? '');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }

    private function validateWorkshop(Request $request): array
    {
        $validated = $request->validate([
            'badge' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:2000'],
            'date_label' => ['nullable', 'string', 'max:255'],
            'time_label' => ['nullable', 'string', 'max:255'],
            'format' => ['nullable', 'string', 'max:255'],
            'venue' => ['nullable', 'string', 'max:255'],
            'audience' => ['nullable', 'string', 'max:255'],
            'mentor' => ['nullable', 'string', 'max:255'],
            'seats' => ['nullable', 'string', 'max:255'],
            'accent' => ['nullable', 'string', 'max:255'],
            'highlights' => ['nullable', 'string', 'max:3000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['highlights'] = $this->normalizeListInput($validated['highlights'] ?? '');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }

    private function validateStory(Request $request, ?HomeStory $story = null): array
    {
        $validated = $request->validate([
            'type' => ['required', 'in:placement,success_story'],
            'name' => ['required', 'string', 'max:255'],
            'course' => ['nullable', 'string', 'max:255'],
            'comment' => ['required', 'string', 'max:3000'],
            'avatar' => ['nullable', 'string', 'max:2000'],
            'media_provider' => ['nullable', 'in:url,local,cloud'],
            'media_type' => ['nullable', 'in:image,video'],
            'media_file' => ['nullable', 'file', 'max:51200', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/ogg,video/quicktime'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'company' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'package' => ['nullable', 'string', 'max:255'],
            'shared_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'show_in_placement_hero' => ['nullable', 'boolean'],
        ]);

        $validated['rating'] = $validated['rating'] ?? 5;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['show_in_placement_hero'] = $validated['type'] === 'placement' ? $request->boolean('show_in_placement_hero') : false;
        $validated['media_provider'] = $validated['media_provider'] ?? ($story->media_provider ?? 'url');
        $validated['media_type'] = $validated['media_type'] ?? ($story->media_type ?? 'image');
        $validated['avatar'] = $this->resolveUploadedMedia(
            $request,
            'avatar',
            'media_file',
            $validated['media_provider'],
            'home/stories',
            $validated['name'],
            $story->avatar ?? null
        );

        if (($validated['type'] ?? null) !== 'placement') {
            $validated['company'] = null;
            $validated['role'] = null;
            $validated['package'] = null;
            $validated['shared_at'] = null;
        }

        return $validated;
    }

    private function validateOfflineCourse(Request $request, ?OfflineCourse $course = null): array
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:1200'],
            'details' => ['nullable', 'string', 'max:10000'],
            'thumbnail' => ['nullable', 'string', 'max:2000'],
            'thumbnail_provider' => ['nullable', 'in:url,local,cloud'],
            'thumbnail_file' => ['nullable', 'file', 'max:51200', 'mimetypes:image/jpeg,image/png,image/webp,image/gif'],
            'campus' => ['nullable', 'string', 'max:255'],
            'schedule_label' => ['nullable', 'string', 'max:255'],
            'duration_label' => ['nullable', 'string', 'max:255'],
            'validity_label' => ['nullable', 'string', 'max:255'],
            'delivery_mode' => ['nullable', 'string', 'max:255'],
            'placement_label' => ['nullable', 'string', 'max:255'],
            'audience' => ['nullable', 'string', 'max:255'],
            'batch_size' => ['nullable', 'string', 'max:255'],
            'language' => ['nullable', 'string', 'max:100'],
            'level' => ['nullable', 'string', 'max:100'],
            'highlights' => ['nullable', 'string', 'max:3000'],
            'additional_benefits' => ['nullable', 'string', 'max:4000'],
            'learner_note' => ['nullable', 'string', 'max:3000'],
            'curriculum_modules' => ['nullable', 'array'],
            'curriculum_modules.*.title' => ['nullable', 'string', 'max:255'],
            'curriculum_modules.*.duration' => ['nullable', 'string', 'max:255'],
            'curriculum_modules.*.topics' => ['nullable', 'string', 'max:4000'],
            'curriculum_modules.*.project' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['thumbnail_provider'] = $validated['thumbnail_provider'] ?? ($course?->thumbnail_provider ?? 'url');
        $validated['thumbnail'] = $this->resolveUploadedMedia(
            $request,
            'thumbnail',
            'thumbnail_file',
            $validated['thumbnail_provider'],
            'courses/offline',
            $validated['title'].'-thumbnail',
            $course?->thumbnail
        );
        $slugExists = OfflineCourse::query()
            ->where('slug', $validated['slug'])
            ->when($course, fn ($query) => $query->whereKeyNot($course->id))
            ->exists();

        if ($slugExists) {
            $validated['slug'] .= '-'.Str::lower(Str::random(4));
        }

        $validated['highlights'] = $this->normalizeListInput($validated['highlights'] ?? '');
        $validated['additional_benefits'] = $this->normalizeListInput($validated['additional_benefits'] ?? '');
        $validated['curriculum_modules'] = collect($validated['curriculum_modules'] ?? [])
            ->map(function (array $module) {
                $title = trim((string) ($module['title'] ?? ''));
                $duration = trim((string) ($module['duration'] ?? ''));
                $topics = $this->normalizeListInput((string) ($module['topics'] ?? ''));
                $project = trim((string) ($module['project'] ?? ''));

                if ($title === '' && $duration === '' && $topics === [] && $project === '') {
                    return null;
                }

                return [
                    'title' => $title,
                    'duration' => $duration,
                    'topics' => $topics,
                    'project' => $project,
                ];
            })
            ->filter()
            ->values()
            ->all();
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        unset($validated['thumbnail_provider'], $validated['thumbnail_file']);

        return $validated;
    }

    private function validateAchievement(Request $request, ?HomeAchievement $achievement = null): array
    {
        $hasCategoryOrderColumn = Schema::hasTable('home_achievements') && Schema::hasColumn('home_achievements', 'gallery_category_order');
        $validated = $request->validate([
            'kind' => ['required', 'in:gallery,showcase'],
            'category_mode' => ['nullable', 'in:existing,new'],
            'existing_category' => ['nullable', 'string', 'max:255'],
            'new_category' => ['nullable', 'string', 'max:255'],
            'gallery_category_order' => ['nullable', 'integer', 'min:0'],
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'copy' => ['nullable', 'string', 'max:3000'],
            'stat' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'points' => ['nullable', 'string', 'max:3000'],
            'media_url' => ['nullable', 'string', 'max:2000'],
            'media_provider' => ['nullable', 'in:url,local,cloud'],
            'media_type' => ['nullable', 'in:image,video'],
            'media_file' => ['nullable', 'file', 'max:153600', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,video/ogg,video/quicktime'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['points'] = $this->normalizeListInput($validated['points'] ?? '');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['media_provider'] = $validated['media_provider'] ?? ($achievement->media_provider ?? 'url');
        $validated['media_type'] = $validated['media_type'] ?? ($achievement->media_type ?? 'image');
        $validated['media_url'] = $this->resolveUploadedMedia(
            $request,
            'media_url',
            'media_file',
            $validated['media_provider'],
            'home/achievements',
            $validated['title'] ?? $validated['kind'],
            $achievement->media_url ?? null
        );

        $categoryMode = $validated['category_mode'] ?? 'existing';
        $existingCategory = trim((string) ($validated['existing_category'] ?? ''));
        $newCategory = trim((string) ($validated['new_category'] ?? ''));

        if (($validated['kind'] ?? null) === 'gallery') {
            $validated['gallery_category'] = $categoryMode === 'new' ? $newCategory : $existingCategory;
            $validated['gallery_category'] = $validated['gallery_category'] !== '' ? $validated['gallery_category'] : null;
            $validated['gallery_category_order'] = $hasCategoryOrderColumn ? ($validated['gallery_category_order'] ?? 0) : null;
        } else {
            $validated['gallery_category'] = null;
            $validated['gallery_category_order'] = $hasCategoryOrderColumn ? 0 : null;
        }

        if (($validated['kind'] ?? null) !== 'showcase') {
            $validated['eyebrow'] = null;
            $validated['copy'] = null;
            $validated['stat'] = null;
            $validated['icon'] = null;
            $validated['points'] = [];
        }

        unset($validated['category_mode'], $validated['existing_category'], $validated['new_category']);

        if (! $hasCategoryOrderColumn) {
            unset($validated['gallery_category_order']);
        }

        return $validated;
    }

    private function normalizeListInput(string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n|,/', $value) ?: [])
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    private function resolveUploadedMedia(
        Request $request,
        string $urlField,
        string $fileField,
        string $provider,
        string $folder,
        string $name,
        ?string $existing = null
    ): ?string {
        if ($provider === 'url') {
            return $request->input($urlField) ?: $existing;
        }

        if (! $request->hasFile($fileField)) {
            return $existing;
        }

        return $this->uploadContentMedia($request->file($fileField), $provider, $folder, $name);
    }

    private function uploadContentMedia(UploadedFile $file, string $provider, string $folder, string $name): string
    {
        $extension = strtolower((string) ($file->getClientOriginalExtension() ?: $file->extension() ?: 'bin'));
        $filename = Str::slug($name !== '' ? $name : 'media').'-'.Str::lower(Str::random(8)).'.'.$extension;
        $folder = trim($folder, '/');
        $path = $folder.'/'.$filename;

        if ($provider === 'cloud') {
            return CloudflareR2Storage::uploadPublicFile($file, $path);
        }

        if ($provider === 'local') {
            $stored = Storage::disk('public')->putFileAs($folder, $file, $filename, ['visibility' => 'public']);

            if (! $stored) {
                throw new RuntimeException('Local upload failed. Please try again.');
            }

            return Storage::disk('public')->url($stored);
        }

        throw new RuntimeException('Unsupported media provider selected.');
    }

    private function facultyMembers(?int $instructorRoleId): Collection
    {
        if (! $instructorRoleId) {
            return collect();
        }

        $query = User::query()
            ->where('role_id', $instructorRoleId)
            ->withCount(['courses' => fn ($builder) => $builder->where('status', 'published')]);

        if (Schema::hasColumn('users', 'show_on_homepage')) {
            $query->orderByDesc('show_on_homepage');
        }

        if (Schema::hasColumn('users', 'faculty_sort_order')) {
            $query->orderBy('faculty_sort_order');
        }

        return $query
            ->orderBy('name')
            ->get();
    }

    private function emptyPaginator(): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            collect(),
            0,
            12,
            1,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }
}
