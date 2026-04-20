<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorCourseController;
use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\InstructorInsightsController;
use App\Http\Controllers\InstructorCommunicationController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\StudentCoursePlayerController;
use App\Http\Controllers\StudentCertificatesController;
use App\Http\Controllers\StudentCatalogController;
use App\Http\Controllers\StudentCartController;
use App\Http\Controllers\StudentCheckoutController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentLearningController;
use App\Http\Controllers\StudentPaymentsController;
use App\Http\Controllers\StudentSettingsController;
use App\Http\Controllers\StudentSupportController;
use App\Http\Controllers\StudentWishlistController;
use Illuminate\Support\Facades\Route;

//Home Pages Routes
Route::get('/', [PublicSiteController::class, 'home'])->name('home');
Route::get('/course', [PublicSiteController::class, 'courses'])->name('home.courses');
Route::get('/career-paths', [PublicSiteController::class, 'careerPaths'])->name('home.career-paths');
Route::get('/career-paths/{path}', [PublicSiteController::class, 'careerPathDetail'])->name('home.career-paths.show');
Route::get('/corporate-training', [PublicSiteController::class, 'corporateTraining'])->name('home.corporate-training');
Route::get('/about', [PublicSiteController::class, 'about'])->name('home.about');
Route::get('/contact', [PublicSiteController::class, 'contact'])->name('home.contact');
Route::post('/contact', [PublicSiteController::class, 'submitContact'])->middleware('throttle:public-contact')->name('home.contact.submit');
Route::post('/content/unlock', [PublicSiteController::class, 'unlockContent'])->middleware('throttle:lead-unlock')->name('content.unlock');
Route::get('/courseDetails', [StudentCatalogController::class, 'courseDetails'])
    ->middleware('feature:catalog_online_enabled')
    ->name('course.details');
Route::get('/placement', [PublicSiteController::class, 'placement'])->name('home.placement');
Route::get('/workshop', [PublicSiteController::class, 'workshop'])->name('home.free_workshop');
Route::get('/mentorship', [PublicSiteController::class, 'mentorship'])->name('home.mentorship');
Route::redirect('/carrer', '/career-with-us', 301);
Route::get('/career-with-us', [PublicSiteController::class, 'careerWithUs'])->name('home.career-with-us');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:auth-attempts')->name('login.attempt');
    Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('login.google.redirect');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('login.google.callback');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:auth-attempts')->name('register.store');
    Route::get('/two-factor-challenge', [AuthController::class, 'showTwoFactorChallenge'])->name('two-factor.challenge');
    Route::post('/two-factor-challenge', [AuthController::class, 'verifyTwoFactorOtp'])->middleware('throttle:auth-attempts')->name('two-factor.verify');
    Route::post('/two-factor-challenge/resend', [AuthController::class, 'resendTwoFactorOtp'])->middleware('throttle:auth-attempts')->name('two-factor.resend');
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
    Route::post('/email/verify', [AuthController::class, 'verifyOtp'])->name('verification.verify');
    Route::post('/email/verify/resend', [AuthController::class, 'resendOtp'])->name('verification.resend');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

//Instructor Routes
Route::middleware(['auth', 'verified', 'role:instructor'])->group(function () {
    Route::get('instructor/dashboard', InstructorDashboardController::class);
    Route::get('instructor/mycourse', [InstructorCourseController::class, 'showMyCourses'])->name('instructor.mycourse');
    Route::get('instructor/students', [InstructorInsightsController::class, 'students'])->name('instructor.students');
    Route::get('instructor/create-course', [InstructorCourseController::class, 'showStep1'])->name('instructor.create-course');
    Route::post('instructor/create-course', [InstructorCourseController::class, 'storeStep1'])->name('instructor.create-course.store');
    Route::get('instructor/create-course/curriculum', [InstructorCourseController::class, 'showCurriculum'])->name('instructor.create-course.curriculum');
    Route::post('instructor/create-course/curriculum/video-signature', [InstructorCourseController::class, 'signVideoUpload'])->name('instructor.create-course.curriculum.video-signature');
    Route::post('instructor/create-course/curriculum/material-signature', [InstructorCourseController::class, 'signMaterialUpload'])->name('instructor.create-course.curriculum.material-signature');
    Route::post('instructor/create-course/curriculum', [InstructorCourseController::class, 'storeCurriculum'])->name('instructor.create-course.curriculum.store');
    Route::get('instructor/create-course/pricing', [InstructorCourseController::class, 'showPricing'])->name('instructor.create-course.pricing');
    Route::post('instructor/create-course/pricing', [InstructorCourseController::class, 'storePricing'])->name('instructor.create-course.pricing.store');
    Route::get('instructor/create-course/review', [InstructorCourseController::class, 'showReview'])->name('instructor.create-course.review');
    Route::post('instructor/create-course/review/publish', [InstructorCourseController::class, 'publish'])->name('instructor.create-course.publish');
    Route::get('instructor/earnings', [InstructorInsightsController::class, 'earnings'])->name('instructor.earnings');
    Route::get('instructor/messages', [InstructorCommunicationController::class, 'messages'])->name('instructor.messages');
    Route::post('instructor/messages/{inquiry}/reply', [InstructorCommunicationController::class, 'reply'])->name('instructor.messages.reply');
    Route::get('instructor/reviews', [InstructorInsightsController::class, 'reviews'])->name('instructor.reviews');
    Route::get('instructor/settings', [InstructorCommunicationController::class, 'settings'])->name('instructor.settings');
    Route::post('instructor/settings/profile', [InstructorCommunicationController::class, 'updateProfile'])->name('instructor.settings.profile');
    Route::post('instructor/settings/password', [InstructorCommunicationController::class, 'updatePassword'])->name('instructor.settings.password');
});

