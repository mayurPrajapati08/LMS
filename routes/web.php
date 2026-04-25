<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\InstructorCommunicationController;
use App\Http\Controllers\InstructorCourseController;
use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\InstructorInsightsController;
use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\PublicChatbotController;
use App\Http\Controllers\StudentCartController;
use App\Http\Controllers\StudentCatalogController;
use App\Http\Controllers\StudentCertificatesController;
use App\Http\Controllers\StudentCheckoutController;
use App\Http\Controllers\StudentCoursePlayerController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentLearningController;
use App\Http\Controllers\StudentPaymentsController;
use App\Http\Controllers\StudentSettingsController;
use App\Http\Controllers\StudentSupportController;
use App\Http\Controllers\StudentWishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/
Route::controller(PublicSiteController::class)->group(function () {
    Route::get('/sitemap.xml', 'sitemap')->name('sitemap');
    Route::get('/', 'home')->name('home');
    Route::get('/course', 'courses')->name('home.courses');
    Route::get('/course/offline/{offlineCourse:slug}', 'offlineCourseDetail')->name('offline-course.details');
    Route::get('/career-paths', 'careerPaths')->name('home.career-paths');
    Route::get('/career-paths/{path}', 'careerPathDetail')->name('home.career-paths.show');
    Route::get('/corporate-training', 'corporateTraining')->name('home.corporate-training');
    Route::get('/about', 'about')->name('home.about');
    Route::get('/contact', 'contact')->name('home.contact');
    Route::post('/contact', 'submitContact')->middleware('throttle:public-contact')->name('home.contact.submit');
    Route::post('/content/unlock', 'unlockContent')->middleware('throttle:lead-unlock')->name('content.unlock');
    Route::get('/placement', 'placement')->name('home.placement');
    Route::get('/workshop', 'workshop')->name('home.free_workshop');
    Route::post('/workshop/payment-order', 'createWorkshopPaymentOrder')->middleware('throttle:public-contact')->name('home.workshop.payment-order');
    Route::post('/workshop/verify-payment', 'verifyWorkshopPayment')->middleware('throttle:public-contact')->name('home.workshop.verify-payment');
    Route::post('/workshop/register', 'submitWorkshopRegistration')->middleware('throttle:public-contact')->name('home.workshop.register');
    Route::get('/mentorship', 'mentorship')->name('home.mentorship');
    Route::get('/career-with-us', 'careerWithUs')->name('home.career-with-us');
});

Route::get('/courseDetails', [StudentCatalogController::class, 'courseDetails'])
    ->middleware('feature:catalog_online_enabled')
    ->name('course.details');

Route::redirect('/carrer', '/career-with-us', 301);
Route::controller(PublicChatbotController::class)->prefix('api/chatbot')->group(function () {
    Route::get('/health', 'health')->name('chatbot.health');
    Route::get('/context', 'context')->name('chatbot.context');
    Route::post('/inquiries', 'storeInquiry')->name('chatbot.inquiries');
});

