<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\VideoDocumentation;
use App\Models\InformationPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EducationController extends Controller
{
    public function index()
    {
        // Get stats from database
        $stats = [
            'tutorials' => Article::where('is_published', true)
                ->where('category', 'Tutorial')
                ->count(),
            'videos' => VideoDocumentation::where('is_published', true)
                ->where('type', 'youtube')
                ->count(),
            'webinars' => 0, // Can be added later if needed
            'is_free' => true
        ];
        
        // Learning paths (can be kept static or made dynamic later)
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
                'tutorial_count' => Article::where('is_published', true)
                    ->where('category', 'Tutorial')
                    ->count(),
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
                'tutorial_count' => Article::where('is_published', true)
                    ->where('category', 'Tips')
                    ->count(),
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
                'tutorial_count' => Article::where('is_published', true)
                    ->where('category', 'Update')
                    ->count(),
                'duration' => '6 jam'
            ]
        ];
        
        // Get featured content from database
        $featured_articles = Article::where('is_published', true)
            ->with('creator')
            ->orderBy('views', 'desc')
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'type' => $this->mapCategoryToType($article->category),
                    'title' => $article->title,
                    'description' => $article->excerpt ?? Str::limit(strip_tags($article->content), 150),
                    'image' => $article->featured_image ? Storage::url($article->featured_image) : asset('images/education/tutorial-1.jpg'),
                    'duration' => $this->estimateReadingTime($article->content),
                    'views' => $article->views,
                    'is_hot' => $article->views > 1000,
                    'slug' => $article->slug,
                    'category' => $article->category,
                    'published_at' => $article->published_at
                ];
            });
        
        // Get featured videos
        $featured_videos = VideoDocumentation::where('is_published', true)
            ->where('type', 'youtube')
            ->with('creator')
            ->orderBy('views', 'desc')
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($video) {
                return [
                    'id' => $video->id,
                    'type' => 'video',
                    'title' => $video->title,
                    'description' => $video->description ?? '',
                    'image' => $video->thumbnail ? Storage::url($video->thumbnail) : asset('images/education/video-1.jpg'),
                    'duration' => $video->formatted_duration ?? '15 menit',
                    'views' => $video->views,
                    'youtube_url' => $video->youtube_embed_url,
                    'slug' => $video->slug
                ];
            });
        
        // Combine featured content
        $featured_content = $featured_articles->concat($featured_videos)->shuffle()->take(6);
        
        // Get upcoming webinars (can be kept static or made dynamic later)
        $upcoming_webinars = [];
        
        return view('pages.education', compact('stats', 'learning_paths', 'featured_content', 'upcoming_webinars'));
    }
    
    public function category($category)
    {
        $validCategories = ['pemula', 'menengah', 'mahir', 'tutorial', 'update', 'tips'];
        
        if (!in_array($category, $validCategories)) {
            abort(404);
        }
        
        $categoryData = $this->getCategoryData($category);
        
        // Map category to article category
        $articleCategory = $this->mapTypeToCategory($category);
        
        if ($articleCategory) {
            $tutorials = Article::where('is_published', true)
                ->where('category', $articleCategory)
                ->with('creator')
                ->orderBy('views', 'desc')
                ->orderBy('published_at', 'desc')
                ->get()
                ->map(function ($article) {
                    return [
                        'id' => $article->id,
                        'title' => $article->title,
                        'slug' => $article->slug,
                        'category' => $article->category,
                        'type' => 'tutorial',
                        'duration' => $this->estimateReadingTime($article->content),
                        'views' => $article->views,
                        'difficulty' => $this->mapCategoryToDifficulty($article->category),
                        'excerpt' => $article->excerpt ?? Str::limit(strip_tags($article->content), 150),
                        'image' => $article->featured_image ? Storage::url($article->featured_image) : null,
                        'published_at' => $article->published_at
                    ];
                });
        } else {
            $tutorials = collect([]);
        }
        
        return view('pages.education-category', compact('category', 'categoryData', 'tutorials'));
    }

    public function tutorialDetail()
    {
        $tutorials = Article::where('is_published', true)
            ->where('category', 'Tutorial')
            ->with('creator')
            ->orderBy('views', 'desc')
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'category' => $article->category,
                    'duration' => $this->estimateReadingTime($article->content),
                    'views' => $article->views,
                    'excerpt' => $article->excerpt ?? Str::limit(strip_tags($article->content), 150),
                    'image' => $article->featured_image ? Storage::url($article->featured_image) : null,
                ];
            });
        
        return view('pages.education-tutorial-detail', compact('tutorials'));
    }

    public function inspiratifDetail()
    {
        $articles = Article::where('is_published', true)
            ->where('category', 'Update')
            ->with('creator')
            ->orderBy('views', 'desc')
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'category' => $article->category,
                    'duration' => $this->estimateReadingTime($article->content),
                    'views' => $article->views,
                    'excerpt' => $article->excerpt ?? Str::limit(strip_tags($article->content), 150),
                    'image' => $article->featured_image ? Storage::url($article->featured_image) : null,
                ];
            });
        
        return view('pages.education-inspiratif-detail', compact('articles'));
    }

    public function tipsDetail()
    {
        $tips = Article::where('is_published', true)
            ->where('category', 'Tips')
            ->with('creator')
            ->orderBy('views', 'desc')
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'category' => $article->category,
                    'duration' => $this->estimateReadingTime($article->content),
                    'views' => $article->views,
                    'excerpt' => $article->excerpt ?? Str::limit(strip_tags($article->content), 150),
                    'image' => $article->featured_image ? Storage::url($article->featured_image) : null,
                ];
            });
        
        return view('pages.education-tips-detail', compact('tips'));
    }
    
    public function article($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->with('creator')
            ->first();
        
        if (!$article) {
            abort(404);
        }
        
        // Increment views
        $article->increment('views');
        
        // Get related articles
        $related_articles = Article::where('is_published', true)
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->with('creator')
            ->orderBy('views', 'desc')
            ->take(3)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'category' => $item->category,
                    'type' => 'tutorial',
                    'duration' => $this->estimateReadingTime($item->content),
                    'views' => $item->views,
                    'excerpt' => $item->excerpt ?? Str::limit(strip_tags($item->content), 100),
                    'image' => $item->featured_image ? Storage::url($item->featured_image) : null
                ];
            });
        
        $articleData = [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'category' => $article->category,
            'type' => $this->mapCategoryToType($article->category),
            'content' => $article->content,
            'image' => $article->featured_image ? Storage::url($article->featured_image) : null,
            'author' => $article->creator->name ?? 'Admin',
            'published_at' => $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y'),
            'duration' => $this->estimateReadingTime($article->content),
            'views' => $article->views,
            'excerpt' => $article->excerpt
        ];
        
        return view('pages.education-article', compact('articleData', 'related_articles'));
    }
    
    public function video($slug)
    {
        $video = VideoDocumentation::where('slug', $slug)
            ->where('is_published', true)
            ->with('creator')
            ->first();
        
        if (!$video) {
            abort(404);
        }
        
        // Increment views
        $video->increment('views');
        
        // Get related videos
        $related_videos = VideoDocumentation::where('is_published', true)
            ->where('type', $video->type)
            ->where('id', '!=', $video->id)
            ->with('creator')
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();
        
        return view('pages.education-video', compact('video', 'related_videos'));
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
            ],
            'tutorial' => [
                'title' => 'Tutorial',
                'subtitle' => 'Panduan Lengkap',
                'icon' => '📝',
                'color' => 'emerald',
                'description' => 'Panduan step-by-step untuk membuat dan mengelola website dengan mudah.'
            ],
            'update' => [
                'title' => 'Update',
                'subtitle' => 'Berita Terbaru',
                'icon' => '📢',
                'color' => 'purple',
                'description' => 'Update terbaru tentang fitur, pembaruan platform, dan berita terkini.'
            ],
            'tips' => [
                'title' => 'Tips',
                'subtitle' => 'Tips & Trik',
                'icon' => '💡',
                'color' => 'orange',
                'description' => 'Tips dan trik praktis untuk meningkatkan performa website dan bisnis digital Anda.'
            ]
        ];
        
        return $categories[$category] ?? null;
    }
    
    private function mapCategoryToType($category)
    {
        $mapping = [
            'Tutorial' => 'tutorial',
            'Update' => 'update',
            'Tips' => 'tips'
        ];
        
        return $mapping[$category] ?? 'tutorial';
    }
    
    private function mapTypeToCategory($type)
    {
        $mapping = [
            'pemula' => 'Tutorial',
            'menengah' => 'Tips',
            'mahir' => 'Update',
            'tutorial' => 'Tutorial',
            'update' => 'Update',
            'tips' => 'Tips'
        ];
        
        return $mapping[$type] ?? null;
    }
    
    private function mapCategoryToDifficulty($category)
    {
        $mapping = [
            'Tutorial' => 'Pemula',
            'Tips' => 'Menengah',
            'Update' => 'Mahir'
        ];
        
        return $mapping[$category] ?? 'Pemula';
    }
    
    private function estimateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words per minute
        
        if ($minutes < 1) {
            return '1 menit';
        }
        
        return $minutes . ' menit';
    }
}