//Students Routes
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('student/dashboard', StudentDashboardController::class)->name('student.dashboard');
    Route::get('student/my-learning', StudentLearningController::class)->name('student.my-learning');
    Route::get('student/course-player', [StudentCoursePlayerController::class, 'show'])->name('student.course-player');
    Route::post('student/course-player/progress', [StudentCoursePlayerController::class, 'saveProgress'])->middleware('throttle:60,1')->name('student.course-player.progress');
    Route::post('student/course-player/complete', [StudentCoursePlayerController::class, 'complete'])->middleware('throttle:60,1')->name('student.course-player.complete');
    Route::post('student/course-player/question', [StudentCoursePlayerController::class, 'storeQuestion'])->middleware('throttle:30,1')->name('student.course-player.question');
    Route::post('student/course-player/note', [StudentCoursePlayerController::class, 'storeNote'])->middleware('throttle:30,1')->name('student.course-player.note');
    Route::get('student/course-player/resource/{material}/view', [StudentCoursePlayerController::class, 'viewResource'])->name('student.course-player.resource.view');
    Route::get('student/course-player/resource/{material}/download', [StudentCoursePlayerController::class, 'downloadResource'])->name('student.course-player.resource.download');
    Route::get('student/wishlist', StudentWishlistController::class)->middleware('feature:student_wishlist_enabled')->name('student.wishlist');
    Route::post('student/wishlist/toggle/{course}', [StudentWishlistController::class, 'toggle'])->middleware('feature:student_wishlist_enabled')->name('student.wishlist.toggle');
    Route::post('student/wishlist/{wishlist}/remove', [StudentWishlistController::class, 'destroy'])->middleware('feature:student_wishlist_enabled')->name('student.wishlist.remove');
    Route::get('student/messages-support', StudentSupportController::class)->name('student.support');
    Route::post('student/messages-support', [StudentSupportController::class, 'store'])->name('student.support.store');
    Route::get('student/browse-courses', [StudentCatalogController::class, 'browse'])->name('student.browse-courses');
    Route::get('student/course-details', [StudentCatalogController::class, 'studentCourseDetails'])->middleware('feature:student_catalog_enabled')->name('student.course-details');
    Route::get('student/cart', StudentCartController::class)->middleware('feature:student_cart_enabled')->name('student.cart');
    Route::post('student/cart/add/{course}', [StudentCartController::class, 'store'])->middleware('feature:student_cart_enabled')->name('student.cart.add');
    Route::post('student/cart/{cartItem}/remove', [StudentCartController::class, 'destroy'])->middleware('feature:student_cart_enabled')->name('student.cart.remove');
    Route::get('student/checkout', [StudentCheckoutController::class, 'show'])->middleware('feature:student_checkout_enabled')->name('student.checkout');
    Route::post('student/checkout/verify', [StudentCheckoutController::class, 'verify'])->middleware(['feature:student_checkout_enabled', 'throttle:checkout-actions'])->name('student.checkout.verify');
    Route::post('student/checkout/free', [StudentCheckoutController::class, 'freeEnroll'])->middleware(['feature:student_checkout_enabled', 'throttle:checkout-actions'])->name('student.checkout.free');
    Route::get('student/certificate', StudentCertificatesController::class)->name('student.certificates');
    Route::get('student/payment', StudentPaymentsController::class)->middleware('feature:student_payments_enabled')->name('student.payments');
    Route::get('student/seeting', [StudentSettingsController::class, 'settings'])->name('student.settings');
    Route::post('student/seeting/profile', [StudentSettingsController::class, 'updateProfile'])->name('student.settings.profile');
    Route::post('student/seeting/password', [StudentSettingsController::class, 'updatePassword'])->name('student.settings.password');
});

