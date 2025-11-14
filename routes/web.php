<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Desa\DesaController;
use App\Http\Controllers\Desa\BeritaController;
use App\Http\Controllers\Desa\UmkmController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\SupportArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\PlatformDirectoryController;
use App\Http\Controllers\Admin\VillageManagementController;
use App\Http\Controllers\Admin\VillageProfileController;
use App\Http\Controllers\Admin\VillageNewsController;
use App\Http\Controllers\Admin\VillageGalleryController;
use App\Http\Controllers\Admin\VillagePotentialController;
use App\Http\Controllers\Admin\VillageAchievementController;
use App\Http\Controllers\Admin\VillageProgramController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Main Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/templates', [TemplateController::class, 'index'])->name('templates');
Route::get('/templates/{category}', [TemplateController::class, 'category'])->name('templates.category');
Route::get('/template/{id}', [TemplateController::class, 'show'])->name('template.show');

Route::get('/directory', [DirectoryController::class, 'index'])->name('directory');
Route::get('/directory/{type}', [DirectoryController::class, 'type'])->name('directory.type');
Route::get('/directory/detail/{id}', [DirectoryController::class, 'show'])->name('directory.show');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/education', [EducationController::class, 'index'])->name('education');
Route::get('/education/{category}', [EducationController::class, 'category'])->name('education.category');
Route::get('/education/article/{slug}', [EducationController::class, 'article'])->name('education.article');
Route::get('/education/video/{slug}', [EducationController::class, 'video'])->name('education.video');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// API Routes for AJAX
Route::prefix('api')->group(function () {
    Route::get('/templates/search', [TemplateController::class, 'search'])->name('api.templates.search');
    Route::get('/directory/search', [DirectoryController::class, 'search'])->name('api.directory.search');
    Route::post('/newsletter/subscribe', [HomeController::class, 'newsletter'])->name('api.newsletter');
    Route::post('/contact/quick', [ContactController::class, 'quickContact'])->name('api.contact.quick');
});

// Static Pages
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/sitemap', 'pages.sitemap')->name('sitemap');

// Template Desa Routes
Route::prefix('desa')->name('desa.')->group(function () {
    Route::get('/', [DesaController::class, 'home'])->name('home');
    Route::get('/about', [DesaController::class, 'about'])->name('about');
    
    // Routes Berita
    Route::prefix('berita')->name('berita.')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('index');
        Route::get('/tambah', [BeritaController::class, 'tambah'])->name('tambah');
        Route::get('/edit/{id}', [BeritaController::class, 'edit'])->name('edit');
        Route::get('/arsip', [BeritaController::class, 'arsip'])->name('arsip');
        Route::get('/agenda', [BeritaController::class, 'agenda'])->name('agenda');
        Route::get('/{slug}', [BeritaController::class, 'detail'])->name('detail');
        Route::get('/agenda/detail/{id}', [BeritaController::class, 'agendaDetail'])->name('agenda-detail');
    });

    // Routes UMKM
    Route::prefix('umkm')->name('umkm.')->group(function () {
        Route::get('/', [UmkmController::class, 'index'])->name('index');
        Route::get('/kategori/{kategori}', [UmkmController::class, 'kategori'])->name('kategori');
        Route::get('/produk/{slug}', [UmkmController::class, 'detail'])->name('detail');
        Route::get('/toko/{slug}', [UmkmController::class, 'toko'])->name('toko');
    });

    Route::prefix('layanan')->name('layanan.')->group(function () {
        Route::get('/', [App\Http\Controllers\Desa\LayananController::class, 'index'])->name('index');
        Route::post('/submit-surat', [App\Http\Controllers\Desa\LayananController::class, 'submitSurat'])->name('submit-surat');
        Route::post('/submit-pengaduan', [App\Http\Controllers\Desa\LayananController::class, 'submitPengaduan'])->name('submit-pengaduan');
        Route::post('/track-status', [App\Http\Controllers\Desa\LayananController::class, 'trackStatus'])->name('track-status');
        Route::get('/download-arsip/{id}', [App\Http\Controllers\Desa\LayananController::class, 'downloadArsip'])->name('download-arsip');
    });
    // Routes Pusat Bantuan
    Route::prefix('pusat-bantuan')->name('pusat-bantuan.')->group(function () {
        Route::get('/', [App\Http\Controllers\Desa\PusatBantuanController::class, 'index'])->name('index');
        Route::post('/submit-laporan', [App\Http\Controllers\Desa\PusatBantuanController::class, 'submitLaporan'])->name('submit-laporan');
        Route::get('/tutorial/{id}', [App\Http\Controllers\Desa\PusatBantuanController::class, 'getTutorialDetail'])->name('tutorial-detail');
        Route::get('/video/{id}', [App\Http\Controllers\Desa\PusatBantuanController::class, 'getVideoDetail'])->name('video-detail');
        Route::get('/artikel/{id}', [App\Http\Controllers\Desa\PusatBantuanController::class, 'getArticleDetail'])->name('artikel-detail');
    });
        
    // Routes Galeri & Wisata (Combined Page)
    Route::get('/galeri-wisata', [App\Http\Controllers\Desa\GaleriWisataController::class, 'index'])->name('galeri-wisata.index');
    Route::post('/galeri-wisata/upload', [App\Http\Controllers\Desa\GaleriWisataController::class, 'uploadStore'])->name('galeri-wisata.upload');

    Route::get('/contact', [DesaController::class, 'contact'])->name('contact');
    Route::get('/directory', [DesaController::class, 'directory'])->name('directory');
    Route::get('/education', [DesaController::class, 'education'])->name('education');
    Route::get('/privacy', [DesaController::class, 'privacy'])->name('privacy');
    Route::get('/sitemap', [DesaController::class, 'sitemap'])->name('sitemap');
    Route::get('/terms', [DesaController::class, 'terms'])->name('terms');
    Route::get('/templates', [DesaController::class, 'templates'])->name('templates');
});