/*
|--------------------------------------------------------------------------
| Guest authentication
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login')->middleware('throttle:auth-attempts')->name('login.attempt');
        Route::get('/auth/google/redirect', 'redirectToGoogle')->name('login.google.redirect');
        Route::get('/auth/google/callback', 'handleGoogleCallback')->name('login.google.callback');

        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register')->middleware('throttle:auth-attempts')->name('register.store');

        Route::get('/forgot-password', 'showForgotPasswordRequest')->name('password.request');
        Route::post('/forgot-password', 'sendPasswordResetOtp')->middleware('throttle:auth-attempts')->name('password.email');
        Route::get('/forgot-password/verify', 'showForgotPasswordOtp')->name('password.otp.notice');
        Route::post('/forgot-password/verify', 'verifyPasswordResetOtp')->middleware('throttle:auth-attempts')->name('password.otp.verify');
        Route::post('/forgot-password/verify/resend', 'resendPasswordResetOtp')->middleware('throttle:auth-attempts')->name('password.otp.resend');
        Route::get('/forgot-password/reset', 'showResetPasswordForm')->name('password.reset.form');
        Route::post('/forgot-password/reset', 'resetPassword')->middleware('throttle:auth-attempts')->name('password.update');

        Route::get('/two-factor-challenge', 'showTwoFactorChallenge')->name('two-factor.challenge');
        Route::post('/two-factor-challenge', 'verifyTwoFactorOtp')->middleware('throttle:auth-attempts')->name('two-factor.verify');
        Route::post('/two-factor-challenge/resend', 'resendTwoFactorOtp')->middleware('throttle:auth-attempts')->name('two-factor.resend');
    });
});

Route::middleware('auth')->controller(AuthController::class)->group(function () {
    Route::get('/email/verify', 'showVerificationNotice')->name('verification.notice');
    Route::post('/email/verify', 'verifyOtp')->name('verification.verify');
    Route::post('/email/verify/resend', 'resendOtp')->name('verification.resend');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Instructor
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:instructor'])
    ->prefix('instructor')
    ->name('instructor.')
    ->group(function () {
        Route::get('/dashboard', InstructorDashboardController::class)->name('dashboard');

        Route::controller(InstructorCourseController::class)->group(function () {
            Route::get('/mycourse', 'showMyCourses')->name('mycourse');

            Route::prefix('create-course')->group(function () {
                Route::get('/', 'showStep1')->name('create-course');
                Route::post('/', 'storeStep1')->name('create-course.store');
                Route::get('/curriculum', 'showCurriculum')->name('create-course.curriculum');
                Route::post('/curriculum/video-signature', 'signVideoUpload')->name('create-course.curriculum.video-signature');
                Route::post('/curriculum/material-signature', 'signMaterialUpload')->name('create-course.curriculum.material-signature');
                Route::post('/curriculum', 'storeCurriculum')->name('create-course.curriculum.store');
                Route::get('/pricing', 'showPricing')->name('create-course.pricing');
                Route::post('/pricing', 'storePricing')->name('create-course.pricing.store');
                Route::get('/review', 'showReview')->name('create-course.review');
                Route::post('/review/publish', 'publish')->name('create-course.publish');
            });
        });

        Route::controller(InstructorInsightsController::class)->group(function () {
            Route::get('/students', 'students')->name('students');
            Route::get('/earnings', 'earnings')->name('earnings');
            Route::get('/reviews', 'reviews')->name('reviews');
        });

        Route::controller(InstructorCommunicationController::class)->group(function () {
            Route::get('/messages', 'messages')->name('messages');
            Route::post('/messages/{inquiry}/reply', 'reply')->name('messages.reply');
            Route::get('/settings', 'settings')->name('settings');
            Route::post('/settings/profile', 'updateProfile')->name('settings.profile');
            Route::post('/settings/password', 'updatePassword')->name('settings.password');
        });
    });

/*
|--------------------------------------------------------------------------
| Student
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:user'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', StudentDashboardController::class)->name('dashboard');
        Route::get('/my-learning', StudentLearningController::class)->name('my-learning');

        Route::controller(StudentCoursePlayerController::class)->prefix('course-player')->group(function () {
            Route::get('/', 'show')->name('course-player');
            Route::post('/progress', 'saveProgress')->middleware('throttle:60,1')->name('course-player.progress');
            Route::post('/complete', 'complete')->middleware('throttle:60,1')->name('course-player.complete');
            Route::post('/question', 'storeQuestion')->middleware('throttle:30,1')->name('course-player.question');
            Route::post('/note', 'storeNote')->middleware('throttle:30,1')->name('course-player.note');
            Route::get('/resource/{material}/view', 'viewResource')->name('course-player.resource.view');
            Route::get('/resource/{material}/download', 'downloadResource')->name('course-player.resource.download');
        });

        Route::get('/wishlist', StudentWishlistController::class)
            ->middleware('feature:student_wishlist_enabled')
            ->name('wishlist');
        Route::post('/wishlist/toggle/{course}', [StudentWishlistController::class, 'toggle'])
            ->middleware('feature:student_wishlist_enabled')
            ->name('wishlist.toggle');
        Route::post('/wishlist/{wishlist}/remove', [StudentWishlistController::class, 'destroy'])
            ->middleware('feature:student_wishlist_enabled')
            ->name('wishlist.remove');

        Route::get('/messages-support', StudentSupportController::class)->name('support');
        Route::post('/messages-support', [StudentSupportController::class, 'store'])->name('support.store');

        Route::controller(StudentCatalogController::class)->group(function () {
            Route::get('/browse-courses', 'browse')->name('browse-courses');
            Route::get('/course-details', 'studentCourseDetails')->middleware('feature:student_catalog_enabled')->name('course-details');
        });

        Route::get('/cart', StudentCartController::class)->middleware('feature:student_cart_enabled')->name('cart');
        Route::post('/cart/add/{course}', [StudentCartController::class, 'store'])
            ->middleware('feature:student_cart_enabled')
            ->name('cart.add');
        Route::post('/cart/{cartItem}/remove', [StudentCartController::class, 'destroy'])
            ->middleware('feature:student_cart_enabled')
            ->name('cart.remove');

        Route::controller(StudentCheckoutController::class)->prefix('checkout')->middleware('feature:student_checkout_enabled')->group(function () {
            Route::get('/', 'show')->name('checkout');
            Route::post('/verify', 'verify')->middleware('throttle:checkout-actions')->name('checkout.verify');
            Route::post('/free', 'freeEnroll')->middleware('throttle:checkout-actions')->name('checkout.free');
        });

        Route::get('/certificate', StudentCertificatesController::class)->name('certificates');
        Route::get('/payment', StudentPaymentsController::class)->middleware('feature:student_payments_enabled')->name('payments');

        Route::prefix('seeting')->controller(StudentSettingsController::class)->group(function () {
            Route::get('/', 'settings')->name('settings');
            Route::post('/profile', 'updateProfile')->name('settings.profile');
            Route::post('/password', 'updatePassword')->name('settings.password');
        });
    });

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin,super admin'])
    ->prefix('admin')
    ->name('admin.')
    ->controller(AdminController::class)
    ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/courses', 'courses')->name('courses');
        Route::get('/instructors', 'instructors')->name('instructors');
        Route::post('/instructors/invite', 'storeInstructor')->name('instructors.store');
        Route::get('/users', 'users')->name('users');
        Route::get('/analytics', 'analytics')->name('analytics');

        Route::prefix('settings')->group(function () {
            Route::get('/', 'settings')->name('settings');
            Route::post('/profile', 'updateSettings')->name('settings.profile');
            Route::post('/password', 'updatePassword')->name('settings.password');
            Route::post('/platform', 'updatePlatformSettings')->name('settings.platform');
        });

        Route::prefix('categories')->name('categories')->group(function () {
            Route::get('/', 'categories')->name('');
            Route::post('/', 'storeCategory')->name('.store');
            Route::put('/{category}', 'updateCategory')->name('.update');
            Route::delete('/{category}', 'destroyCategory')->name('.destroy');
        });

        Route::get('/payments', 'payments')->name('payments');
        Route::get('/reviews', 'reviews')->name('reviews');
        Route::get('/support', 'support')->name('support');
        Route::post('/support/{inquiry}/reply', 'replySupport')->name('support.reply');
    });

Route::middleware(['auth', 'verified', 'role:super admin'])
    ->prefix('admin')
    ->name('admin.')
    ->controller(AdminController::class)
    ->group(function () {
        Route::prefix('admins')->name('admins')->group(function () {
            Route::get('/', 'admins')->name('');
            Route::post('/', 'storeAdmin')->name('.store');
            Route::put('/{managedAdmin}', 'updateAdmin')->name('.update');
            Route::delete('/{managedAdmin}', 'destroyAdmin')->name('.destroy');
        });
    });

/*
|--------------------------------------------------------------------------
| HR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:hr team,admin,super admin'])
    ->prefix('hr')
    ->name('hr.')
    ->controller(HrController::class)
    ->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');

        Route::prefix('slides')->name('slides')->group(function () {
            Route::get('/', 'slides')->name('');
            Route::post('/', 'storeSlide')->name('.store');
            Route::put('/{slide}', 'updateSlide')->name('.update');
            Route::delete('/{slide}', 'destroySlide')->name('.destroy');
        });

        Route::prefix('founder-media')->name('founder-media')->group(function () {
            Route::get('/', 'founderMedia')->name('');
            Route::post('/', 'updateFounderMedia')->name('.update');
        });

        Route::prefix('stories')->name('stories')->group(function () {
            Route::get('/', 'stories')->name('');
            Route::post('/', 'storeStory')->name('.store');
            Route::put('/{story}', 'updateStory')->name('.update');
            Route::delete('/{story}', 'destroyStory')->name('.destroy');
        });

        Route::prefix('achievements')->name('achievements')->group(function () {
            Route::get('/', 'achievements')->name('');
            Route::post('/', 'storeAchievement')->name('.store');
            Route::put('/{achievement}', 'updateAchievement')->name('.update');
            Route::delete('/{achievement}', 'destroyAchievement')->name('.destroy');
        });

        Route::prefix('jobs')->name('jobs')->group(function () {
            Route::get('/', 'jobs')->name('');
            Route::post('/', 'storeJob')->name('.store');
            Route::put('/{job}', 'updateJob')->name('.update');
            Route::delete('/{job}', 'destroyJob')->name('.destroy');
        });

        Route::prefix('faculty')->name('faculty')->group(function () {
            Route::get('/', 'faculty')->name('');
            Route::put('/{user}', 'updateFaculty')->name('.update');
        });

        Route::prefix('workshops')->name('workshops')->group(function () {
            Route::get('/', 'workshops')->name('');
            Route::post('/', 'storeWorkshop')->name('.store');
            Route::put('/{workshop}', 'updateWorkshop')->name('.update');
            Route::delete('/{workshop}', 'destroyWorkshop')->name('.destroy');
        });

        Route::prefix('workshop-registrations')->name('workshop-registrations')->group(function () {
            Route::get('/', 'workshopRegistrations')->name('');
            Route::put('/{registration}', 'updateWorkshopRegistration')->name('.update');
        });

        Route::prefix('offline-courses')->name('offline-courses')->group(function () {
            Route::get('/', 'offlineCourses')->name('');
            Route::post('/', 'storeOfflineCourse')->name('.store');
            Route::put('/{offlineCourse}', 'updateOfflineCourse')->name('.update');
            Route::delete('/{offlineCourse}', 'destroyOfflineCourse')->name('.destroy');
            Route::post('/platform', 'updateCoursePlatformSettings')->name('.platform');
        });

        Route::prefix('inquiries')->group(function () {
            Route::get('/', 'inquiries')->name('inquiries');
            Route::get('/workshops', 'workshopLeads')->name('inquiries.workshops');
            Route::get('/careers', 'careerLeads')->name('inquiries.careers');
            Route::put('/{contact}', 'updateInquiry')->name('inquiries.update');
        });

        Route::get('/mentorship', 'mentorship')->name('mentorship');
    });
