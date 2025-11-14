<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\VillageNews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    protected ?Village $villageModel = null;

    public function index()
    {
        $newsItems = $this->newsQuery()
            ->latest('published_at')
            ->latest('created_at')
            ->get();

        $berita = $newsItems
            ->map(fn (VillageNews $news) => $this->mapNewsCard($news))
            ->values();

        $kategori = $newsItems->pluck('category')
            ->filter()
            ->unique()
            ->values()
            ->prepend('Semua')
            ->values()
            ->toArray();

        $berita_populer = $newsItems
            ->sortByDesc('views')
            ->take(3)
            ->map(fn (VillageNews $news) => $this->mapNewsCard($news))
            ->values();

        return view('pages.desa.berita.index', [
            'berita' => $berita,
            'kategori' => $kategori,
            'berita_populer' => $berita_populer,
        ]);
    }

    public function tambah()
    {
        $categories = $this->newsQuery()
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        return view('pages.desa.berita.tambah', [
            'kategori' => $categories,
        ]);
    }

    public function edit($id)
    {
        $news = $this->newsQuery()->findOrFail($id);
        $categories = $this->newsQuery()
            ->pluck('category')
            ->filter()
            ->unique()
            ->values();

        return view('pages.desa.berita.edit', [
            'berita' => $this->mapNewsDetail($news),
            'kategori' => $categories,
        ]);
    }

    public function arsip()
    {
        $news = $this->newsQuery()
            ->orderByDesc('published_at')
            ->get();

        $grouped = $news->groupBy(fn (VillageNews $item) => optional($item->published_at)->format('Y') ?? $item->created_at->format('Y'));

        $arsip_tahun = $grouped->map(function ($items) {
            return [
                'total' => $items->count(),
                'berita' => $items->map(fn (VillageNews $news) => $this->mapNewsCard($news))->values(),
            ];
        });

        $arsip_kategori = $news->groupBy('category')->map->count();

        return view('pages.desa.berita.arsip', [
            'arsip_tahun' => $arsip_tahun,
            'arsip_kategori' => $arsip_kategori,
        ]);
    }

    public function agenda()
    {
        $data = [
            'kegiatan' => $this->getKegiatanMendatang(),
            'kalender_events' => $this->getKalenderEvents(),
        ];

        return view('pages.desa.berita.agenda', $data);
    }

    public function detail($slug)
    {
        $article = $this->newsQuery()->where('slug', $slug)->first();

        if (! $article) {
            abort(404);
        }

        $related = $this->newsQuery()
            ->where('category', $article->category)
            ->whereKeyNot($article->getKey())
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn (VillageNews $news) => $this->mapNewsCard($news));

        $latest = $this->newsQuery()
            ->whereKeyNot($article->getKey())
            ->latest('published_at')
            ->take(4)
            ->get()
            ->map(fn (VillageNews $news) => $this->mapNewsCard($news));

        $contentBlocks = $this->buildContentBlocks($article);

        $projectStats = [
            ['label' => 'Total Pembaca', 'value' => number_format($article->views ?? 0), 'icon' => 'users'],
            ['label' => 'Status', 'value' => ucfirst($article->status), 'icon' => 'progress'],
            ['label' => 'Kategori', 'value' => $article->category ?? 'Umum', 'icon' => 'folder'],
        ];

        return view('pages.desa.berita.detail', [
            'berita' => $this->mapNewsDetail($article),
            'content' => $contentBlocks,
            'related' => $related,
            'latest' => $latest,
            'projectStats' => $projectStats,
        ]);
    }

    public function agendaDetail($id)
    {
        $agenda = collect($this->getKegiatanMendatang())->firstWhere('id', (int) $id);

        if (! $agenda) {
            abort(404);
        }

        $related = collect($this->getKegiatanMendatang())
            ->reject(fn ($item) => $item['id'] === $agenda['id'])
            ->take(4)
            ->values();

        $timeline = [
            ['time' => '08.00', 'title' => 'Registrasi Peserta', 'desc' => 'Penerimaan peserta, distribusi kit acara, dan briefing awal.'],
            ['time' => '09.00', 'title' => 'Sesi Pembukaan', 'desc' => 'Sambutan dari Kepala Desa serta penjelasan tujuan kegiatan.'],
            ['time' => '10.00', 'title' => 'Sesi Inti', 'desc' => 'Pelaksanaan kegiatan utama sesuai agenda.'],
            ['time' => '12.00', 'title' => 'Diskusi & Evaluasi', 'desc' => 'Forum diskusi, tanya jawab, dan perumusan tindak lanjut.'],
            ['time' => '13.00', 'title' => 'Penutupan', 'desc' => 'Kesimpulan, dokumentasi, dan pengumuman jadwal berikutnya.'],
        ];

        $checklist = [
            'Membawa undangan/reservasi (jika diperlukan).',
            'Menggunakan pakaian sesuai tema kegiatan.',
            'Mengisi daftar hadir dan mendapatkan kit acara.',
            'Mematuhi protokol kesehatan yang berlaku.',
        ];

        $organizers = [
            [
                'name' => 'Sekretariat Desa Sejahtera',
                'contact' => 'sekretariat@desasejahtera.id',
                'phone' => '0812-3456-7890',
            ],
            [
                'name' => 'Forum RT/RW',
                'contact' => 'forum.rtrw@desasejahtera.id',
                'phone' => '0813-2222-8899',
            ],
        ];

        return view('pages.desa.berita.agenda-detail', [
            'agenda' => $agenda,
            'related' => $related,
            'timeline' => $timeline,
            'checklist' => $checklist,
            'organizers' => $organizers,
        ]);
    }

    protected function newsQuery(): HasMany
    {
        return $this->village()->news()->where('status', VillageNews::STATUS_PUBLISHED);
    }

    protected function mapNewsCard(VillageNews $news): array
    {
        $publishedAt = $news->published_at ?? $news->created_at;

        return [
            'id' => $news->id,
            'judul' => $news->title,
            'slug' => $news->slug,
            'kategori' => $news->category ?? 'Umum',
            'ringkasan' => $news->summary ?? str($news->content)->limit(160),
            'konten' => $news->content,
            'thumbnail' => $this->mediaUrl($news->featured_image, 'https://via.placeholder.com/600x400'),
            'penulis' => $news->writer ?? 'Admin Desa',
            'tanggal' => $publishedAt->toDateString(),
            'views' => $news->views ?? 0,
        ];
    }

    protected function mapNewsDetail(VillageNews $news): array
    {
        $publishedAt = $news->published_at ?? $news->created_at;

        return [
            'judul' => $news->title,
            'ringkasan' => $news->summary,
            'konten' => $news->content,
            'kategori' => $news->category ?? 'Umum',
            'penulis' => $news->writer ?? 'Admin Desa',
            'tanggal' => $publishedAt->toDateString(),
            'thumbnail' => $this->mediaUrl($news->featured_image, 'https://via.placeholder.com/960x540'),
            'views' => $news->views ?? 0,
        ];
    }

    protected function buildContentBlocks(VillageNews $news): array
    {
        if ($news->content) {
            return collect(preg_split("/\r\n|\n|\r/", $news->content))
                ->filter()
                ->map(fn ($paragraph) => [
                    'type' => 'paragraph',
                    'text' => trim($paragraph),
                ])
                ->values()
                ->toArray();
        }

        return [
            [
                'type' => 'paragraph',
                'text' => 'Konten berita akan segera diperbarui oleh admin desa.',
            ],
        ];
    }

    private function getKegiatanMendatang(): array
    {
        return [
            [
                'id' => 1,
                'judul' => 'Rapat Koordinasi RT/RW',
                'tanggal' => now()->addDays(5)->toDateString(),
                'waktu' => '19:00',
                'tempat' => 'Balai Desa',
                'kategori' => 'Rapat',
                'deskripsi' => 'Rapat koordinasi bulanan dengan seluruh RT/RW se-desa',
            ],
            [
                'id' => 2,
                'judul' => 'Pelatihan Hidroponik untuk Ibu-Ibu',
                'tanggal' => now()->addDays(7)->toDateString(),
                'waktu' => '09:00',
                'tempat' => 'Ruang Serbaguna',
                'kategori' => 'Pelatihan',
                'deskripsi' => 'Pelatihan budidaya tanaman hidroponik untuk meningkatkan ekonomi keluarga',
            ],
            [
                'id' => 3,
                'judul' => 'Pasar Minggu Desa',
                'tanggal' => now()->addDays(10)->toDateString(),
                'waktu' => '06:00',
                'tempat' => 'Lapangan Desa',
                'kategori' => 'Acara',
                'deskripsi' => 'Pasar minggu dengan produk-produk UMKM lokal',
            ],
            [
                'id' => 4,
                'judul' => 'Posyandu Balita',
                'tanggal' => now()->addDays(15)->toDateString(),
                'waktu' => '08:00',
                'tempat' => 'Puskesmas Pembantu',
                'kategori' => 'Kesehatan',
                'deskripsi' => 'Pemeriksaan kesehatan rutin untuk balita',
            ],
        ];
    }

    private function getKalenderEvents(): array
    {
        return collect($this->getKegiatanMendatang())->map(function ($agenda) {
            return [
                'title' => $agenda['judul'],
                'start' => $agenda['tanggal'],
                'color' => match ($agenda['kategori']) {
                    'Rapat' => '#166534',
                    'Pelatihan' => '#3B82F6',
                    'Acara' => '#F59E0B',
                    'Kesehatan' => '#EC4899',
                    default => '#166534',
                },
                'category' => strtolower($agenda['kategori']),
            ];
        })->toArray();
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

    protected function mediaUrl(?string $path, string $fallback): string
    {
        if (blank($path)) {
            return filter_var($fallback, FILTER_VALIDATE_URL) ? $fallback : asset($fallback);
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        return filter_var($fallback, FILTER_VALIDATE_URL) ? $fallback : asset($fallback);
    }
}

