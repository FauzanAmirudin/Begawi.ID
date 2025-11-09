<?php

namespace App\Http\Controllers;

class EducationController extends Controller
{
    public function index()
    {
        $stats = [
            'tutorials' => 150,
            'videos' => 50,
            'webinars' => 25,
            'is_free' => true
        ];
        
        $learning_paths = [
            [
                'id' => 'pemula',
                'title' => 'Pemula',
                'subtitle' => 'Mulai dari Nol',
                'icon' => '🌱',
                'color' => 'emerald',
                'lessons' => [
                    ['title' => 'Pengenalan Website', 'completed' => true],
                    ['title' => 'Cara Memilih Template', 'completed' => true],
                    ['title' => 'Menambahkan Konten', 'completed' => true],
                    ['title' => 'Publikasi Website', 'completed' => false]
                ],
                'tutorial_count' => 8,
                'duration' => '2 jam'
            ],
            [
                'id' => 'menengah',
                'title' => 'Menengah',
                'subtitle' => 'Tingkatkan Skill',
                'icon' => '⚡',
                'color' => 'blue',
                'lessons' => [
                    ['title' => 'Kustomisasi Lanjutan', 'completed' => true],
                    ['title' => 'SEO & Optimisasi', 'completed' => true],
                    ['title' => 'Analisis Website', 'completed' => true],
                    ['title' => 'Digital Marketing', 'completed' => false]
                ],
                'tutorial_count' => 12,
                'duration' => '4 jam'
            ],
            [
                'id' => 'mahir',
                'title' => 'Mahir',
                'subtitle' => 'Jadi Expert',
                'icon' => '🏆',
                'color' => 'purple',
                'lessons' => [
                    ['title' => 'E-commerce Advanced', 'completed' => true],
                    ['title' => 'Automation & API', 'completed' => true],
                    ['title' => 'Advanced Analytics', 'completed' => true],
                    ['title' => 'Scale & Growth', 'completed' => false]
                ],
                'tutorial_count' => 15,
                'duration' => '6 jam'
            ]
        ];
        
        $featured_content = [
            [
                'id' => 1,
                'type' => 'tutorial',
                'title' => 'Cara Membuat Website Desa dalam 10 Menit',
                'description' => 'Panduan step-by-step membuat website desa yang profesional dan informatif menggunakan template Begawi.id.',
                'image' => 'education/tutorial-1.jpg',
                'duration' => '10 menit',
                'views' => 2500,
                'is_hot' => true
            ],
            [
                'id' => 2,
                'type' => 'video',
                'title' => 'Setup Toko Online untuk UMKM',
                'description' => 'Video tutorial lengkap cara setup toko online, menambahkan produk, dan mengatur sistem pembayaran.',
                'image' => 'education/video-1.jpg',
                'duration' => '15 menit',
                'likes' => 1800
            ],
            [
                'id' => 3,
                'type' => 'case-study',
                'title' => 'Sukses UMKM Batik Go Digital',
                'description' => 'Kisah sukses UMKM batik yang berhasil meningkatkan penjualan 300% setelah menggunakan platform digital.',
                'image' => 'education/case-study-1.jpg',
                'location' => 'Yogyakarta',
                'metric' => '+300% Sales'
            ]
        ];
        
        $upcoming_webinars = [
            [
                'id' => 1,
                'title' => 'Strategi Digital Marketing untuk UMKM 2025',
                'description' => 'Pelajari strategi terbaru untuk memasarkan produk UMKM secara digital. Dari social media marketing hingga e-commerce optimization.',
                'date' => '25 Desember 2024',
                'time' => '19:00 WIB',
                'duration' => '90 menit',
                'speaker' => 'Andi Prasetyo',
                'participants' => 245,
                'available_seats' => 55,
                'color' => 'emerald'
            ],
            [
                'id' => 2,
                'title' => 'Membangun Website Desa yang Efektif',
                'description' => 'Workshop praktis untuk aparatur desa dalam membangun dan mengelola website desa yang informatif dan transparan.',
                'date' => '28 Desember 2024',
                'time' => '14:00 WIB',
                'duration' => '120 menit',
                'speaker' => 'Sari Indrawati',
                'participants' => 189,
                'available_seats' => 11,
                'color' => 'blue'
            ]
        ];
        
        return view('pages.education', compact('stats', 'learning_paths', 'featured_content', 'upcoming_webinars'));
    }
    
