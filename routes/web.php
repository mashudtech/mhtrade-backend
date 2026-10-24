<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CmsSettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SmtpSettingController;
use App\Http\Controllers\Admin\SolutionController as AdminSolutionController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\WhyMhController;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class,       'index'])->name('home');
Route::get('/about-us', [AboutController::class,      'index'])->name('about');
Route::get('/solutions', [SolutionController::class,   'index'])->name('solutions');
Route::get('/solutions/{slug}', [SolutionController::class, 'show'])->name('solutions.show');
Route::get('/how-it-works', [HowItWorksController::class, 'index'])->name('how-it-works');
Route::get('/why-mh', [WhyMhController::class,      'index'])->name('why-mh');
Route::get('/contact', [ContactController::class,    'index'])->name('contact');

// Inquiry AJAX submission
Route::post('/inquiry', [InquiryController::class,    'store'])->name('inquiry.store');

// Automated CI/CD deployment cache clear and migration webhook
Route::get('/api/deploy-cache-clear', function (Request $request) {
    $expected = config('app.deploy_secret') ?: env('DEPLOY_SECRET', 'mhtrade_secure_deploy_2026');
    $token = (string) $request->query('token');
    if (empty($expected) || ! hash_equals((string) $expected, $token)) {
        abort(403, 'Unauthorized deploy request.');
    }

    $migrateOutput = '';
    try {
        Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = trim(Artisan::output());

        // Set default prefixes and sequence start numbers for the core 5 solutions if not set
        Solution::where('slug', 'trade-finance')->whereNull('inquiry_prefix')->update(['inquiry_prefix' => 'MH-LC', 'inquiry_start_number' => 1000]);
        Solution::where('slug', 'uae-banking')->whereNull('inquiry_prefix')->update(['inquiry_prefix' => 'MH-BANK', 'inquiry_start_number' => 3000]);
        Solution::where('slug', 'project-finance')->whereNull('inquiry_prefix')->update(['inquiry_prefix' => 'MH-PROJ', 'inquiry_start_number' => 5000]);
        Solution::where('slug', 'commodity-trade')->whereNull('inquiry_prefix')->update(['inquiry_prefix' => 'MH-COM', 'inquiry_start_number' => 7000]);
        Solution::where('slug', 'general-inquiry')->whereNull('inquiry_prefix')->update(['inquiry_prefix' => 'MH-REQ', 'inquiry_start_number' => 9000]);
    } catch (Throwable $e) {
        $migrateOutput = 'Migration error: '.$e->getMessage();
    }

    Artisan::call('optimize:clear');
    $cacheOutput = trim(Artisan::output());

    return response()->json([
        'success' => true,
        'message' => 'Application updated, migrated, and cache cleared successfully.',
        'migration' => $migrateOutput,
        'cache' => $cacheOutput,
        'timestamp' => now()->toIso8601String(),
    ]);
});

// Login redirect alias for default Laravel auth middleware
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// ─── Admin Auth ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ─── Protected Admin Routes ───────────────────────────────────────────────
    Route::middleware(['auth', 'admin'])->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Inquiries
        Route::get('/inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/export', [AdminInquiryController::class, 'export'])->name('inquiries.export');
        Route::get('/inquiries/{inquiry}', [AdminInquiryController::class, 'show'])->name('inquiries.show');
        Route::patch('/inquiries/{inquiry}', [AdminInquiryController::class, 'update'])->name('inquiries.update');

        // Solutions
        Route::get('/solutions', [AdminSolutionController::class, 'index'])->name('solutions.index');
        Route::get('/solutions/create', [AdminSolutionController::class, 'create'])->name('solutions.create');
        Route::post('/solutions', [AdminSolutionController::class, 'store'])->name('solutions.store');
        Route::get('/solutions/{solution}/edit', [AdminSolutionController::class, 'edit'])->name('solutions.edit');
        Route::put('/solutions/{solution}', [AdminSolutionController::class, 'update'])->name('solutions.update');
        Route::delete('/solutions/{solution}', [AdminSolutionController::class, 'destroy'])->name('solutions.destroy');
        Route::patch('/solutions/{solution}/toggle', [AdminSolutionController::class, 'toggle'])->name('solutions.toggle');

        // Testimonials
        Route::resource('testimonials', TestimonialController::class)->except(['show']);

        // Hero Slides
        Route::resource('slides', HeroSlideController::class)->except(['show']);

        // Page Content (About Us & Why MH separately)
        Route::get('/pages/about', [PageContentController::class, 'about'])->name('pages.about');
        Route::put('/pages/about', [PageContentController::class, 'updateAbout'])->name('pages.about.update');
        Route::get('/pages/why-mh', [PageContentController::class, 'whyMh'])->name('pages.why-mh');
        Route::put('/pages/why-mh', [PageContentController::class, 'updateWhyMh'])->name('pages.why-mh.update');

        // CMS Settings
        Route::get('/settings', [CmsSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [CmsSettingController::class, 'update'])->name('settings.update');

        // SMTP Settings
        Route::get('/smtp', [SmtpSettingController::class, 'index'])->name('smtp.index');
        Route::put('/smtp', [SmtpSettingController::class, 'update'])->name('smtp.update');
        Route::post('/smtp/test', [SmtpSettingController::class, 'test'])->name('smtp.test');

        // Media / Image Upload
        Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');

        // Account Profile & Password
        Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::get('/password', [ProfileController::class, 'showPassword'])->name('password');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
});
