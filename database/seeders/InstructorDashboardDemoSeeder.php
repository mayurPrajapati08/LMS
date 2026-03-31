<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstructorDashboardDemoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $instructorRoleId = DB::table('roles')->where('name', 'instructor')->value('id');
        $userRoleId = DB::table('roles')->where('name', 'user')->value('id');

        if (! $instructorRoleId || ! $userRoleId) {
            return;
        }

        $instructorId = $this->upsertUser(
            'Mukesh Patel',
            'joshipatel348@gmail.com',
            '12345678',
            $instructorRoleId,
            $now
        );

        $studentOneId = $this->upsertUser(
            'Sasha Romanoff',
            'sasha.student@example.com',
            '12345678',
            $userRoleId,
            $now
        );

        $studentTwoId = $this->upsertUser(
            'Liam Carter',
            'liam.student@example.com',
            '12345678',
            $userRoleId,
            $now
        );

        $studentThreeId = $this->upsertUser(
            'Emma Watson',
            'emma.student@example.com',
            '12345678',
            $userRoleId,
            $now
        );

        $studentFourId = $this->upsertUser(
            'Jacob Henderson',
            'jacob.student@example.com',
            '12345678',
            $userRoleId,
            $now
        );

        $categoryIds = DB::table('categories')
            ->whereIn('name', ['Web Development', 'Full Stack Development', 'Data Science'])
            ->pluck('id', 'name');

        $courses = [
            [
                'title' => 'Mastering Typography',
                'slug' => 'mastering-typography',
                'details' => 'A premium editorial course covering layouts, hierarchy, readability, and client-ready design systems.',
                'thumbnail' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1200&q=80',
                'price' => 149.00,
                'status' => 'published',
                'level' => 'intermediate',
                'language' => 'English',
                'total_duration' => 5400,
                'validity_in_days' => 365,
                'created_at' => $now->copy()->subDays(70),
                'updated_at' => $now,
                'category_id' => $categoryIds['Web Development'] ?? $categoryIds->first(),
            ],
            [
                'title' => 'Editorial Strategy',
                'slug' => 'editorial-strategy',
                'details' => 'A practical framework for research-backed editorial planning, content operations, and publishing workflows.',
                'thumbnail' => 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=1200&q=80',
                'price' => 199.00,
                'status' => 'published',
                'level' => 'advanced',
                'language' => 'English',
                'total_duration' => 6900,
                'validity_in_days' => 365,
                'created_at' => $now->copy()->subDays(45),
                'updated_at' => $now,
                'category_id' => $categoryIds['Full Stack Development'] ?? $categoryIds->first(),
            ],
            [
                'title' => 'Advanced Design Systems',
                'slug' => 'advanced-design-systems',
                'details' => 'Learn scalable component thinking, documentation standards, and product-ready design governance.',
                'thumbnail' => 'https://images.unsplash.com/photo-1558655146-9f40138edfeb?auto=format&fit=crop&w=1200&q=80',
                'price' => 179.00,
                'status' => 'draft',
                'level' => 'advanced',
                'language' => 'English',
                'total_duration' => 4200,
                'validity_in_days' => 180,
                'created_at' => $now->copy()->subDays(10),
                'updated_at' => $now,
                'category_id' => $categoryIds['Data Science'] ?? $categoryIds->first(),
            ],
        ];

        $courseIds = [];

        foreach ($courses as $course) {
            $existingId = DB::table('courses')->where('slug', $course['slug'])->value('id');

            DB::table('courses')->updateOrInsert(
                ['slug' => $course['slug']],
                array_merge($course, [
                    'user_id' => $instructorId,
                ])
            );

            $courseIds[$course['slug']] = $existingId ?: DB::table('courses')->where('slug', $course['slug'])->value('id');
        }

        $sections = [
            [
                'course_id' => $courseIds['mastering-typography'],
                'title' => 'Typography Foundations',
                'order_number' => 1,
            ],
            [
                'course_id' => $courseIds['mastering-typography'],
                'title' => 'Layout Systems',
                'order_number' => 2,
            ],
            [
                'course_id' => $courseIds['editorial-strategy'],
                'title' => 'Editorial Research',
                'order_number' => 1,
            ],
            [
                'course_id' => $courseIds['editorial-strategy'],
                'title' => 'Publishing Workflow',
                'order_number' => 2,
            ],
        ];

        $sectionIds = [];

        foreach ($sections as $section) {
            DB::table('sections')->updateOrInsert(
                [
                    'course_id' => $section['course_id'],
                    'title' => $section['title'],
                ],
                [
                    'order_number' => $section['order_number'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $sectionIds[$section['course_id'].'-'.$section['title']] = DB::table('sections')
                ->where('course_id', $section['course_id'])
                ->where('title', $section['title'])
                ->value('id');
        }

        $videos = [
            [
                'section_id' => $sectionIds[$courseIds['mastering-typography'].'-Typography Foundations'],
                'upload_by' => $instructorId,
                'title' => 'Type Hierarchy Essentials',
                'video_url' => 'https://example.com/demo/type-hierarchy.mp4',
                'order_number' => 1,
                'duration' => 780,
            ],
            [
                'section_id' => $sectionIds[$courseIds['mastering-typography'].'-Typography Foundations'],
                'upload_by' => $instructorId,
                'title' => 'Grid Rhythm in Practice',
                'video_url' => 'https://example.com/demo/grid-rhythm.mp4',
                'order_number' => 2,
                'duration' => 940,
            ],
            [
                'section_id' => $sectionIds[$courseIds['mastering-typography'].'-Layout Systems'],
                'upload_by' => $instructorId,
                'title' => 'Editorial Page Structure',
                'video_url' => 'https://example.com/demo/page-structure.mp4',
                'order_number' => 1,
                'duration' => 860,
            ],
            [
                'section_id' => $sectionIds[$courseIds['editorial-strategy'].'-Editorial Research'],
                'upload_by' => $instructorId,
                'title' => 'Research Workflow Basics',
                'video_url' => 'https://example.com/demo/research-workflow.mp4',
                'order_number' => 1,
                'duration' => 810,
            ],
            [
                'section_id' => $sectionIds[$courseIds['editorial-strategy'].'-Editorial Research'],
                'upload_by' => $instructorId,
                'title' => 'Audience Intent Mapping',
                'video_url' => 'https://example.com/demo/audience-intent.mp4',
                'order_number' => 2,
                'duration' => 925,
            ],
            [
                'section_id' => $sectionIds[$courseIds['editorial-strategy'].'-Publishing Workflow'],
                'upload_by' => $instructorId,
                'title' => 'Production Checklist',
                'video_url' => 'https://example.com/demo/production-checklist.mp4',
                'order_number' => 1,
                'duration' => 730,
            ],
        ];

        $videoIds = [];

        foreach ($videos as $video) {
            DB::table('videos')->updateOrInsert(
                [
                    'section_id' => $video['section_id'],
                    'title' => $video['title'],
                ],
                [
                    'upload_by' => $video['upload_by'],
                    'thumbnail_url' => null,
                    'video_url' => $video['video_url'],
                    'order_number' => $video['order_number'],
                    'duration' => $video['duration'],
                    'is_preview' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $videoIds[$video['title']] = DB::table('videos')
                ->where('section_id', $video['section_id'])
                ->where('title', $video['title'])
                ->value('id');
        }

        $payments = [
            [
                'payment_id' => 'demo-pay-1001',
                'user_id' => $studentOneId,
                'course_id' => $courseIds['mastering-typography'],
                'payment_getway' => 'stripe',
                'amount' => 149.00,
                'status' => 'completed',
                'created_at' => $now->copy()->subDays(2),
            ],
            [
                'payment_id' => 'demo-pay-1002',
                'user_id' => $studentTwoId,
                'course_id' => $courseIds['editorial-strategy'],
                'payment_getway' => 'razorpay',
                'amount' => 199.00,
                'status' => 'completed',
                'created_at' => $now->copy()->subHours(14),
            ],
            [
                'payment_id' => 'demo-pay-1003',
                'user_id' => $studentThreeId,
                'course_id' => $courseIds['mastering-typography'],
                'payment_getway' => 'stripe',
                'amount' => 149.00,
                'status' => 'completed',
                'created_at' => $now->copy()->subHours(3),
            ],
            [
                'payment_id' => 'demo-pay-1004',
                'user_id' => $studentFourId,
                'course_id' => $courseIds['editorial-strategy'],
                'payment_getway' => 'stripe',
                'amount' => 199.00,
                'status' => 'failed',
                'created_at' => $now->copy()->subDays(6),
            ],
            [
                'payment_id' => 'demo-pay-1005',
                'user_id' => $studentOneId,
                'course_id' => $courseIds['editorial-strategy'],
                'payment_getway' => 'razorpay',
                'amount' => 199.00,
                'status' => 'completed',
                'created_at' => $now->copy()->subHours(20),
            ],
            [
                'payment_id' => 'demo-pay-1006',
                'user_id' => $studentFourId,
                'course_id' => $courseIds['mastering-typography'],
                'payment_getway' => 'stripe',
                'amount' => 149.00,
                'status' => 'completed',
                'created_at' => $now->copy()->subHours(10),
            ],
        ];

        $paymentIds = [];

        foreach ($payments as $payment) {
            DB::table('payments')->updateOrInsert(
                ['payment_id' => $payment['payment_id']],
                [
                    'user_id' => $payment['user_id'],
                    'course_id' => $payment['course_id'],
                    'payment_getway' => $payment['payment_getway'],
                    'amount' => $payment['amount'],
                    'status' => $payment['status'],
                    'created_at' => $payment['created_at'],
                    'updated_at' => $now,
                ]
            );

            $paymentIds[$payment['payment_id']] = DB::table('payments')->where('payment_id', $payment['payment_id'])->value('id');
        }

        $enrollments = [
            [
                'user_id' => $studentOneId,
                'course_id' => $courseIds['mastering-typography'],
                'payment_table_id' => $paymentIds['demo-pay-1001'],
                'amount' => 149.00,
                'status' => 'completed',
                'enrolled_at' => $now->copy()->subDays(2),
                'expiry_date' => $now->copy()->addMonths(11),
            ],
            [
                'user_id' => $studentTwoId,
                'course_id' => $courseIds['editorial-strategy'],
                'payment_table_id' => $paymentIds['demo-pay-1002'],
                'amount' => 199.00,
                'status' => 'completed',
                'enrolled_at' => $now->copy()->subHours(14),
                'expiry_date' => $now->copy()->addMonths(12),
            ],
            [
                'user_id' => $studentThreeId,
                'course_id' => $courseIds['mastering-typography'],
                'payment_table_id' => $paymentIds['demo-pay-1003'],
                'amount' => 149.00,
                'status' => 'completed',
                'enrolled_at' => $now->copy()->subHours(3),
                'expiry_date' => $now->copy()->addMonths(10),
            ],
            [
                'user_id' => $studentOneId,
                'course_id' => $courseIds['editorial-strategy'],
                'payment_table_id' => $paymentIds['demo-pay-1005'],
                'amount' => 199.00,
                'status' => 'completed',
                'enrolled_at' => $now->copy()->subHours(20),
                'expiry_date' => $now->copy()->addMonths(12),
            ],
            [
                'user_id' => $studentFourId,
                'course_id' => $courseIds['mastering-typography'],
                'payment_table_id' => $paymentIds['demo-pay-1006'],
                'amount' => 149.00,
                'status' => 'completed',
                'enrolled_at' => $now->copy()->subHours(10),
                'expiry_date' => $now->copy()->addMonths(12),
            ],
        ];

        foreach ($enrollments as $enrollment) {
            DB::table('enrollments')->updateOrInsert(
                [
                    'user_id' => $enrollment['user_id'],
                    'course_id' => $enrollment['course_id'],
                ],
                [
                    'payment_table_id' => $enrollment['payment_table_id'],
                    'amount' => $enrollment['amount'],
                    'status' => $enrollment['status'],
                    'enrolled_at' => $enrollment['enrolled_at'],
                    'expiry_date' => $enrollment['expiry_date'],
                    'created_at' => $enrollment['enrolled_at'],
                    'updated_at' => $now,
                ]
            );
        }

        $progressRows = [
            [$studentOneId, $courseIds['mastering-typography'], $videoIds['Type Hierarchy Essentials'], 780, true],
            [$studentOneId, $courseIds['mastering-typography'], $videoIds['Grid Rhythm in Practice'], 940, true],
            [$studentOneId, $courseIds['mastering-typography'], $videoIds['Editorial Page Structure'], 620, false],
            [$studentTwoId, $courseIds['editorial-strategy'], $videoIds['Research Workflow Basics'], 810, true],
            [$studentTwoId, $courseIds['editorial-strategy'], $videoIds['Audience Intent Mapping'], 610, false],
            [$studentTwoId, $courseIds['editorial-strategy'], $videoIds['Production Checklist'], 0, false],
            [$studentThreeId, $courseIds['mastering-typography'], $videoIds['Type Hierarchy Essentials'], 780, true],
            [$studentThreeId, $courseIds['mastering-typography'], $videoIds['Grid Rhythm in Practice'], 940, true],
            [$studentThreeId, $courseIds['mastering-typography'], $videoIds['Editorial Page Structure'], 860, true],
            [$studentOneId, $courseIds['editorial-strategy'], $videoIds['Research Workflow Basics'], 810, true],
            [$studentOneId, $courseIds['editorial-strategy'], $videoIds['Audience Intent Mapping'], 925, true],
            [$studentOneId, $courseIds['editorial-strategy'], $videoIds['Production Checklist'], 330, false],
            [$studentFourId, $courseIds['mastering-typography'], $videoIds['Type Hierarchy Essentials'], 520, false],
        ];

        foreach ($progressRows as [$userId, $courseId, $videoId, $watchedDuration, $isCompleted]) {
            DB::table('course_progress')->updateOrInsert(
                [
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'video_id' => $videoId,
                ],
                [
                    'watched_durations' => $watchedDuration,
                    'is_completed' => $isCompleted,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $reviews = [
            [
                'user_id' => $studentFourId,
                'course_id' => $courseIds['mastering-typography'],
                'rating' => 5,
                'comment' => 'Life changing content! The structure is clear and I could apply the lessons immediately.',
                'created_at' => $now->copy()->subDay(),
            ],
            [
                'user_id' => $studentTwoId,
                'course_id' => $courseIds['editorial-strategy'],
                'rating' => 4,
                'comment' => 'Highly professional approach with strong examples. I would love a few more live sessions.',
                'created_at' => $now->copy()->subDays(3),
            ],
        ];

        foreach ($reviews as $review) {
            DB::table('reviews')->updateOrInsert(
                [
                    'user_id' => $review['user_id'],
                    'course_id' => $review['course_id'],
                ],
                [
                    'rating' => $review['rating'],
                    'comment' => $review['comment'],
                    'created_at' => $review['created_at'],
                    'updated_at' => $now,
                ]
            );
        }

        DB::table('certificates')->updateOrInsert(
            [
                'user_id' => $studentThreeId,
                'course_id' => $courseIds['mastering-typography'],
            ],
            [
                'certificate_url' => 'https://example.com/certificates/mastering-typography-emma.pdf',
                'issued_at' => $now->copy()->subHour(),
                'created_at' => $now->copy()->subHour(),
                'updated_at' => $now,
            ]
        );

        $wishlists = [
            ['user_id' => $studentOneId, 'course_id' => $courseIds['editorial-strategy']],
            ['user_id' => $studentTwoId, 'course_id' => $courseIds['mastering-typography']],
            ['user_id' => $studentThreeId, 'course_id' => $courseIds['editorial-strategy']],
            ['user_id' => $studentFourId, 'course_id' => $courseIds['mastering-typography']],
            ['user_id' => $studentFourId, 'course_id' => $courseIds['advanced-design-systems']],
        ];

        foreach ($wishlists as $wishlist) {
            DB::table('wishlists')->updateOrInsert(
                [
                    'user_id' => $wishlist['user_id'],
                    'course_id' => $wishlist['course_id'],
                ],
                [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $inquiries = [
            [
                'user_id' => $studentOneId,
                'course_id' => $courseIds['mastering-typography'],
                'name' => 'Sasha Romanoff',
                'email' => 'sasha.student@example.com',
                'phone' => null,
                'message' => 'Could you explain the final typography assignment structure once more? I want to be sure I am following the expected layout system.',
                'status' => 'pending',
                'admin_reply' => null,
                'created_at' => $now->copy()->subHours(3),
            ],
            [
                'user_id' => $studentTwoId,
                'course_id' => $courseIds['editorial-strategy'],
                'name' => 'Liam Carter',
                'email' => 'liam.student@example.com',
                'phone' => null,
                'message' => 'Should the content calendar be submitted as a spreadsheet or PDF? The workflow lesson was very helpful but I want to confirm the final format.',
                'status' => 'resolved',
                'admin_reply' => 'Please submit the content calendar as a spreadsheet so the structure and formulas are easier to review.',
                'created_at' => $now->copy()->subDay(),
            ],
            [
                'user_id' => $studentThreeId,
                'course_id' => $courseIds['mastering-typography'],
                'name' => 'Emma Watson',
                'email' => 'emma.student@example.com',
                'phone' => null,
                'message' => 'I am unsure whether the spacing scale should remain fixed between the mobile and desktop examples. Could you clarify that section?',
                'status' => 'pending',
                'admin_reply' => null,
                'created_at' => $now->copy()->subHours(8),
            ],
        ];

        foreach ($inquiries as $inquiry) {
            DB::table('course_inquiries')->updateOrInsert(
                [
                    'user_id' => $inquiry['user_id'],
                    'course_id' => $inquiry['course_id'],
                    'message' => $inquiry['message'],
                ],
                [
                    'name' => $inquiry['name'],
                    'email' => $inquiry['email'],
                    'phone' => $inquiry['phone'],
                    'status' => $inquiry['status'],
                    'admin_reply' => $inquiry['admin_reply'],
                    'created_at' => $inquiry['created_at'],
                    'updated_at' => $now,
                ]
            );
        }

        $this->backfillPublishedCoursesForStudentAccounts(
            $userRoleId,
            [
                $courseIds['mastering-typography'],
                $courseIds['editorial-strategy'],
            ],
            $videoIds,
            $now
        );
    }

    private function upsertUser(string $name, string $email, string $password, int $roleId, $now): int
    {
        DB::table('users')->updateOrInsert(
            ['email' => $email],
            [
                'name' => $name,
                'bio' => $roleId !== null && DB::table('roles')->where('id', $roleId)->value('name') === 'instructor'
                    ? 'Instructor focused on practical digital learning systems, course strategy, and student-first teaching.'
                    : null,
                'password' => Hash::make($password),
                'role_id' => $roleId,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
                'remember_token' => null,
            ]
        );

        return (int) DB::table('users')->where('email', $email)->value('id');
    }

    private function backfillPublishedCoursesForStudentAccounts(int $userRoleId, array $courseIds, array $videoIds, $now): void
    {
        $courseIds = array_values(array_filter($courseIds));

        if ($courseIds === []) {
            return;
        }

        $students = DB::table('users')
            ->where('role_id', $userRoleId)
            ->get(['id', 'email']);

        foreach ($students as $student) {
            $existingEnrollmentCount = DB::table('enrollments')
                ->where('user_id', $student->id)
                ->count();

            if ($existingEnrollmentCount > 0) {
                continue;
            }

            foreach ($courseIds as $index => $courseId) {
                $paymentCode = 'auto-pay-'.$student->id.'-'.$courseId;
                $course = DB::table('courses')->where('id', $courseId)->first(['price']);

                DB::table('payments')->updateOrInsert(
                    ['payment_id' => $paymentCode],
                    [
                        'user_id' => $student->id,
                        'course_id' => $courseId,
                        'payment_getway' => 'razorpay',
                        'amount' => (float) ($course->price ?? 0),
                        'status' => 'completed',
                        'created_at' => $now->copy()->subMinutes(30 + ($index * 5)),
                        'updated_at' => $now,
                    ]
                );

                $paymentTableId = DB::table('payments')->where('payment_id', $paymentCode)->value('id');

                DB::table('enrollments')->updateOrInsert(
                    [
                        'user_id' => $student->id,
                        'course_id' => $courseId,
                    ],
                    [
                        'payment_table_id' => $paymentTableId,
                        'amount' => (float) ($course->price ?? 0),
                        'status' => 'completed',
                        'enrolled_at' => $now->copy()->subMinutes(30 + ($index * 5)),
                        'expiry_date' => $now->copy()->addMonths(12),
                        'created_at' => $now->copy()->subMinutes(30 + ($index * 5)),
                        'updated_at' => $now,
                    ]
                );
            }

            $masteringCourseId = $courseIds[0] ?? null;
            if ($masteringCourseId && isset($videoIds['Type Hierarchy Essentials'])) {
                DB::table('course_progress')->updateOrInsert(
                    [
                        'user_id' => $student->id,
                        'course_id' => $masteringCourseId,
                        'video_id' => $videoIds['Type Hierarchy Essentials'],
                    ],
                    [
                        'watched_durations' => 420,
                        'is_completed' => false,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}
