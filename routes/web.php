<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ContactController;

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