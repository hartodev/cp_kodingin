<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;


// ============================================================
// FRONTEND — PUBLIC (tidak perlu login)
// ============================================================

// Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');

// // Kursus
// Route::get('/courses', [\App\Http\Controllers\Frontend\CourseController::class, 'index'])->name('courses.index');
// Route::get('/courses/{slug}', [\App\Http\Controllers\Frontend\CourseController::class, 'show'])->name('courses.show');

// // Blog / Panduan
// Route::get('/blog', [\App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('blog.index');
// Route::get('/blog/{slug}', [\App\Http\Controllers\Frontend\BlogController::class, 'show'])->name('blog.show');

// // Portfolio
// Route::get('/portfolio', [\App\Http\Controllers\Frontend\PortfolioController::class, 'index'])->name('portfolio.index');

// // Contact
// Route::get('/contact', [\App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact.index');
// Route::post('/contact', [\App\Http\Controllers\Frontend\ContactController::class, 'store'])->name('contact.store');

// // Newsletter
// Route::post('/newsletter/subscribe', [\App\Http\Controllers\Frontend\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// ============================================================
// FRONTEND AUTH — USER (guest only)
// ============================================================

Route::middleware('guest')->prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');

    Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'index'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'store'])->name('password.update');
});

// ============================================================
// FRONTEND — USER DASHBOARD (harus login, role: user)
// ============================================================

// Route::middleware(['auth', 'role:user'])
//     ->prefix('dashboard')
//     ->name('user.')
//     ->group(function () {

//         Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'destroy'])->name('logout');

//         // Dashboard utama
//         Route::get('/', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

//         // Profile
//         Route::get('/profile', [\App\Http\Controllers\User\ProfileController::class, 'index'])->name('profile');
//         Route::put('/profile', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
//         Route::put('/profile/password', [\App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('profile.password');

//         // My Courses
//         Route::get('/my-courses', [\App\Http\Controllers\User\EnrollmentController::class, 'index'])->name('my-courses');

//         // Wishlist
//         Route::get('/wishlist', [\App\Http\Controllers\User\WishlistController::class, 'index'])->name('wishlist');
//         Route::post('/wishlist/toggle/{course}', [\App\Http\Controllers\User\WishlistController::class, 'toggle'])->name('wishlist.toggle');

//         // Cart
//         Route::get('/cart', [\App\Http\Controllers\User\CartController::class, 'index'])->name('cart');
//         Route::post('/cart/add/{course}', [\App\Http\Controllers\User\CartController::class, 'store'])->name('cart.store');
//         Route::delete('/cart/{cart}', [\App\Http\Controllers\User\CartController::class, 'destroy'])->name('cart.destroy');

//         // Checkout
//         Route::post('/checkout', [\App\Http\Controllers\User\CheckoutController::class, 'store'])->name('checkout.store');
//         Route::get('/checkout/{order}', [\App\Http\Controllers\User\CheckoutController::class, 'show'])->name('checkout.show');

//         // Verifikasi YouTube
//         Route::post('/verification/{order}/submit', [\App\Http\Controllers\User\YoutubeVerificationController::class, 'submit'])->name('verification.submit');
//         Route::get('/verification/{order}/status', [\App\Http\Controllers\User\YoutubeVerificationController::class, 'status'])->name('verification.status');

//         // Notifikasi
//         Route::get('/notifications', [\App\Http\Controllers\User\NotificationController::class, 'index'])->name('notifications');
//         Route::post('/notifications/{notification}/read', [\App\Http\Controllers\User\NotificationController::class, 'markRead'])->name('notifications.read');
//         Route::post('/notifications/read-all', [\App\Http\Controllers\User\NotificationController::class, 'readAll'])->name('notifications.readAll');

//         // Sertifikat
//         Route::get('/certificates', [\App\Http\Controllers\User\CertificateController::class, 'index'])->name('certificates');

//         // Halaman Belajar (harus enroll)
//         Route::middleware('enrolled')->group(function () {
//             Route::get('/learn/{course}', [\App\Http\Controllers\User\LearnController::class, 'index'])->name('learn');
//             Route::get('/learn/{course}/{lesson}', [\App\Http\Controllers\User\LearnController::class, 'show'])->name('learn.show');
//             Route::post('/learn/{course}/{lesson}/progress', [\App\Http\Controllers\User\LearnController::class, 'updateProgress'])->name('learn.progress');
//             Route::get('/learn/{course}/certificate', [\App\Http\Controllers\User\CertificateController::class, 'show'])->name('learn.certificate');
//             Route::get('/learn/{course}/certificate/download', [\App\Http\Controllers\User\CertificateController::class, 'download'])->name('learn.certificate.download');
//         });

//         // Review kursus
//         Route::post('/courses/{course}/review', [\App\Http\Controllers\User\ReviewController::class, 'store'])->name('reviews.store');
//         Route::put('/courses/{course}/review', [\App\Http\Controllers\User\ReviewController::class, 'update'])->name('reviews.update');
//         Route::delete('/courses/{course}/review', [\App\Http\Controllers\User\ReviewController::class, 'destroy'])->name('reviews.destroy');

//         // Diskusi kursus
//         Route::post('/courses/{course}/discussions', [\App\Http\Controllers\User\DiscussionController::class, 'store'])->name('discussions.store');
//         Route::delete('/discussions/{thread}', [\App\Http\Controllers\User\DiscussionController::class, 'destroy'])->name('discussions.destroy');
//         Route::post('/discussions/{thread}/replies', [\App\Http\Controllers\User\DiscussionReplyController::class, 'store'])->name('discussions.replies.store');
//         Route::post('/discussions/replies/{reply}/answer', [\App\Http\Controllers\User\DiscussionReplyController::class, 'markAnswer'])->name('discussions.replies.answer');
//         Route::delete('/discussions/replies/{reply}', [\App\Http\Controllers\User\DiscussionReplyController::class, 'destroy'])->name('discussions.replies.destroy');