//Admin Routes
Route::middleware(['auth', 'verified', 'role:admin,super admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/courses', [AdminController::class, 'courses'])->name('admin.courses');
    Route::get('admin/instructors', [AdminController::class, 'instructors'])->name('admin.instructors');
    Route::post('admin/instructors/invite', [AdminController::class, 'storeInstructor'])->name('admin.instructors.store');
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('admin/settings/profile', [AdminController::class, 'updateSettings'])->name('admin.settings.profile');
    Route::post('admin/settings/password', [AdminController::class, 'updatePassword'])->name('admin.settings.password');
    Route::post('admin/settings/platform', [AdminController::class, 'updatePlatformSettings'])->name('admin.settings.platform');
    Route::get('admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('admin/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('admin/categories/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
    Route::get('admin/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::get('admin/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::get('admin/support', [AdminController::class, 'support'])->name('admin.support');
    Route::post('admin/support/{inquiry}/reply', [AdminController::class, 'replySupport'])->name('admin.support.reply');
});

Route::middleware(['auth', 'verified', 'role:hr team,admin,super admin'])->group(function () {
    Route::get('hr/dashboard', [HrController::class, 'dashboard'])->name('hr.dashboard');
    Route::get('hr/slides', [HrController::class, 'slides'])->name('hr.slides');
    Route::post('hr/slides', [HrController::class, 'storeSlide'])->name('hr.slides.store');
    Route::put('hr/slides/{slide}', [HrController::class, 'updateSlide'])->name('hr.slides.update');
    Route::delete('hr/slides/{slide}', [HrController::class, 'destroySlide'])->name('hr.slides.destroy');
    Route::get('hr/founder-media', [HrController::class, 'founderMedia'])->name('hr.founder-media');
    Route::post('hr/founder-media', [HrController::class, 'updateFounderMedia'])->name('hr.founder-media.update');

    Route::get('hr/stories', [HrController::class, 'stories'])->name('hr.stories');
    Route::post('hr/stories', [HrController::class, 'storeStory'])->name('hr.stories.store');
    Route::put('hr/stories/{story}', [HrController::class, 'updateStory'])->name('hr.stories.update');
    Route::delete('hr/stories/{story}', [HrController::class, 'destroyStory'])->name('hr.stories.destroy');

    Route::get('hr/achievements', [HrController::class, 'achievements'])->name('hr.achievements');
    Route::post('hr/achievements', [HrController::class, 'storeAchievement'])->name('hr.achievements.store');
    Route::put('hr/achievements/{achievement}', [HrController::class, 'updateAchievement'])->name('hr.achievements.update');
    Route::delete('hr/achievements/{achievement}', [HrController::class, 'destroyAchievement'])->name('hr.achievements.destroy');

    Route::get('hr/jobs', [HrController::class, 'jobs'])->name('hr.jobs');
    Route::post('hr/jobs', [HrController::class, 'storeJob'])->name('hr.jobs.store');
    Route::put('hr/jobs/{job}', [HrController::class, 'updateJob'])->name('hr.jobs.update');
    Route::delete('hr/jobs/{job}', [HrController::class, 'destroyJob'])->name('hr.jobs.destroy');

    Route::get('hr/faculty', [HrController::class, 'faculty'])->name('hr.faculty');
    Route::put('hr/faculty/{user}', [HrController::class, 'updateFaculty'])->name('hr.faculty.update');

    Route::get('hr/workshops', [HrController::class, 'workshops'])->name('hr.workshops');
    Route::post('hr/workshops', [HrController::class, 'storeWorkshop'])->name('hr.workshops.store');
    Route::put('hr/workshops/{workshop}', [HrController::class, 'updateWorkshop'])->name('hr.workshops.update');
    Route::delete('hr/workshops/{workshop}', [HrController::class, 'destroyWorkshop'])->name('hr.workshops.destroy');
    Route::get('hr/offline-courses', [HrController::class, 'offlineCourses'])->name('hr.offline-courses');
    Route::post('hr/offline-courses', [HrController::class, 'storeOfflineCourse'])->name('hr.offline-courses.store');
    Route::put('hr/offline-courses/{offlineCourse}', [HrController::class, 'updateOfflineCourse'])->name('hr.offline-courses.update');
    Route::delete('hr/offline-courses/{offlineCourse}', [HrController::class, 'destroyOfflineCourse'])->name('hr.offline-courses.destroy');
    Route::post('hr/offline-courses/platform', [HrController::class, 'updateCoursePlatformSettings'])->name('hr.offline-courses.platform');

    Route::get('hr/inquiries', [HrController::class, 'inquiries'])->name('hr.inquiries');
    Route::get('hr/inquiries/workshops', [HrController::class, 'workshopLeads'])->name('hr.inquiries.workshops');
    Route::get('hr/inquiries/careers', [HrController::class, 'careerLeads'])->name('hr.inquiries.careers');
    Route::put('hr/inquiries/{contact}', [HrController::class, 'updateInquiry'])->name('hr.inquiries.update');

    Route::get('hr/mentorship', [HrController::class, 'mentorship'])->name('hr.mentorship');
});

Route::middleware(['auth', 'verified', 'role:super admin'])->group(function () {
    Route::get('admin/admins', [AdminController::class, 'admins'])->name('admin.admins');
    Route::post('admin/admins', [AdminController::class, 'storeAdmin'])->name('admin.admins.store');
    Route::put('admin/admins/{managedAdmin}', [AdminController::class, 'updateAdmin'])->name('admin.admins.update');
    Route::delete('admin/admins/{managedAdmin}', [AdminController::class, 'destroyAdmin'])->name('admin.admins.destroy');
});