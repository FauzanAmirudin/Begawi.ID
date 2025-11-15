<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Route model binding for UMKM products
        // Only bind if value is numeric to avoid conflicts with specific routes like 'stock', 'categories', 'create'
        \Illuminate\Support\Facades\Route::bind('product', function ($value, $route) {
            // Check if value is numeric (ID) to avoid conflicts with route names
            if (!is_numeric($value)) {
                abort(404, 'Product ID harus berupa angka.');
            }
            
            $product = \App\Models\UmkmProduct::find($value);
            if (!$product) {
                abort(404, 'Produk tidak ditemukan.');
            }
            
            return $product;
        });

        \Illuminate\Support\Facades\Route::bind('category', function ($value, $route) {
            // Check if value is numeric (ID) to avoid conflicts
            if (!is_numeric($value)) {
                abort(404, 'Category ID harus berupa angka.');
            }
            
            $category = \App\Models\UmkmProductCategory::find($value);
            if (!$category) {
                abort(404, 'Kategori tidak ditemukan.');
            }
            
            return $category;
        });
    }
}
