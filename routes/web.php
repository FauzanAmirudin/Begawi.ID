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
    
    Route::get('/contact', [DesaController::class, 'contact'])->name('contact');
    Route::get('/directory', [DesaController::class, 'directory'])->name('directory');
    Route::get('/education', [DesaController::class, 'education'])->name('education');
    Route::get('/privacy', [DesaController::class, 'privacy'])->name('privacy');
    Route::get('/sitemap', [DesaController::class, 'sitemap'])->name('sitemap');
    Route::get('/terms', [DesaController::class, 'terms'])->name('terms');
    Route::get('/templates', [DesaController::class, 'templates'])->name('templates');
});
// Website Builder Routes (untuk future development)
Route::prefix('builder')->group(function () {
    Route::get('/', function () {
        return view('builder.index');
    })->name('builder.index');
    
    Route::get('/templates', function () {
        return view('builder.templates');
    })->name('builder.templates');
    
    Route::get('/editor/{template?}', function ($template = null) {
        return view('builder.editor', compact('template'));
    })->name('builder.editor');
});