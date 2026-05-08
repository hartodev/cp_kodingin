<?php

use Illuminate\Support\Facades\Route;
// ============================================================
// API v1
// ============================================================
 
Route::prefix('v1')->name('api.')->group(function () {
 
    // ==============================================
    // PUBLIC — tidak perlu login
    // ==============================================
 
    // Auth
    Route::post('/auth/register', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'store'])->name('auth.register');
    Route::post('/auth/login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'store'])->name('auth.login');
 
    // Kursus
    Route::get('/courses', [\App\Http\Controllers\Api\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{slug}', [\App\Http\Controllers\Api\CourseController::class, 'show'])->name('courses.show');
    Route::get('/categories', [\App\Http\Controllers\Api\CourseCategoryController::class, 'index'])->name('categories.index');
    Route::get('/levels', [\App\Http\Controllers\Api\CourseLevelController::class, 'index'])->name('levels.index');
    Route::get('/tags', [\App\Http\Controllers\Api\TagController::class, 'index'])->name('tags.index');
 
    // Blog
    Route::get('/blogs', [\App\Http\Controllers\Api\BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/{slug}', [\App\Http\Controllers\Api\BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blog-categories', [\App\Http\Controllers\Api\BlogCategoryController::class, 'index'])->name('blog-categories.index');
 
    // Halaman depan
    Route::get('/testimonials', [\App\Http\Controllers\Api\TestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('/faqs', [\App\Http\Controllers\Api\FaqController::class, 'index'])->name('faqs.index');
    Route::get('/banners', [\App\Http\Controllers\Api\BannerController::class, 'index'])->name('banners.index');
    Route::get('/social-links', [\App\Http\Controllers\Api\SocialLinkController::class, 'index'])->name('social-links.index');
    Route::get('/portfolio', [\App\Http\Controllers\Api\PortfolioController::class, 'index'])->name('portfolio.index');
 
    // Contact & Newsletter
    Route::post('/contact', [\App\Http\Controllers\Api\ContactController::class, 'store'])->name('contact.store');
    Route::post('/newsletter/subscribe', [\App\Http\Controllers\Api\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
 
    // ============================================================
    // USER — auth:sanctum + role:user
    // ============================================================
 
    Route::middleware(['auth:sanctum', 'role:user'])
        ->name('user.')
        ->group(function () {
 
            // Auth
            Route::post('/auth/logout', [\App\Http\Controllers\Api\Auth\LoginController::class, 'destroy'])->name('auth.logout');
            Route::get('/auth/me', [\App\Http\Controllers\Api\Auth\LoginController::class, 'me'])->name('auth.me');
 
            // Profile
            Route::get('/profile', [\App\Http\Controllers\Api\User\ProfileController::class, 'show'])->name('profile.show');
            Route::put('/profile', [\App\Http\Controllers\Api\User\ProfileController::class, 'update'])->name('profile.update');
            Route::put('/profile/password', [\App\Http\Controllers\Api\User\ProfileController::class, 'updatePassword'])->name('profile.password');
 
            // My Courses
            Route::get('/my-courses', [\App\Http\Controllers\Api\User\EnrollmentController::class, 'index'])->name('my-courses.index');
 
            // Wishlist
            Route::get('/wishlist', [\App\Http\Controllers\Api\User\WishlistController::class, 'index'])->name('wishlist.index');
            Route::post('/wishlist/toggle/{course}', [\App\Http\Controllers\Api\User\WishlistController::class, 'toggle'])->name('wishlist.toggle');
 
            // Cart
            Route::get('/cart', [\App\Http\Controllers\Api\User\CartController::class, 'index'])->name('cart.index');
            Route::post('/cart', [\App\Http\Controllers\Api\User\CartController::class, 'store'])->name('cart.store');
            Route::delete('/cart/{cart}', [\App\Http\Controllers\Api\User\CartController::class, 'destroy'])->name('cart.destroy');
 
            // Checkout & Verifikasi YouTube
            Route::post('/checkout', [\App\Http\Controllers\Api\User\CheckoutController::class, 'store'])->name('checkout.store');
            Route::get('/checkout/{order}', [\App\Http\Controllers\Api\User\CheckoutController::class, 'show'])->name('checkout.show');
            Route::post('/verification/{order}/submit', [\App\Http\Controllers\Api\User\YoutubeVerificationController::class, 'submit'])->name('verification.submit');
            Route::get('/verification/{order}/status', [\App\Http\Controllers\Api\User\YoutubeVerificationController::class, 'status'])->name('verification.status');
 
            // Notifikasi
            Route::get('/notifications', [\App\Http\Controllers\Api\User\NotificationController::class, 'index'])->name('notifications.index');
            Route::post('/notifications/{notification}/read', [\App\Http\Controllers\Api\User\NotificationController::class, 'markRead'])->name('notifications.read');
            Route::post('/notifications/read-all', [\App\Http\Controllers\Api\User\NotificationController::class, 'readAll'])->name('notifications.readAll');
 
            // Sertifikat
            Route::get('/certificates', [\App\Http\Controllers\Api\User\CertificateController::class, 'index'])->name('certificates.index');
            Route::get('/certificates/{certificate}/download', [\App\Http\Controllers\Api\User\CertificateController::class, 'download'])->name('certificates.download');
 
            // ── Halaman Belajar (harus enroll) ────────────────────
            Route::middleware('enrolled')->group(function () {
                Route::get('/learn/{course}', [\App\Http\Controllers\Api\User\LearnController::class, 'index'])->name('learn.index');
                Route::get('/learn/{course}/lessons', [\App\Http\Controllers\Api\User\LearnController::class, 'lessons'])->name('learn.lessons');
                Route::get('/learn/{course}/lessons/{lesson}', [\App\Http\Controllers\Api\User\LearnController::class, 'show'])->name('learn.show');
                Route::post('/learn/{course}/lessons/{lesson}/progress', [\App\Http\Controllers\Api\User\LearnController::class, 'updateProgress'])->name('learn.progress');
            });
 
            // Review kursus
            Route::post('/courses/{course}/review', [\App\Http\Controllers\Api\User\ReviewController::class, 'store'])->name('reviews.store');
            Route::put('/courses/{course}/review', [\App\Http\Controllers\Api\User\ReviewController::class, 'update'])->name('reviews.update');
            Route::delete('/courses/{course}/review', [\App\Http\Controllers\Api\User\ReviewController::class, 'destroy'])->name('reviews.destroy');
 
            // Diskusi kursus
            Route::get('/courses/{course}/discussions', [\App\Http\Controllers\Api\User\DiscussionController::class, 'index'])->name('discussions.index');
            Route::post('/courses/{course}/discussions', [\App\Http\Controllers\Api\User\DiscussionController::class, 'store'])->name('discussions.store');
            Route::delete('/discussions/{thread}', [\App\Http\Controllers\Api\User\DiscussionController::class, 'destroy'])->name('discussions.destroy');
            Route::get('/discussions/{thread}/replies', [\App\Http\Controllers\Api\User\DiscussionReplyController::class, 'index'])->name('discussions.replies.index');
            Route::post('/discussions/{thread}/replies', [\App\Http\Controllers\Api\User\DiscussionReplyController::class, 'store'])->name('discussions.replies.store');
            Route::post('/discussions/replies/{reply}/answer', [\App\Http\Controllers\Api\User\DiscussionReplyController::class, 'markAnswer'])->name('discussions.replies.answer');
            Route::delete('/discussions/replies/{reply}', [\App\Http\Controllers\Api\User\DiscussionReplyController::class, 'destroy'])->name('discussions.replies.destroy');
 
            // Komentar blog
            Route::post('/blogs/{blog}/comments', [\App\Http\Controllers\Api\User\BlogCommentController::class, 'store'])->name('blog.comments.store');
            Route::delete('/blogs/comments/{comment}', [\App\Http\Controllers\Api\User\BlogCommentController::class, 'destroy'])->name('blog.comments.destroy');
        });
 
    // ============================================================
    // ADMIN — auth:sanctum + role:admin
    // ============================================================
 
    Route::middleware(['auth:sanctum', 'role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
 
            // Dashboard stats
            Route::get('/dashboard', [\App\Http\Controllers\Api\Admin\DashboardController::class, 'index'])->name('dashboard');
 
            // ── Manajemen Kursus ───────────────────────────────────
            Route::apiResource('courses', \App\Http\Controllers\Api\Admin\CourseController::class);
            Route::apiResource('courses.chapters', \App\Http\Controllers\Api\Admin\CourseChapterController::class);
            Route::apiResource('courses.chapters.lessons', \App\Http\Controllers\Api\Admin\CourseLessonController::class);
            Route::post('courses/{course}/chapters/reorder', [\App\Http\Controllers\Api\Admin\CourseChapterController::class, 'reorder'])->name('courses.chapters.reorder');
            Route::post('courses/{course}/chapters/{chapter}/lessons/reorder', [\App\Http\Controllers\Api\Admin\CourseLessonController::class, 'reorder'])->name('courses.chapters.lessons.reorder');
 
            // Kategori, Level, Tag
            Route::apiResource('categories', \App\Http\Controllers\Api\Admin\CourseCategoryController::class);
            Route::apiResource('levels', \App\Http\Controllers\Api\Admin\CourseLevelController::class);
            Route::apiResource('tags', \App\Http\Controllers\Api\Admin\TagController::class);
 
            // ── Manajemen User & Enrollment ────────────────────────
            Route::apiResource('users', \App\Http\Controllers\Api\Admin\UserController::class);
            Route::apiResource('enrollments', \App\Http\Controllers\Api\Admin\EnrollmentController::class)->only(['index', 'show', 'destroy']);
            Route::patch('enrollments/{enrollment}/toggle-access', [\App\Http\Controllers\Api\Admin\EnrollmentController::class, 'toggleAccess'])->name('enrollments.toggleAccess');
 
            // ── Verifikasi YouTube ─────────────────────────────────
            Route::get('verifications', [\App\Http\Controllers\Api\Admin\YoutubeVerificationController::class, 'index'])->name('verifications.index');
            Route::get('verifications/{verification}', [\App\Http\Controllers\Api\Admin\YoutubeVerificationController::class, 'show'])->name('verifications.show');
            Route::patch('verifications/{verification}/approve', [\App\Http\Controllers\Api\Admin\YoutubeVerificationController::class, 'approve'])->name('verifications.approve');
            Route::patch('verifications/{verification}/reject', [\App\Http\Controllers\Api\Admin\YoutubeVerificationController::class, 'reject'])->name('verifications.reject');
 
            // ── Order ──────────────────────────────────────────────
            Route::apiResource('orders', \App\Http\Controllers\Api\Admin\OrderController::class)->only(['index', 'show']);
 
            // ── Review ─────────────────────────────────────────────
            Route::apiResource('reviews', \App\Http\Controllers\Api\Admin\ReviewController::class)->only(['index', 'destroy']);
            Route::patch('reviews/{review}/toggle', [\App\Http\Controllers\Api\Admin\ReviewController::class, 'toggle'])->name('reviews.toggle');
 
            // ── Blog ───────────────────────────────────────────────
            Route::apiResource('blogs', \App\Http\Controllers\Api\Admin\BlogController::class);
            Route::apiResource('blog-categories', \App\Http\Controllers\Api\Admin\BlogCategoryController::class);
            Route::apiResource('blog-comments', \App\Http\Controllers\Api\Admin\BlogCommentController::class)->only(['index', 'destroy']);
            Route::patch('blog-comments/{comment}/toggle', [\App\Http\Controllers\Api\Admin\BlogCommentController::class, 'toggle'])->name('blog-comments.toggle');
 
            // ── Portfolio ──────────────────────────────────────────
            Route::apiResource('portfolios', \App\Http\Controllers\Api\Admin\PortfolioController::class);
            Route::post('portfolios/reorder', [\App\Http\Controllers\Api\Admin\PortfolioController::class, 'reorder'])->name('portfolios.reorder');
 
            // ── Konten Halaman ─────────────────────────────────────
            Route::apiResource('testimonials', \App\Http\Controllers\Api\Admin\TestimonialController::class);
            Route::apiResource('faqs', \App\Http\Controllers\Api\Admin\FaqController::class);
            Route::apiResource('banners', \App\Http\Controllers\Api\Admin\BannerController::class);
            Route::apiResource('social-links', \App\Http\Controllers\Api\Admin\SocialLinkController::class);
 
            // ── Contact & Newsletter ───────────────────────────────
            Route::get('contacts', [\App\Http\Controllers\Api\Admin\ContactController::class, 'index'])->name('contacts.index');
            Route::get('contacts/{contact}', [\App\Http\Controllers\Api\Admin\ContactController::class, 'show'])->name('contacts.show');
            Route::patch('contacts/{contact}/read', [\App\Http\Controllers\Api\Admin\ContactController::class, 'markRead'])->name('contacts.read');
            Route::delete('contacts/{contact}', [\App\Http\Controllers\Api\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');
            Route::get('newsletters', [\App\Http\Controllers\Api\Admin\NewsletterController::class, 'index'])->name('newsletters.index');
            Route::delete('newsletters/{newsletter}', [\App\Http\Controllers\Api\Admin\NewsletterController::class, 'destroy'])->name('newsletters.destroy');
 
            // ── Diskusi ────────────────────────────────────────────
            Route::apiResource('discussions', \App\Http\Controllers\Api\Admin\DiscussionController::class)->only(['index', 'show', 'destroy']);
            Route::apiResource('discussion-replies', \App\Http\Controllers\Api\Admin\DiscussionReplyController::class)->only(['destroy']);
 
            // ── Settings ───────────────────────────────────────────
            Route::get('settings', [\App\Http\Controllers\Api\Admin\SettingController::class, 'index'])->name('settings.index');
            Route::post('settings', [\App\Http\Controllers\Api\Admin\SettingController::class, 'update'])->name('settings.update');
        });
});