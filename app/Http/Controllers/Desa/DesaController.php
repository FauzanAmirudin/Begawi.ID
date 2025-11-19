<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\UmkmBusiness;
use App\Models\UmkmContentValidation;
use App\Models\UmkmProduct;
use App\Models\Village;
use App\Models\VillageGalleryItem;
use App\Models\VillageNews;
use App\Models\VillagePotential;
use App\Models\VillageProgram;
use App\Support\Concerns\HandlesMediaUrls;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DesaController extends Controller
{
    use HandlesMediaUrls;
    protected ?Village $villageModel = null;

    public function home()
    {
        $data = [
            'berita' => $this->getBeritaTerbaru(),
            'umkm_terbaru' => $this->getUmkmTerbaru(),
            'umkm_populer' => $this->getUmkmPopuler(),
            'galeri' => $this->getGaleriTerbaru(),
            'wisata' => $this->getWisataPopuler(),
            'kegiatan' => $this->getKegiatanDesa(),
        ];

        return view('pages.desa.home', $data);
    }

    public function about()
    {
        $data = [
            'identitas_desa' => $this->getIdentitasDesa(),
            'visi_misi' => $this->getVisiMisi(),
            'struktur_pemerintahan' => $this->getStrukturPemerintahan(),
            'sejarah_geografi' => $this->getSejarahGeografi(),
            'sosial_media' => $this->getSosialMedia(),
        ];

        return view('pages.desa.about', $data);
    }

    public function contact()
    {
        return view('pages.desa.contact');
    }

    public function directory()
    {
        return view('pages.desa.directory');
    }

    public function education()
    {
        return view('pages.desa.education');
    }

    public function privacy()
    {
        return view('pages.desa.privacy');
    }

    public function sitemap()
    {
        return view('pages.desa.sitemap');
    }

    public function terms()
    {
        return view('pages.desa.terms');
    }

    public function templates()
    {
        return view('pages.desa.templates');
    }

    private function getBeritaTerbaru(): array
    {
        return $this->village()->news()
            ->published()
            ->latest('published_at')
            ->latest('created_at')
            ->take(6)
            ->get()
            ->map(function (VillageNews $news) {
                return [
                    'id' => $news->id,
                    'judul' => $news->title,
                    'slug' => $news->slug,
                    'ringkasan' => $news->summary,
                    'thumbnail' => $this->mediaUrl($news->featured_image, 'https://via.placeholder.com/400x300'),
                    'tanggal' => optional($news->published_at)->toDateString() ?? $news->created_at->toDateString(),
                ];
            })
            ->toArray();
    }

    private function getUmkmTerbaru(): array
    {
        // Ambil produk terbaru dari tabel UmkmProduct
        // Ambil semua produk aktif dari UMKM aktif (tidak filter village_id agar lebih fleksibel)
        $products = UmkmProduct::query()
            ->where('is_active', true)
            ->with(['umkmBusiness', 'primaryImage', 'images'])
            ->whereHas('umkmBusiness', function ($query) {
                $query->where('status', 'active');
            })
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        $produk = [];

        foreach ($products as $product) {
            $umkm = $product->umkmBusiness;
            if (!$umkm) {
                continue;
            }

            // Ambil gambar utama
            $primaryImage = $product->primaryImage;
            $gambar = null;
            
            if ($primaryImage) {
                $gambar = $primaryImage->image_path;
            } elseif ($product->images->count() > 0) {
                $gambar = $product->images->first()->image_path;
            }
            
            // Handle image paths
            if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                $gambar = Storage::url($gambar);
            }
            
            if (empty($gambar)) {
                $gambar = 'https://via.placeholder.com/280x280?text=' . urlencode(substr($product->title, 0, 10));
            }

            $harga = $product->discount_price ?? $product->price;

            $produk[] = [
                'nama' => $product->title,
                'umkm' => $umkm->name,
                'harga' => 'Rp ' . number_format((float) $harga, 0, ',', '.'),
                'gambar' => $gambar,
                'slug' => $product->slug,
            ];
        }

        // Jika tidak ada produk dari UmkmProduct, coba ambil dari UmkmContentValidation sebagai fallback
        if (empty($produk)) {
            $validations = UmkmContentValidation::query()
                ->where('content_type', 'product')
                ->where('status', 'approved')
                ->with(['umkmBusiness'])
                ->whereHas('umkmBusiness', function ($query) {
                    $query->where('status', 'active');
                })
                ->orderByDesc('created_at')
                ->take(3)
                ->get();

            foreach ($validations as $validation) {
                $umkm = $validation->umkmBusiness;
                if (!$umkm) {
                    continue;
                }

                $contentData = $validation->content_data ?? [];
                $gambar = $contentData['image'] ?? $contentData['gambar'] ?? null;
                
                if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                    $gambar = Storage::url($gambar);
                }
                
                if (empty($gambar)) {
                    $gambar = 'https://via.placeholder.com/280x280?text=' . urlencode(substr($validation->title, 0, 10));
                }

                $harga = $contentData['price'] ?? $contentData['harga'] ?? 0;

                $produk[] = [
                    'nama' => $validation->title,
                    'umkm' => $umkm->name,
                    'harga' => 'Rp ' . number_format((float) $harga, 0, ',', '.'),
                    'gambar' => $gambar,
                    'slug' => Str::slug($validation->title) . '-' . $validation->id,
                ];
            }
        }

        return $produk;
    }

    private function getUmkmPopuler(): array
    {
        // Ambil produk populer dari tabel UmkmProduct berdasarkan rating dan jumlah terjual
        // Ambil semua produk aktif dari UMKM aktif (tidak filter village_id agar lebih fleksibel)
        $products = UmkmProduct::query()
            ->where('is_active', true)
            ->with(['umkmBusiness', 'primaryImage', 'images'])
            ->whereHas('umkmBusiness', function ($query) {
                $query->where('status', 'active');
            })
            ->get();
        
        // Jika tidak ada produk, coba ambil dari fallback
        if ($products->isEmpty()) {
            return $this->getUmkmPopulerFromValidation();
        }
        
        $productsWithScore = $products->map(function ($product) {
            $rating = $product->rating ?? 0;
            $terjual = $product->sold_count ?? 0;
            $isFeatured = $product->is_featured ? 100 : 0; // Bonus score untuk produk unggulan
            $isNew = $product->created_at->isAfter(now()->subDays(30)) ? 20 : 0; // Bonus untuk produk baru
            
            return [
                'product' => $product,
                'score' => ($rating * 10) + $terjual + $isFeatured + $isNew, // Score berdasarkan rating, penjualan, featured, dan baru
            ];
        })
        ->sortByDesc('score')
        ->take(4)
        ->pluck('product')
        ->values();
        
        // Jika setelah sorting masih kurang dari 4 produk, tambahkan produk terbaru
        if ($productsWithScore->count() < 4) {
            $remaining = 4 - $productsWithScore->count();
            $additionalProducts = $products->whereNotIn('id', $productsWithScore->pluck('id'))
                ->sortByDesc('created_at')
                ->take($remaining);
            $productsWithScore = $productsWithScore->merge($additionalProducts)->take(4);
        }

        $produk = [];

        foreach ($productsWithScore as $product) {
            /** @var UmkmProduct $product */
            $umkm = $product->umkmBusiness;
            if (!$umkm) {
                continue;
            }

            // Ambil gambar utama
            $primaryImage = $product->primaryImage;
            $gambar = null;
            
            if ($primaryImage) {
                $gambar = $primaryImage->image_path;
            } elseif ($product->images->count() > 0) {
                $gambar = $product->images->first()->image_path;
            }
            
            // Handle image paths
            if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                $gambar = Storage::url($gambar);
            }
            
            if (empty($gambar)) {
                $gambar = 'https://via.placeholder.com/280x280?text=' . urlencode(substr($product->title, 0, 10));
            }

            $harga = $product->discount_price ?? $product->price;
            $rating = $product->rating ?? 4.5;

            $produk[] = [
                'nama' => $product->title,
                'umkm' => $umkm->name,
                'harga' => 'Rp ' . number_format((float) $harga, 0, ',', '.'),
                'rating' => (float) $rating,
                'gambar' => $gambar,
                'slug' => $product->slug,
            ];
        }

        return $produk;
    }

    private function getUmkmPopulerFromValidation(): array
    {
        // Fallback: ambil dari UmkmContentValidation jika tidak ada produk di UmkmProduct
        $validationsData = UmkmContentValidation::query()
            ->where('content_type', 'product')
            ->where('status', 'approved')
            ->with(['umkmBusiness'])
            ->whereHas('umkmBusiness', function ($query) {
                $query->where('status', 'active');
            })
            ->get()
            ->map(function (UmkmContentValidation $validation) {
                $contentData = $validation->content_data ?? [];
                $rating = $contentData['rating'] ?? 0;
                $terjual = $contentData['sold'] ?? $contentData['terjual'] ?? 0;
                $unggulan = $contentData['featured'] ?? $contentData['unggulan'] ?? false;
                $isFeatured = $unggulan ? 100 : 0;
                
                return [
                    'validation' => $validation,
                    'score' => ($rating * 10) + $terjual + $isFeatured,
                ];
            })
            ->sortByDesc('score')
            ->take(4)
            ->values();

        $produk = [];

        foreach ($validationsData as $item) {
            /** @var UmkmContentValidation $validation */
            $validation = $item['validation'];
            $umkm = $validation->umkmBusiness;
            if (!$umkm) {
                continue;
            }

            $contentData = $validation->content_data ?? [];
            $gambar = $contentData['image'] ?? $contentData['gambar'] ?? null;
            
            if ($gambar && !filter_var($gambar, FILTER_VALIDATE_URL)) {
                $gambar = Storage::url($gambar);
            }
            
            if (empty($gambar)) {
                $gambar = 'https://via.placeholder.com/280x280?text=' . urlencode(substr($validation->title, 0, 10));
            }

            $harga = $contentData['price'] ?? $contentData['harga'] ?? 0;
            $rating = $contentData['rating'] ?? 4.5;

            $produk[] = [
                'nama' => $validation->title,
                'umkm' => $umkm->name,
                'harga' => 'Rp ' . number_format((float) $harga, 0, ',', '.'),
                'rating' => (float) $rating,
                'gambar' => $gambar,
                'slug' => Str::slug($validation->title) . '-' . $validation->id,
            ];
        }

        return $produk;
    }

    private function getGaleriTerbaru(): array
    {
        return $this->village()->galleryItems()
            ->where('is_published', true)
            ->orderByRaw('COALESCE(taken_at, created_at) DESC')
            ->take(12)
            ->get()
            ->map(function (VillageGalleryItem $item) {
                return [
                    'judul' => $item->title,
                    'gambar' => $this->mediaUrl($item->thumbnail_path ?? $item->media_path, 'https://via.placeholder.com/400x400'),
                ];
            })
            ->toArray();
    }

    private function getWisataPopuler(): array
    {
        return $this->village()->potentials()
            ->where('status', VillagePotential::STATUS_ACTIVE)
            ->latest('updated_at')
            ->take(3)
            ->get()
            ->map(function (VillagePotential $potential) {
                return [
                    'nama' => $potential->title,
                    'deskripsi' => $potential->summary ?? $potential->description,
                    'gambar' => $this->mediaUrl($potential->featured_image, 'https://via.placeholder.com/400x225'),
                ];
            })
            ->toArray();
    }

    private function getKegiatanDesa(): array
    {
        return $this->village()->programs()
            ->orderByDesc('start_date')
            ->take(5)
            ->get()
            ->map(function (VillageProgram $program) {
                return [
                    'judul' => $program->title,
                    'tanggal' => optional($program->start_date)->toDateString() ?? now()->toDateString(),
                    'waktu' => '09:00',
                    'tempat' => 'Balai Desa',
                    'jenis' => $program->status === VillageProgram::STATUS_ACTIVE ? 'acara' : 'rapat',
                ];
            })
            ->whenEmpty(function () {
                return collect([
                    [
                        'judul' => 'Rapat RT/RW',
                        'tanggal' => now()->addDays(5)->toDateString(),
                        'waktu' => '19:00',
                        'tempat' => 'Balai Desa',
                        'jenis' => 'rapat',
                    ],
                    [
                        'judul' => 'Pelatihan Komputer',
                        'tanggal' => now()->addDays(7)->toDateString(),
                        'waktu' => '09:00',
                        'tempat' => 'Ruang Serbaguna',
                        'jenis' => 'pelatihan',
                    ],
                    [
                        'judul' => 'Pasar Minggu Desa',
                        'tanggal' => now()->addDays(14)->toDateString(),
                        'waktu' => '06:00',
                        'tempat' => 'Lapangan Desa',
                        'jenis' => 'acara',
                    ],
                ]);
            })
            ->toArray();
    }

    private function getIdentitasDesa(): array
    {
        $village = $this->village();

        return [
            'nama' => $village->name,
            'kode_desa' => $village->code,
            'alamat' => $village->location,
            'kecamatan' => 'Kecamatan Makmur',
            'kabupaten' => 'Kabupaten Berkah',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '12345',
            'luas_wilayah' => $village->area,
            'jumlah_penduduk' => $village->population,
            'kepadatan' => $village->density,
            'logo' => $this->mediaUrl($village->logo_path, 'images/Logo-Begawi.png'),
        ];
    }

    private function getVisiMisi(): array
    {
        $village = $this->village();

        return [
            'visi' => $village->vision ?: 'Mewujudkan Desa Sejahtera yang Maju, Mandiri, dan Berkelanjutan Berbasis Kearifan Lokal',
            'visi_subtitle' => $village->vision_period ?: 'Visi 2024-2030',
            'misi' => $village->missions ?: [
                'Meningkatkan kualitas pelayanan publik yang transparan dan akuntabel',
                'Mengembangkan ekonomi kreatif dan UMKM berbasis potensi lokal',
                'Melestarikan budaya dan kearifan lokal sebagai identitas desa',
                'Membangun infrastruktur yang mendukung kesejahteraan masyarakat',
                'Menciptakan lingkungan yang bersih, sehat, dan berkelanjutan',
                'Meningkatkan kualitas pendidikan dan kesehatan masyarakat',
            ],
        ];
    }

    private function getStrukturPemerintahan(): array
    {
        $village = $this->village();
        $structures = $village->structures ?? [];

        return [
            'kepala_desa' => [
                'nama' => $village->head,
                'jabatan' => $village->head_title ?: 'Kepala Desa',
                'foto' => $this->mediaUrl($village->logo_path, 'https://via.placeholder.com/200x200'),
                'periode' => '2019-2025',
            ],
            'perangkat_desa' => $structures,
            'lembaga' => [
                [
                    'nama' => 'Badan Permusyawaratan Desa',
                    'ketua' => 'H. Suparman',
                    'anggota' => '9 orang',
                ],
                [
                    'nama' => 'Karang Taruna',
                    'ketua' => 'Andi Pratama',
                    'anggota' => '25 orang',
                ],
                [
                    'nama' => 'PKK Desa',
                    'ketua' => 'Hj. Fatimah',
                    'anggota' => '45 orang',
                ],
                [
                    'nama' => 'RT/RW',
                    'ketua' => '12 RT, 4 RW',
                    'anggota' => '16 pengurus',
                ],
            ],
        ];
    }

    private function getSejarahGeografi(): array
    {
        $history = collect($this->village()->history ?? [])
            ->mapWithKeys(fn ($item) => [$item['year'] ?? now()->year => $item['event'] ?? ''])
            ->toArray();

        return [
            'sejarah' => [
                'pembentukan' => array_key_first($history) ?? '1952',
                'asal_nama' => 'Nama "Sejahtera" berasal dari harapan para pendiri desa agar wilayah ini menjadi tempat yang memberikan kesejahteraan bagi seluruh warganya.',
                'tonggak_sejarah' => $history ?: [
                    '1952' => 'Pembentukan Desa Sejahtera',
                    '1975' => 'Pembangunan Balai Desa pertama',
                    '1990' => 'Program transmigrasi dan pengembangan pertanian',
                    '2010' => 'Pembangunan infrastruktur jalan utama',
                    '2020' => 'Digitalisasi pelayanan desa',
                ],
                'cerita_singkat' => 'Desa Sejahtera didirikan pada tahun 1952 oleh sekelompok keluarga yang bermigrasi dari daerah pegunungan untuk mencari kehidupan yang lebih baik.',
            ],
            'geografi' => [
                'ketinggian' => '450 mdpl',
                'topografi' => 'Dataran tinggi berbukit',
                'iklim' => 'Tropis',
                'batas_wilayah' => [
                    'utara' => 'Desa Makmur Jaya',
                    'selatan' => 'Desa Sumber Rezeki',
                    'timur' => 'Hutan Lindung Gunung Sari',
                    'barat' => 'Sungai Jernih',
                ],
                'potensi_alam' => [
                    'Pertanian padi dan palawija',
                    'Perkebunan kopi dan teh',
                    'Hutan bambu',
                    'Sumber mata air alami',
                    'Wisata alam air terjun',
                ],
            ],
            'foto_wilayah' => 'geografi-desa.jpg',
        ];
    }

    private function getSosialMedia(): array
    {
        return [
            'facebook' => 'https://facebook.com/desasejahtera',
            'instagram' => 'https://instagram.com/desasejahtera_official',
            'youtube' => 'https://youtube.com/@desasejahtera',
            'whatsapp' => 'https://wa.me/6281234567890',
            'email' => 'info@desasejahtera.id',
        ];
    }

    protected function village(): Village
    {
        if ($this->villageModel) {
            return $this->villageModel;
        }

        return $this->villageModel = Village::query()->firstOrCreate(
            ['slug' => 'desa-sejahtera'],
            ['name' => 'Desa Sejahtera']
        );
    }

}