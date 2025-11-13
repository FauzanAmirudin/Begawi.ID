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
use App\Http\Controllers\Auth\AuthenticatedSessionController;
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
});