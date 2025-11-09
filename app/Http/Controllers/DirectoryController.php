<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DirectoryController extends Controller
{
    public function index()
    {
        $stats = [
            'villages' => 1250,
            'umkm' => 3420,
            'communities' => 850,
            'provinces' => 34,
            'cities' => 514
        ];
        
        $featured_listings = [
            [
                'id' => 1,
                'name' => 'Desa Sukamaju',
                'type' => 'desa',
                'image' => 'directory/desa-sukamaju.jpg',
                'description' => 'Desa modern dengan transparansi APBDes dan pelayanan digital terdepan',
                'location' => 'Jawa Barat',
                'visitors' => 2500,
                'is_featured' => true
            ],
            [
                'id' => 2,
                'name' => 'Batik Nusantara',
                'type' => 'umkm',
                'image' => 'directory/batik-nusantara.jpg',
                'description' => 'Toko online batik tradisional dengan kualitas premium dan desain modern',
                'location' => 'Yogyakarta',
                'products' => 150,
                'is_featured' => true
            ],
            [
                'id' => 3,
                'name' => 'Karang Taruna Maju',
                'type' => 'komunitas',
                'image' => 'directory/karang-taruna.jpg',
                'description' => 'Organisasi pemuda desa dengan program pemberdayaan dan kegiatan sosial',
                'location' => 'Bali',
                'members' => 200,
                'is_featured' => true
            ]
        ];
        
        return view('pages.directory', compact('stats', 'featured_listings'));
    }
    
    public function type($type)
    {
        $validTypes = ['desa', 'umkm', 'komunitas'];
        
        if (!in_array($type, $validTypes)) {
            abort(404);
        }
        
        $typeLabels = [
            'desa' => 'Website Desa',
            'umkm' => 'UMKM Digital',
            'komunitas' => 'Komunitas'
        ];
        
        $listings = $this->getListingsByType($type);
        
        return view('pages.directory-type', compact('type', 'typeLabels', 'listings'));
    }
    
    public function show($id)
    {
        $listing = $this->getListingById($id);
        
        if (!$listing) {
            abort(404);
        }
        
        $related_listings = $this->getRelatedListings($listing['type'], $id);
        
        return view('pages.directory-detail', compact('listing', 'related_listings'));
    }
    
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all');
        $province = $request->get('province', 'all');
        
        $results = $this->searchListings($query, $type, $province);
        
        return response()->json([
            'success' => true,
            'results' => $results,
            'count' => count($results)
        ]);
    }
    
    private function getListingsByType($type)
    {
        $allListings = [
            // Desa listings
            [
                'id' => 1,
                'name' => 'Desa Sukamaju',
                'type' => 'desa',
                'image' => 'directory/desa-sukamaju.jpg',
                'description' => 'Desa modern dengan transparansi APBDes dan pelayanan digital terdepan',
                'location' => 'Jawa Barat',
                'province' => 'Jawa Barat',
                'visitors' => 2500,
                'website_url' => 'https://sukamaju.desa.id',
                'is_featured' => true
            ],
            [
                'id' => 4,
                'name' => 'Desa Makmur',
                'type' => 'desa',
                'image' => 'directory/desa-makmur.jpg',
                'description' => 'Desa dengan program pemberdayaan ekonomi dan digitalisasi layanan',
                'location' => 'Jawa Tengah',
                'province' => 'Jawa Tengah',
                'visitors' => 1800,
                'website_url' => 'https://makmur.desa.id',
                'is_featured' => false
            ],
            // UMKM listings
            [
                'id' => 2,
                'name' => 'Batik Nusantara',
                'type' => 'umkm',
                'image' => 'directory/batik-nusantara.jpg',
                'description' => 'Toko online batik tradisional dengan kualitas premium dan desain modern',
                'location' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
                'products' => 150,
                'website_url' => 'https://batiknusantara.com',
                'is_featured' => true
            ],
            [
                'id' => 5,
                'name' => 'Kerajinan Bambu Jaya',
                'type' => 'umkm',
                'image' => 'directory/kerajinan-bambu.jpg',
                'description' => 'Produk kerajinan bambu berkualitas tinggi dengan desain modern',
                'location' => 'Bali',
                'province' => 'Bali',
                'products' => 85,
                'website_url' => 'https://bambujaya.com',
                'is_featured' => false
            ],
            // Komunitas listings
            [
                'id' => 3,
                'name' => 'Karang Taruna Maju',
                'type' => 'komunitas',
                'image' => 'directory/karang-taruna.jpg',
                'description' => 'Organisasi pemuda desa dengan program pemberdayaan dan kegiatan sosial',
                'location' => 'Bali',
                'province' => 'Bali',
                'members' => 200,
                'website_url' => 'https://karangtarunamaju.org',
                'is_featured' => true
            ],
            [
                'id' => 6,
                'name' => 'Komunitas Petani Digital',
                'type' => 'komunitas',
                'image' => 'directory/petani-digital.jpg',
                'description' => 'Komunitas petani yang memanfaatkan teknologi untuk meningkatkan produktivitas',
                'location' => 'Sumatera Utara',
                'province' => 'Sumatera Utara',
                'members' => 150,
                'website_url' => 'https://petanidigital.id',
                'is_featured' => false
            ]
        ];
        
        return array_filter($allListings, function($listing) use ($type) {
            return $listing['type'] === $type;
        });
    }
    
    private function getListingById($id)
    {
        $allListings = [];
        
        // Get all listings from different types
        $desaListings = $this->getListingsByType('desa');
        $umkmListings = $this->getListingsByType('umkm');
        $komunitasListings = $this->getListingsByType('komunitas');
        
        $allListings = array_merge($desaListings, $umkmListings, $komunitasListings);
        
        return collect($allListings)->firstWhere('id', (int)$id);
    }
    
    private function getRelatedListings($type, $excludeId, $limit = 3)
    {
        $listings = $this->getListingsByType($type);
        
        return collect($listings)
            ->filter(function($listing) use ($excludeId) {
                return $listing['id'] != $excludeId;
            })
            ->take($limit)
            ->values()
            ->all();
    }
    
    private function searchListings($query, $type, $province)
    {
        $allListings = [];
        
        if ($type === 'all') {
            $desaListings = $this->getListingsByType('desa');
            $umkmListings = $this->getListingsByType('umkm');
            $komunitasListings = $this->getListingsByType('komunitas');
            $allListings = array_merge($desaListings, $umkmListings, $komunitasListings);
        } else {
            $allListings = $this->getListingsByType($type);
        }
        
        $results = array_filter($allListings, function($listing) use ($query, $province) {
            $matchesQuery = empty($query) || 
                stripos($listing['name'], $query) !== false || 
                stripos($listing['description'], $query) !== false ||
                stripos($listing['location'], $query) !== false;
            
            $matchesProvince = $province === 'all' || 
                (isset($listing['province']) && stripos($listing['province'], $province) !== false);
            
            return $matchesQuery && $matchesProvince;
        });
        
        return array_values($results);
    }
}