    public function category($category)
    {
        $validCategories = ['pemula', 'menengah', 'mahir'];
        
        if (!in_array($category, $validCategories)) {
            abort(404);
        }
        
        $categoryData = $this->getCategoryData($category);
        $tutorials = $this->getTutorialsByCategory($category);
        
        return view('pages.education-category', compact('category', 'categoryData', 'tutorials'));
    }
    
    public function article($slug)
    {
        $article = $this->getArticleBySlug($slug);
        
        if (!$article) {
            abort(404);
        }
        
        $related_articles = $this->getRelatedArticles($article['category'], $slug);
        
        return view('pages.education-article', compact('article', 'related_articles'));
    }
    
    private function getCategoryData($category)
    {
        $categories = [
            'pemula' => [
                'title' => 'Pemula',
                'subtitle' => 'Mulai dari Nol',
                'icon' => '🌱',
                'color' => 'emerald',
                'description' => 'Pelajari dasar-dasar membuat website dari awal. Cocok untuk pemula yang belum pernah membuat website sebelumnya.'
            ],
            'menengah' => [
                'title' => 'Menengah',
                'subtitle' => 'Tingkatkan Skill',
                'icon' => '⚡',
                'color' => 'blue',
                'description' => 'Tingkatkan kemampuan Anda dengan kustomisasi lanjutan, SEO, dan optimisasi website.'
            ],
            'mahir' => [
                'title' => 'Mahir',
                'subtitle' => 'Jadi Expert',
                'icon' => '🏆',
                'color' => 'purple',
                'description' => 'Pelajari teknik advanced untuk e-commerce, automation, dan scaling bisnis digital Anda.'
            ]
        ];
        
        return $categories[$category] ?? null;
    }
    
    private function getTutorialsByCategory($category)
    {
        // Mock data - dalam implementasi nyata, ambil dari database
        $allTutorials = [
            [
                'id' => 1,
                'title' => 'Pengenalan Website dan Platform Begawi.id',
                'slug' => 'pengenalan-website-dan-platform-begawi',
                'category' => 'pemula',
                'type' => 'tutorial',
                'duration' => '15 menit',
                'views' => 3200,
                'difficulty' => 'Pemula'
            ],
            [
                'id' => 2,
                'title' => 'Cara Memilih Template yang Tepat',
                'slug' => 'cara-memilih-template-yang-tepat',
                'category' => 'pemula',
                'type' => 'tutorial',
                'duration' => '20 menit',
                'views' => 2800,
                'difficulty' => 'Pemula'
            ],
            [
                'id' => 3,
                'title' => 'Kustomisasi Template Lanjutan',
                'slug' => 'kustomisasi-template-lanjutan',
                'category' => 'menengah',
                'type' => 'tutorial',
                'duration' => '30 menit',
                'views' => 1500,
                'difficulty' => 'Menengah'
            ],
            [
                'id' => 4,
                'title' => 'SEO untuk Website Desa',
                'slug' => 'seo-untuk-website-desa',
                'category' => 'menengah',
                'type' => 'tutorial',
                'duration' => '45 menit',
                'views' => 2100,
                'difficulty' => 'Menengah'
            ],
            [
                'id' => 5,
                'title' => 'Membangun E-commerce yang Scalable',
                'slug' => 'membangun-ecommerce-yang-scalable',
                'category' => 'mahir',
                'type' => 'tutorial',
                'duration' => '60 menit',
                'views' => 1200,
                'difficulty' => 'Mahir'
            ]
        ];
        
        return array_filter($allTutorials, function($tutorial) use ($category) {
            return $tutorial['category'] === $category;
        });
    }
    
    private function getArticleBySlug($slug)
    {
        $articles = [
            [
                'id' => 1,
                'title' => 'Cara Membuat Website Desa dalam 10 Menit',
                'slug' => 'cara-membuat-website-desa-dalam-10-menit',
                'category' => 'pemula',
                'type' => 'tutorial',
                'content' => 'Panduan lengkap membuat website desa...',
                'image' => 'education/tutorial-1.jpg',
                'author' => 'Andi Prasetyo',
                'published_at' => '2024-12-01',
                'duration' => '10 menit',
                'views' => 2500,
                'tags' => ['desa', 'website', 'pemula']
            ]
        ];
        
        return collect($articles)->firstWhere('slug', $slug);
    }
    
    private function getRelatedArticles($category, $excludeSlug, $limit = 3)
    {
        $tutorials = $this->getTutorialsByCategory($category);
        
        return collect($tutorials)
            ->filter(function($tutorial) use ($excludeSlug) {
                return $tutorial['slug'] !== $excludeSlug;
            })
            ->take($limit)
            ->values()
            ->all();
    }
}

