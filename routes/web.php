<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\WhyMhController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\SolutionController as AdminSolutionController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\CmsSettingController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\SmtpSettingController;
use App\Http\Controllers\Admin\MediaController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ────────────────────────────────────────────────────────────
Route::get('/',              [HomeController::class,       'index'])->name('home');
Route::get('/about-us',      [AboutController::class,      'index'])->name('about');
Route::get('/solutions',     [SolutionController::class,   'index'])->name('solutions');
Route::get('/solutions/{slug}', [SolutionController::class,'show'])->name('solutions.show');
Route::get('/how-it-works',  [HowItWorksController::class, 'index'])->name('how-it-works');
Route::get('/why-mh',        [WhyMhController::class,      'index'])->name('why-mh');
Route::get('/contact',       [ContactController::class,    'index'])->name('contact');

// Inquiry AJAX submission
Route::post('/inquiry',      [InquiryController::class,    'store'])->name('inquiry.store');

// Login redirect alias for default Laravel auth middleware
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// ─── Admin Auth ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

    // ─── Protected Admin Routes ───────────────────────────────────────────────
    Route::middleware(['auth', 'admin'])->group(function () {

        // Dashboard
        Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');

        // Inquiries
        Route::get('/inquiries',             [AdminInquiryController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/{inquiry}',   [AdminInquiryController::class, 'show'])->name('inquiries.show');
        Route::patch('/inquiries/{inquiry}', [AdminInquiryController::class, 'update'])->name('inquiries.update');

        // Solutions
        Route::get('/solutions',                    [AdminSolutionController::class, 'index'])->name('solutions.index');
        Route::get('/solutions/{solution}/edit',    [AdminSolutionController::class, 'edit'])->name('solutions.edit');
        Route::put('/solutions/{solution}',         [AdminSolutionController::class, 'update'])->name('solutions.update');
        Route::patch('/solutions/{solution}/toggle',[AdminSolutionController::class, 'toggle'])->name('solutions.toggle');

        // Testimonials
        Route::resource('testimonials', TestimonialController::class)->except(['show']);

        // Page Content (About Us & Why MH separately)
        Route::get('/pages/about',      [PageContentController::class, 'about'])->name('pages.about');
        Route::put('/pages/about',      [PageContentController::class, 'updateAbout'])->name('pages.about.update');
        Route::get('/pages/why-mh',     [PageContentController::class, 'whyMh'])->name('pages.why-mh');
        Route::put('/pages/why-mh',     [PageContentController::class, 'updateWhyMh'])->name('pages.why-mh.update');

        // CMS Settings
        Route::get('/settings',     [CmsSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings',     [CmsSettingController::class, 'update'])->name('settings.update');

        // SMTP Settings
        Route::get('/smtp',         [SmtpSettingController::class, 'index'])->name('smtp.index');
        Route::put('/smtp',         [SmtpSettingController::class, 'update'])->name('smtp.update');
        Route::post('/smtp/test',   [SmtpSettingController::class, 'test'])->name('smtp.test');

        // Media / Image Upload
        Route::post('/media/upload',[MediaController::class, 'upload'])->name('media.upload');
    });
});
