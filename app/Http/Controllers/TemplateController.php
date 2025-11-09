<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $categories = [
            'all' => 'Semua Template',
            'desa' => '🌾 Desa',
            'umkm' => '🛍️ UMKM',
            'komunitas' => '👥 Komunitas',
            'ecommerce' => '🛒 E-Commerce'
        ];
        
        $templates = $this->getTemplates($request->get('category', 'all'));
        
        return view('pages.templates', compact('categories', 'templates'));
    }
    
    public function category($category)
    {
        $templates = $this->getTemplates($category);
        return view('pages.templates', compact('templates', 'category'));
    }
    
    public function show($id)
    {
        $template = $this->getTemplateById($id);
        return view('pages.template-detail', compact('template'));
    }
    
    public function search(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category', 'all');
        
        $templates = $this->searchTemplates($query, $category);
        
        return response()->json($templates);
    }
    
    private function getTemplates($category = 'all')
    {
        // Mock data - dalam implementasi nyata, ambil dari database
        $allTemplates = [
            [
                'id' => 1,
                'name' => 'Desa Modern',
                'category' => 'desa',
                'image' => 'templates/desa-modern.jpg',
                'description' => 'Template untuk website desa dengan fitur lengkap administrasi dan informasi publik',
                'views' => 1200,
                'likes' => 89,
                'rating' => 5,
                'is_premium' => false,
                'features' => ['Responsive Design', 'Admin Panel', 'SEO Optimized']
            ],
            [
                'id' => 2,
                'name' => 'Toko Online Pro',
                'category' => 'umkm',
                'image' => 'templates/toko-online.jpg',
                'description' => 'E-commerce lengkap dengan sistem pembayaran dan manajemen inventori',
                'views' => 2800,
                'likes' => 156,
                'rating' => 5,
                'is_premium' => true,
                'features' => ['Payment Gateway', 'Inventory Management', 'Analytics']
            ]
        ];
        
        if ($category === 'all') {
            return $allTemplates;
        }
        
        return array_filter($allTemplates, function($template) use ($category) {
            return $template['category'] === $category;
        });
    }
    
    private function getTemplateById($id)
    {
        $templates = $this->getTemplates();
        return collect($templates)->firstWhere('id', $id);
    }
    
    private function searchTemplates($query, $category)
    {
        $templates = $this->getTemplates($category);
        
        return array_filter($templates, function($template) use ($query) {
            return stripos($template['name'], $query) !== false || 
                   stripos($template['description'], $query) !== false;
        });
    }
}