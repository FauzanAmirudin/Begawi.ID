<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Website;
use App\Models\Village;
use App\Models\UmkmBusiness;
use Illuminate\Support\Facades\Storage;

class DirectoryController extends Controller
{
    public function index()
    {
        // Ambil data real dari database
        $villagesCount = Website::where('type', 'desa')
            ->where('status', 'active')
            ->count();

        $umkmCount = Website::where('type', 'umkm')
            ->where('status', 'active')
            ->count();

        $stats = [
            'villages' => $villagesCount ?: 1250,
            'umkm' => $umkmCount ?: 3420,
            'communities' => 850, // Bisa diambil dari database jika ada tabel communities
            'provinces' => 34,
            'cities' => 514
        ];

        // Ambil featured listings dari database
        $featuredVillages = Website::where('type', 'desa')
            ->where('status', 'active')
            ->with('village')
            ->take(3)
            ->get()
            ->map(function ($website) {
                $village = $website->village;
                return [
                    'id' => $website->id,
                    'name' => $village->name ?? $website->name,
                    'type' => 'desa',
                    'image' => $village && $village->logo_path
                        ? Storage::url($village->logo_path)
                        : 'https://images.unsplash.com/photo-1615367423057-4dab1be5b44b?w=800&h=600&fit=crop',
                    'description' => $village->description ?? 'Desa digital dengan layanan terpadu',
                    'location' => $village->location ?? 'Indonesia',
                    'visitors' => 2500, // Bisa diambil dari analytics
                    'is_featured' => true,
                    'url' => $website->custom_domain ?: route('desa.home')
                ];
            });

        $featuredUmkm = Website::where('type', 'umkm')
            ->where('status', 'active')
            ->with('umkmBusiness')
            ->take(3)
            ->get()
            ->map(function ($website) {
                $umkm = $website->umkmBusiness;
                $productCount = $umkm ? $umkm->products()->where('is_active', true)->count() : 0;
                return [
                    'id' => $website->id,
                    'name' => $umkm->name ?? $website->name,
                    'type' => 'umkm',
                    'image' => $umkm && $umkm->logo_path
                        ? Storage::url($umkm->logo_path)
                        : 'https://images.unsplash.com/photo-1615367423057-4dab1be5b44b?w=800&h=600&fit=crop',
                    'description' => $umkm->description ?? 'UMKM digital dengan produk berkualitas',
                    'location' => $umkm && $umkm->village ? $umkm->village->location : 'Indonesia',
                    'products' => $productCount,
                    'is_featured' => true,
                    'url' => $website->custom_domain ?: route('umkm.home')
                ];
            });

        // Gabungkan dan ambil 3 teratas
        $featured_listings = $featuredVillages->merge($featuredUmkm)->take(3)->values()->toArray();

        // Ambil semua desa untuk panel desa
        $allVillages = Website::where('type', 'desa')
            ->where('status', 'active')
            ->with('village')
            ->get()
            ->map(function ($website) {
                $village = $website->village;
                return [
                    'id' => $website->id,
                    'name' => $village->name ?? $website->name,
                    'type' => 'desa',
                    'image' => $village && $village->logo_path
                        ? Storage::url($village->logo_path)
                        : 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=800&h=600&fit=crop',
                    'description' => $village->description ?? 'Desa digital dengan layanan terpadu',
                    'location' => $village->location ?? 'Indonesia',
                    'visitors' => 2500,
                    'url' => $website->custom_domain ?: route('desa.home')
                ];
            });

        // Ambil semua UMKM untuk panel UMKM
        $allUmkm = Website::where('type', 'umkm')
            ->where('status', 'active')
            ->with(['umkmBusiness.village'])
            ->get()
            ->map(function ($website) {
                $umkm = $website->umkmBusiness;
                if (!$umkm) return null;

                $productCount = $umkm->products()->where('is_active', true)->count();
                $village = $umkm->village;

                return [
                    'id' => $website->id,
                    'name' => $umkm->name,
                    'type' => 'umkm',
                    'image' => $umkm->logo_path
                        ? Storage::url($umkm->logo_path)
                        : 'https://images.unsplash.com/photo-1615367423057-4dab1be5b44b?w=800&h=600&fit=crop',
                    'description' => $umkm->description ?? 'UMKM digital dengan produk berkualitas',
                    'location' => $village ? $village->location : 'Indonesia',
                    'products' => $productCount,
                    'category' => $umkm->category ?? 'Umum',
                    'url' => $website->custom_domain ?: route('umkm.home')
                ];
            })->filter();

        // Jika tidak ada data, gunakan dummy
        if (empty($featured_listings)) {
            $featured_listings = [
                [
                    'id' => 1,
                    'name' => 'Desa Sukamaju',
                    'type' => 'desa',
                    'image' => 'directory/desa-sukamaju.jpg',
                    'description' => 'Desa modern dengan transparansi APBDes dan pelayanan digital terdepan',
                    'location' => 'Jawa Barat',
                    'visitors' => 2500,
                    'is_featured' => true,
                    'url' => route('desa.home')
                ],
                [
                    'id' => 2,
                    'name' => 'Batik Nusantara',
                    'type' => 'umkm',
                    'image' => 'directory/batik-nusantara.jpg',
                    'description' => 'Toko online batik tradisional dengan kualitas premium dan desain modern',
                    'location' => 'Yogyakarta',
                    'products' => 150,
                    'is_featured' => true,
                    'url' => route('umkm.home')
                ],
                [
                    'id' => 3,
                    'name' => 'Karang Taruna Maju',
                    'type' => 'komunitas',
                    'image' => 'directory/karang-taruna.jpg',
                    'description' => 'Organisasi pemuda desa dengan program pemberdayaan dan kegiatan sosial',
                    'location' => 'Bali',
                    'members' => 200,
                    'is_featured' => true,
                    'url' => '#'
                ]
            ];
        }

        return view('pages.directory', compact('stats', 'featured_listings', 'allVillages', 'allUmkm'));
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
        $listings = [];

        if ($type === 'desa') {
            $websites = Website::where('type', 'desa')
                ->where('status', 'active')
                ->with('village')
                ->get();

            foreach ($websites as $website) {
                $village = $website->village;
                $listings[] = [
                    'id' => $website->id,
                    'name' => $village->name ?? $website->name,
                    'type' => 'desa',
                    'image' => $village && $village->logo_path
                        ? Storage::url($village->logo_path)
                        : 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=800&h=600&fit=crop',
                    'description' => $village->description ?? 'Desa digital dengan layanan terpadu',
                    'location' => $village->location ?? 'Indonesia',
                    'province' => $this->extractProvince($village->location ?? ''),
                    'visitors' => 2500, // Bisa diambil dari analytics
                    'website_url' => $website->custom_domain ?: ('http://' . $website->url),
                    'is_featured' => false
                ];
            }
        } elseif ($type === 'umkm') {
            $websites = Website::where('type', 'umkm')
                ->where('status', 'active')
                ->with(['umkmBusiness.village'])
                ->get();

            foreach ($websites as $website) {
                $umkm = $website->umkmBusiness;
                if (!$umkm) continue;

                $productCount = $umkm->products()->where('is_active', true)->count();
                $village = $umkm->village;

                $listings[] = [
                    'id' => $website->id,
                    'name' => $umkm->name,
                    'type' => 'umkm',
                    'image' => $umkm->logo_path
                        ? Storage::url($umkm->logo_path)
                        : 'https://images.unsplash.com/photo-1615367423057-4dab1be5b44b?w=800&h=600&fit=crop',
                    'description' => $umkm->description ?? 'UMKM digital dengan produk berkualitas',
                    'location' => $village ? $village->location : 'Indonesia',
                    'province' => $this->extractProvince($village ? $village->location : ''),
                    'products' => $productCount,
                    'website_url' => $website->custom_domain ?: ('http://' . $website->url),
                    'is_featured' => false
                ];
            }
        } elseif ($type === 'komunitas') {
            // Komunitas masih menggunakan dummy data karena belum ada tabel khusus
            $listings = [
                [
                    'id' => 3,
                    'name' => 'Karang Taruna Maju',
                    'type' => 'komunitas',
                    'image' => 'directory/karang-taruna.jpg',
                    'description' => 'Organisasi pemuda desa dengan program pemberdayaan dan kegiatan sosial',
                    'location' => 'Bali',
                    'province' => 'Bali',
                    'members' => 200,
                    'website_url' => '#',
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
                    'website_url' => '#',
                    'is_featured' => false
                ]
            ];
        }

        // Jika tidak ada data, return empty array
        return $listings;
    }

    private function extractProvince($location)
    {
        // Extract province from location string
        $provinces = [
            'Jawa Barat',
            'Jawa Tengah',
            'Jawa Timur',
            'DI Yogyakarta',
            'Bali',
            'Sumatera Utara',
            'Sumatera Selatan',
            'Lampung',
            'Banten',
            'Jakarta',
            'Sulawesi Selatan',
            'Kalimantan Barat'
        ];

        foreach ($provinces as $province) {
            if (stripos($location, $province) !== false) {
                return $province;
            }
        }

        return 'Indonesia';
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
            ->filter(function ($listing) use ($excludeId) {
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

        $results = array_filter($allListings, function ($listing) use ($query, $province) {
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
