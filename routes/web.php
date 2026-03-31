<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorCourseController;
use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\InstructorInsightsController;
use App\Http\Controllers\InstructorCommunicationController;
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
Route::get('/about', [PublicSiteController::class, 'about'])->name('home.about');
Route::get('/contact', [PublicSiteController::class, 'contact'])->name('home.contact');
Route::post('/contact', [PublicSiteController::class, 'submitContact'])->name('home.contact.submit');
Route::get('/courseDetails', [StudentCatalogController::class, 'courseDetails'])->name('course.details');
Route::get('/placement', [PublicSiteController::class, 'placement'])->name('home.placement');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/two-factor-challenge', [AuthController::class, 'showTwoFactorChallenge'])->name('two-factor.challenge');
    Route::post('/two-factor-challenge', [AuthController::class, 'verifyTwoFactorOtp'])->name('two-factor.verify');
    Route::post('/two-factor-challenge/resend', [AuthController::class, 'resendTwoFactorOtp'])->name('two-factor.resend');
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
    Route::post('student/course-player/progress', [StudentCoursePlayerController::class, 'saveProgress'])->name('student.course-player.progress');
    Route::post('student/course-player/complete', [StudentCoursePlayerController::class, 'complete'])->name('student.course-player.complete');
    Route::post('student/course-player/question', [StudentCoursePlayerController::class, 'storeQuestion'])->name('student.course-player.question');
    Route::post('student/course-player/note', [StudentCoursePlayerController::class, 'storeNote'])->name('student.course-player.note');
    Route::get('student/course-player/resource/{material}/view', [StudentCoursePlayerController::class, 'viewResource'])->name('student.course-player.resource.view');
    Route::get('student/course-player/resource/{material}/download', [StudentCoursePlayerController::class, 'downloadResource'])->name('student.course-player.resource.download');
    Route::get('student/wishlist', StudentWishlistController::class)->name('student.wishlist');
    Route::post('student/wishlist/toggle/{course}', [StudentWishlistController::class, 'toggle'])->name('student.wishlist.toggle');
    Route::post('student/wishlist/{wishlist}/remove', [StudentWishlistController::class, 'destroy'])->name('student.wishlist.remove');
    Route::get('student/messages-support', StudentSupportController::class)->name('student.support');
    Route::post('student/messages-support', [StudentSupportController::class, 'store'])->name('student.support.store');
    Route::get('student/browse-courses', [StudentCatalogController::class, 'browse'])->name('student.browse-courses');
    Route::get('student/course-details', [StudentCatalogController::class, 'studentCourseDetails'])->name('student.course-details');
    Route::get('student/cart', StudentCartController::class)->name('student.cart');
    Route::post('student/cart/add/{course}', [StudentCartController::class, 'store'])->name('student.cart.add');
    Route::post('student/cart/{cartItem}/remove', [StudentCartController::class, 'destroy'])->name('student.cart.remove');
    Route::get('student/checkout', [StudentCheckoutController::class, 'show'])->name('student.checkout');
    Route::post('student/checkout/verify', [StudentCheckoutController::class, 'verify'])->name('student.checkout.verify');
    Route::post('student/checkout/free', [StudentCheckoutController::class, 'freeEnroll'])->name('student.checkout.free');
    Route::get('student/certificate', StudentCertificatesController::class)->name('student.certificates');
    Route::get('student/payment', StudentPaymentsController::class)->name('student.payments');
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

Route::middleware(['auth', 'verified', 'role:super admin'])->group(function () {
    Route::get('admin/admins', [AdminController::class, 'admins'])->name('admin.admins');
    Route::post('admin/admins', [AdminController::class, 'storeAdmin'])->name('admin.admins.store');
    Route::put('admin/admins/{managedAdmin}', [AdminController::class, 'updateAdmin'])->name('admin.admins.update');
    Route::delete('admin/admins/{managedAdmin}', [AdminController::class, 'destroyAdmin'])->name('admin.admins.destroy');
});