// Admin Dashboard Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/platform-directory', [PlatformDirectoryController::class, 'index'])->name('platform-directory.index');
    Route::get('/desa-management', [VillageManagementController::class, 'index'])
        ->middleware('admin:admin_desa,super_admin')
        ->name('desa-management.index');
    Route::prefix('desa-management')->name('desa-management.')->middleware('admin:admin_desa,super_admin')->group(function () {
        Route::get('/umkm', [VillageManagementController::class, 'umkm'])->name('umkm');
        
        // UMKM Management Routes
        Route::post('/umkm', [\App\Http\Controllers\Admin\UmkmManagementController::class, 'store'])->name('umkm.store');
        Route::post('/umkm/{umkm}/status', [\App\Http\Controllers\Admin\UmkmManagementController::class, 'updateStatus'])->name('umkm.update-status');
        Route::post('/umkm/products', [\App\Http\Controllers\Admin\UmkmManagementController::class, 'storeProduct'])->name('umkm.products.store');
        Route::post('/umkm/content/{validation}/approve', [\App\Http\Controllers\Admin\UmkmManagementController::class, 'approveContent'])->name('umkm.content.approve');
        Route::post('/umkm/content/{validation}/reject', [\App\Http\Controllers\Admin\UmkmManagementController::class, 'rejectContent'])->name('umkm.content.reject');
        Route::post('/umkm/content/{validation}/revision', [\App\Http\Controllers\Admin\UmkmManagementController::class, 'requestRevision'])->name('umkm.content.revision');
        Route::post('/umkm/guides', [\App\Http\Controllers\Admin\UmkmManagementController::class, 'storeGuide'])->name('umkm.guides.store');
        
        Route::put('/profile', [VillageProfileController::class, 'update'])->name('profile.update');
        
        // Reports & Statistics
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('index');
            Route::get('/visitor-statistics', [\App\Http\Controllers\Admin\ReportsController::class, 'visitorStatistics'])->name('visitor-statistics');
            Route::get('/umkm-statistics', [\App\Http\Controllers\Admin\ReportsController::class, 'umkmStatistics'])->name('umkm-statistics');
            Route::get('/digitalization-report', [\App\Http\Controllers\Admin\ReportsController::class, 'digitalizationReport'])->name('digitalization-report');
            Route::get('/umkm-ranking', [\App\Http\Controllers\Admin\ReportsController::class, 'umkmRanking'])->name('umkm-ranking');
        });

        // Local User Management
        Route::prefix('local-users')->name('local-users.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\LocalUserManagementController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\LocalUserManagementController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\LocalUserManagementController::class, 'store'])->name('store');
            Route::get('/roles', [\App\Http\Controllers\Admin\LocalUserManagementController::class, 'roles'])->name('roles');
            Route::post('/{user}/reset-password', [\App\Http\Controllers\Admin\LocalUserManagementController::class, 'resetPassword'])->name('reset-password');
            Route::post('/{user}/toggle-status', [\App\Http\Controllers\Admin\LocalUserManagementController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{user}/update-role', [\App\Http\Controllers\Admin\LocalUserManagementController::class, 'updateRole'])->name('update-role');
        });

        Route::post('/news', [VillageNewsController::class, 'store'])->name('news.store');
        Route::put('/news/{news}', [VillageNewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{news}', [VillageNewsController::class, 'destroy'])->name('news.destroy');

        Route::post('/gallery', [VillageGalleryController::class, 'store'])->name('gallery.store');
        Route::delete('/gallery/{item}', [VillageGalleryController::class, 'destroy'])->name('gallery.destroy');

        Route::post('/potentials', [VillagePotentialController::class, 'store'])->name('potentials.store');
        Route::put('/potentials/{potential}', [VillagePotentialController::class, 'update'])->name('potentials.update');
        Route::delete('/potentials/{potential}', [VillagePotentialController::class, 'destroy'])->name('potentials.destroy');

        Route::post('/achievements', [VillageAchievementController::class, 'store'])->name('achievements.store');
        Route::put('/achievements/{achievement}', [VillageAchievementController::class, 'update'])->name('achievements.update');
        Route::delete('/achievements/{achievement}', [VillageAchievementController::class, 'destroy'])->name('achievements.destroy');

        Route::post('/programs', [VillageProgramController::class, 'store'])->name('programs.store');
        Route::put('/programs/{program}', [VillageProgramController::class, 'update'])->name('programs.update');
        Route::delete('/programs/{program}', [VillageProgramController::class, 'destroy'])->name('programs.destroy');
    });
    
    // User Management (Super Admin Only)
    Route::resource('users', \App\Http\Controllers\Admin\UserManagementController::class);
    Route::post('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/reset-password', [\App\Http\Controllers\Admin\UserManagementController::class, 'resetPassword'])->name('users.reset-password');
    
    // Website Management (Super Admin Only)
    Route::prefix('websites')->name('websites.')->group(function () {
        Route::get('/desa', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'desa'])->name('desa');
        Route::get('/umkm', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'umkm'])->name('umkm');
        Route::get('/domain', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'domain'])->name('domain');
        Route::get('/template', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'template'])->name('template');
        Route::post('/template', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'updateTemplate'])->name('template.update');
        Route::get('/{website}', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'show'])->name('show');
        Route::get('/{website}/edit', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'edit'])->name('edit');
        Route::put('/{website}', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'update'])->name('update');
        Route::post('/{website}/suspend', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'suspend'])->name('suspend');
        Route::post('/{website}/activate', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'activate'])->name('activate');
        Route::post('/{website}/activate-domain', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'activateDomain'])->name('activate-domain');
        Route::delete('/{website}', [\App\Http\Controllers\Admin\WebsiteManagementController::class, 'destroy'])->name('destroy');
    });

    // Finance & Transactions (Super Admin Only)
    Route::prefix('finance')->name('finance.')->group(function () {
        // Subscription Packages
        Route::resource('packages', \App\Http\Controllers\Admin\SubscriptionPackageController::class);
        
        // Transactions
        Route::get('/transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{transaction}', [\App\Http\Controllers\Admin\TransactionController::class, 'show'])->name('transactions.show');
        
        // Payment Gateways
        Route::get('/payment-gateways', [\App\Http\Controllers\Admin\PaymentGatewayController::class, 'index'])->name('payment-gateways.index');
        Route::get('/payment-gateways/{paymentGateway}/edit', [\App\Http\Controllers\Admin\PaymentGatewayController::class, 'edit'])->name('payment-gateways.edit');
        Route::put('/payment-gateways/{paymentGateway}', [\App\Http\Controllers\Admin\PaymentGatewayController::class, 'update'])->name('payment-gateways.update');
        Route::post('/payment-gateways', [\App\Http\Controllers\Admin\PaymentGatewayController::class, 'store'])->name('payment-gateways.store');
        
        // Finance Reports
        Route::get('/reports', [\App\Http\Controllers\Admin\FinanceReportController::class, 'index'])->name('reports.index');
    });

    // Content & Education (Super Admin Only)
    Route::prefix('content')->name('content.')->group(function () {
        // Articles
        Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
        
        // Videos & Documentation
        Route::resource('videos', \App\Http\Controllers\Admin\VideoDocumentationController::class);
        
        // Information Pages
        Route::resource('pages', \App\Http\Controllers\Admin\InformationPageController::class);
    });

    // Audit & Log Aktivitas (Super Admin Only)
    Route::prefix('logs')->name('logs.')->group(function () {
        Route::get('/user-activity', [ActivityLogController::class, 'userActivity'])->name('user');
        Route::get('/system-audit', [ActivityLogController::class, 'systemAudit'])->name('system');
        Route::get('/download-report-page', [ActivityLogController::class, 'reportPage'])->name('download.page');
        Route::get('/download-report', [ActivityLogController::class, 'downloadReport'])->name('download');
    });

    // Support & Pengaduan (All Admin Roles)
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [SupportController::class, 'index'])->name('index');
        Route::get('/tickets', [SupportController::class, 'tickets'])->name('tickets');
        Route::get('/tickets/{ticket}', [SupportController::class, 'show'])->name('tickets.show');
        Route::get('/documentation', [SupportController::class, 'documentation'])->name('documentation');
        Route::get('/documentation/{slug}', [SupportController::class, 'documentationShow'])->name('documentation.show');
        Route::get('/contact', [SupportController::class, 'contact'])->name('contact');
        Route::post('/contact', [SupportController::class, 'submitContact'])->name('contact.submit');
        Route::resource('articles', SupportArticleController::class)->except(['show']);
    });
});