//         // Komentar blog
//         Route::post('/blog/{blog}/comments', [\App\Http\Controllers\User\BlogCommentController::class, 'store'])->name('blog.comments.store');
//         Route::delete('/blog/comments/{comment}', [\App\Http\Controllers\User\BlogCommentController::class, 'destroy'])->name('blog.comments.destroy');
//     });

// ============================================================
// BACKEND ADMIN — prefix /admin (terpisah dari frontend)
// ============================================================

Route::prefix('admin')->name('admin.')->group(function () {

    // ── Admin Auth (guest admin) ───────────────────────────────────
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'index'])->name('login');
        Route::post('/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'store'])->name('login.store');

        Route::get('/forgot-password', [\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'index'])->name('password.request');
        Route::post('/forgot-password', [\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'store'])->name('password.email');

        Route::get('/reset-password/{token}', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'index'])->name('password.reset');
        Route::post('/reset-password', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'store'])->name('password.update');
    });

    // ── Admin Panel (sudah login, role: admin) ─────────────────────
    Route::middleware(['auth', 'role:admin'])->group(function () {

        Route::post('/logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'destroy'])->name('logout');

        // // Dashboard
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // // ── Manajemen Kursus ───────────────────────────────────────
        Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
        Route::resource('courses.chapters', \App\Http\Controllers\Admin\CourseChapterController::class);
        Route::resource('courses.chapters.lessons', \App\Http\Controllers\Admin\CourseLessonController::class);
        Route::post('courses/{course}/chapters/reorder', [\App\Http\Controllers\Admin\CourseChapterController::class, 'reorder'])->name('courses.chapters.reorder');
        Route::post('courses/{course}/chapters/{chapter}/lessons/reorder', [\App\Http\Controllers\Admin\CourseLessonController::class, 'reorder'])->name('courses.chapters.lessons.reorder');

        // // Kategori, Level, Tag
        Route::resource('categories', \App\Http\Controllers\Admin\CourseCategoryController::class);
        Route::resource('levels', \App\Http\Controllers\Admin\CourseLevelController::class);
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);

        // // ── Manajemen User & Enrollment ────────────────────────────
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('enrollments', \App\Http\Controllers\Admin\EnrollmentController::class)->only(['index', 'show', 'destroy']);
        Route::patch('enrollments/{enrollment}/toggle-access', [\App\Http\Controllers\Admin\EnrollmentController::class, 'toggleAccess'])->name('enrollments.toggleAccess');

        // // ── Verifikasi YouTube ─────────────────────────────────────
        Route::get('verifications', [\App\Http\Controllers\Admin\YoutubeVerificationController::class, 'index'])->name('verifications.index');
        Route::get('verifications/{verification}', [\App\Http\Controllers\Admin\YoutubeVerificationController::class, 'show'])->name('verifications.show');
        Route::patch('verifications/{verification}/approve', [\App\Http\Controllers\Admin\YoutubeVerificationController::class, 'approve'])->name('verifications.approve');
        Route::patch('verifications/{verification}/reject', [\App\Http\Controllers\Admin\YoutubeVerificationController::class, 'reject'])->name('verifications.reject');

        // // ── Order ──────────────────────────────────────────────────
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show']);

        // // ── Review ─────────────────────────────────────────────────
        Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'destroy']);
        Route::patch('reviews/{review}/toggle', [\App\Http\Controllers\Admin\ReviewController::class, 'toggle'])->name('reviews.toggle');

        // // ── Blog ───────────────────────────────────────────────────
        Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
        Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class);
        Route::resource('blog-comments', \App\Http\Controllers\Admin\BlogCommentController::class)->only(['index', 'destroy']);
        Route::patch('blog-comments/{comment}/toggle', [\App\Http\Controllers\Admin\BlogCommentController::class, 'toggle'])->name('blog-comments.toggle');

        // // ── Portfolio ──────────────────────────────────────────────
        Route::resource('portfolios', \App\Http\Controllers\Admin\PortfolioController::class);
        Route::post('portfolios/reorder', [\App\Http\Controllers\Admin\PortfolioController::class, 'reorder'])->name('portfolios.reorder');

        // ── Konten Halaman ─────────────────────────────────────────
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
        Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);
        Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
        Route::resource('social-links', \App\Http\Controllers\Admin\SocialLinkController::class);

        // ── Pesan Masuk ────────────────────────────────────────────
        Route::get('contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
        Route::patch('contacts/{contact}/read', [\App\Http\Controllers\Admin\ContactController::class, 'markRead'])->name('contacts.read');
        Route::delete('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

        // ── Newsletter ─────────────────────────────────────────────
        Route::get('newsletters', [\App\Http\Controllers\Admin\NewsletterController::class, 'index'])->name('newsletters.index');
        Route::delete('newsletters/{newsletter}', [\App\Http\Controllers\Admin\NewsletterController::class, 'destroy'])->name('newsletters.destroy');

        // ── Diskusi ────────────────────────────────────────────────
        Route::resource('discussions', \App\Http\Controllers\Admin\DiscussionController::class)->only(['index', 'show', 'destroy']);
        Route::resource('discussion-replies', \App\Http\Controllers\Admin\DiscussionReplyController::class)->only(['destroy']);

        // ── Settings ───────────────────────────────────────────────
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    });
});