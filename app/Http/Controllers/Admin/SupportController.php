<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $recentTickets = $this->filteredTickets()->take(4);

        return view('admin.support.index', [
            'stats' => $this->getStats(),
            'tickets' => $recentTickets->all(),
            'faqs' => $this->getFaqs(),
            'activities' => $this->getActivities(),
            'resources' => $this->getResources(),
        ]);
    }

    public function tickets(Request $request)
    {
        $inputs = $this->sanitizeInputs($request->only(['status', 'priority', 'category', 'search']));
        $filters = $this->normalizeFilters($inputs);

        $filteredTickets = $this->filteredTickets($filters);

        return view('admin.support.tickets', [
            'stats' => $this->getStats($filteredTickets),
            'tickets' => $filteredTickets->all(),
            'filterOptions' => $this->getTicketFilters(),
            'formState' => $inputs,
            'agents' => $this->getSupportAgents(),
            'resultCount' => $filteredTickets->count(),
        ]);
    }

    public function documentation(Request $request)
    {
        $filters = $this->sanitizeInputs($request->only(['search', 'category']));

        $articlesQuery = Article::query()->where('is_published', true);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $articlesQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        if (!empty($filters['category'])) {
            $articlesQuery->where('category', $filters['category']);
        }

        $articles = $articlesQuery
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(8)
            ->withQueryString();

        $categories = collect(Article::getCategories())->map(function ($label) use ($filters) {
            $count = Article::where('is_published', true)
                ->where('category', $label)
                ->count();

            return [
                'name' => $label,
                'slug' => Str::slug($label),
                'label' => $label,
                'description' => $this->categoryDescription($label),
                'count' => $count,
                'active' => ($filters['category'] ?? '') === $label,
            ];
        });

        $featuredArticles = Article::where('is_published', true)
            ->orderByDesc('views')
            ->orderByDesc('published_at')
            ->take(3)
            ->get()
            ->map(function (Article $article) {
                return [
                    'title' => $article->title,
                    'category' => $article->category,
                    'slug' => $article->slug,
                    'reading_time' => $this->estimateReadingTime($article->content),
                    'updated_at' => optional($article->published_at)->translatedFormat('d F Y') ?? $article->created_at->translatedFormat('d F Y'),
                    'views' => $article->views ?? 0,
                ];
            });

        $releaseNotes = Article::where('is_published', true)
            ->where('category', 'Update')
            ->orderByDesc('published_at')
            ->take(3)
            ->get()
            ->map(function (Article $article) {
                return [
                    'title' => $article->title,
                    'version' => 'v' . $article->published_at?->format('y.m.d') ?? $article->created_at->format('y.m.d'),
                    'date' => optional($article->published_at)->translatedFormat('d F Y') ?? $article->created_at->translatedFormat('d F Y'),
                    'highlights' => $this->extractHighlights($article),
                    'slug' => $article->slug,
                ];
            });

        return view('admin.support.documentation', [
            'filters' => $filters,
            'categories' => $categories,
            'articles' => $articles,
            'featuredArticles' => $featuredArticles,
            'releaseNotes' => $releaseNotes,
        ]);
    }

    public function documentationShow(string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        if (!$article->is_published && !(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_SUPER_ADMIN)) {
            abort(404);
        }

        $article->increment('views');

        $relatedArticles = Article::where('id', '!=', $article->id)
            ->where('is_published', true)
            ->where('category', $article->category)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('admin.support.documentation-show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }

    public function contact(Request $request)
    {
        $prefill = [];

        if ($request->filled('ticket')) {
            $ticketPrefill = $this->ticketCollection()->firstWhere('id', $request->input('ticket'));
            if ($ticketPrefill) {
                $prefill = [
                    'ticket_id' => $ticketPrefill['id'],
                    'tenant' => $ticketPrefill['tenant'],
                    'topic' => $this->mapCategoryToTopic($ticketPrefill['category_slug']),
                    'priority' => $ticketPrefill['priority'],
                    'subject' => $ticketPrefill['subject'],
                    'message' => "Menindaklanjuti tiket {$ticketPrefill['id']} - {$ticketPrefill['subject']}.\n\nCatatan tambahan:\n",
                ];
            }
        }

        return view('admin.support.contact', [
            'channels' => $this->getContactChannels(),
            'sla' => $this->getSlaOverview(),
            'topics' => $this->getContactTopics(),
            'prefill' => $prefill,
        ]);
    }

    public function show(string $ticketId)
    {
        $ticket = $this->findTicketOrFail($ticketId);

        return view('admin.support.show', [
            'ticket' => $ticket,
            'relatedTickets' => $this->relatedTickets($ticket)->all(),
        ]);
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'tenant' => ['required', 'string', 'max:120'],
            'topic' => ['required', 'string'],
            'priority' => ['required', 'string'],
            'message' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'max:5120'],
            'ticket_id' => ['nullable', 'string', 'max:120'],
        ]);

        // TODO: Implement email integration or ticket dispatch logic.

        return back()->with('status', 'Permintaan dukungan telah dikirim. Tim teknis akan segera menghubungi Anda.');
    }

    protected function sanitizeInputs(array $inputs): array
    {
        return collect($inputs)->map(function ($value) {
            if (is_string($value)) {
                return trim($value);
            }

            return $value;
        })->toArray();
    }

    protected function normalizeFilters(array $inputs): array
    {
        return collect($inputs)
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->all();
    }

    protected function getStats(?Collection $tickets = null): array
    {
        if ($tickets) {
            return $this->calculateTicketStats($tickets);
        }

        return [
            'open' => 18,
            'in_progress' => 9,
            'resolved' => 42,
            'avg_response_time' => '1 jam 24 menit',
            'satisfaction' => 94,
        ];
    }

    protected function calculateTicketStats(Collection $tickets): array
    {
        return [
            'open' => $tickets->where('status', 'open')->count(),
            'in_progress' => $tickets->where('status', 'in_progress')->count(),
            'resolved' => $tickets->where('status', 'resolved')->count(),
            'avg_response_time' => '1 jam 24 menit',
            'satisfaction' => 94,
        ];
    }

    protected function filteredTickets(array $filters = []): Collection
    {
        return $this->applyTicketFilters($this->ticketCollection(), $filters);
    }

    protected function ticketCollection(): Collection
    {
        return collect($this->baseTicketData());
    }

    protected function applyTicketFilters(Collection $tickets, array $filters): Collection
    {
        return $tickets
            ->filter(function (array $ticket) use ($filters) {
                if (isset($filters['status']) && $ticket['status'] !== $filters['status']) {
                    return false;
                }

                if (isset($filters['priority']) && $ticket['priority'] !== $filters['priority']) {
                    return false;
                }

                if (isset($filters['category'])) {
                    $categorySlug = $ticket['category_slug'] ?? Str::slug($ticket['category']);
                    if ($categorySlug !== $filters['category']) {
                        return false;
                    }
                }

                if (isset($filters['search'])) {
                    $search = Str::lower($filters['search']);
                    $haystack = Str::lower(
                        implode(' ', [
                            $ticket['id'],
                            $ticket['subject'],
                            $ticket['tenant'],
                            $ticket['category'],
                            $ticket['requester']['name'] ?? '',
                            $ticket['assignee']['name'] ?? '',
                        ])
                    );

                    if (!Str::contains($haystack, $search)) {
                        return false;
                    }
                }

                return true;
            })
            ->sortByDesc('updated_at_iso')
            ->values();
    }

    protected function findTicketOrFail(string $ticketId): array
    {
        $ticket = $this->ticketCollection()->firstWhere('id', $ticketId);

        if (!$ticket) {
            abort(404);
        }

        return $ticket;
    }

    protected function relatedTickets(array $ticket): Collection
    {
        return $this->ticketCollection()
            ->where('id', '!=', $ticket['id'])
            ->filter(function (array $candidate) use ($ticket) {
                return $candidate['category_slug'] === $ticket['category_slug']
                    || $candidate['priority'] === $ticket['priority'];
            })
            ->sortByDesc('updated_at_iso')
            ->take(3)
            ->values();
    }

    protected function getTicketFilters(): array
    {
        $categories = $this->ticketCollection()
            ->pluck('category', 'category_slug')
            ->unique();

        return [
            'status' => [
                '' => 'Semua Status',
                'open' => 'Open',
                'in_progress' => 'In Progress',
                'resolved' => 'Resolved',
            ],
            'priority' => [
                '' => 'Semua Prioritas',
                'high' => 'High',
                'medium' => 'Medium',
                'low' => 'Low',
            ],
            'category' => ['' => 'Semua Kategori'] + $categories->toArray(),
        ];
    }

    protected function getSupportAgents(): array
    {
        return [
            [
                'name' => 'Dewi Lestari',
                'speciality' => 'Integrasi & Infrastruktur',
                'online' => true,
                'tickets' => 6,
            ],
            [
                'name' => 'Rangga Saputra',
                'speciality' => 'Pelatihan & Edukasi',
                'online' => true,
                'tickets' => 4,
            ],
            [
                'name' => 'Yasmin Pratiwi',
                'speciality' => 'Keamanan & Akses',
                'online' => false,
                'tickets' => 3,
            ],
        ];
    }

    protected function getFaqs(): array
    {
        return [
            [
                'question' => 'Bagaimana cara melacak status tiket pengaduan?',
                'answer' => 'Masuk ke menu Support & Pengaduan > Tiket Pengaduan, gunakan filter tenant untuk melihat tiket Anda, kemudian klik detail tiket untuk melihat timeline penanganan.',
                'tags' => ['Tiket', 'Monitoring'],
            ],
            [
                'question' => 'Apa yang harus disiapkan sebelum integrasi domain?',
                'answer' => 'Pastikan domain Anda telah aktif, siapkan akses DNS, dan catat catatan MX serta CNAME yang sudah digunakan agar tidak terjadi konflik konfigurasi.',
                'tags' => ['Domain', 'Integrasi'],
            ],
            [
                'question' => 'Apakah ada batasan ukuran file lampiran tiket?',
                'answer' => 'Setiap lampiran dibatasi maksimal 5 MB dan mendukung format PDF, JPG, PNG, serta ZIP untuk file log.',
                'tags' => ['Lampiran', 'Kebijakan'],
            ],
        ];
    }

    protected function getActivities(): array
    {
        return [
            [
                'time' => '10:15',
                'description' => 'Tim teknis menyelesaikan tiket TCK-2025-0115 dan mengirim laporan ke tenant.',
                'status' => 'resolved',
            ],
            [
                'time' => '09:48',
                'description' => 'Verifikasi ulang kredensial SFTP untuk UMKM Kopi Wangi.',
                'status' => 'in_progress',
            ],
            [
                'time' => '09:12',
                'description' => 'Tiket baru dari Desa Sukamaju terkait aktivasi domain.',
                'status' => 'open',
            ],
            [
                'time' => '08:45',
                'description' => 'Update dokumentasi teknis untuk fitur personalisasi tema.',
                'status' => 'resolved',
            ],
        ];
    }

    protected function getResources(): array
    {
        return [
            [
                'title' => 'Panduan Integrasi Domain Mandiri',
                'type' => 'PDF',
                'size' => '1.2 MB',
                'updated_at' => 'Oktober 2025',
            ],
            [
                'title' => 'Checklist Migrasi Data Tenant',
                'type' => 'Spreadsheet',
                'size' => '640 KB',
                'updated_at' => 'September 2025',
            ],
            [
                'title' => 'Video Tutorial: Audit Log',
                'type' => 'Video',
                'size' => '11 menit',
                'updated_at' => 'November 2025',
            ],
        ];
    }

    protected function getFaqCategories(): array
    {
        return [
            [
                'name' => 'Mulai Cepat',
                'description' => 'Langkah awal onboarding tenant dan aktivasi layanan.',
                'articles' => 8,
                'icon' => 'rocket',
            ],
            [
                'name' => 'Integrasi Teknis',
                'description' => 'Panduan teknis untuk DNS, domain, dan API internal.',
                'articles' => 12,
                'icon' => 'cog',
            ],
            [
                'name' => 'Manajemen Konten',
                'description' => 'Tips pengelolaan halaman, artikel, dan media.',
                'articles' => 10,
                'icon' => 'document',
            ],
            [
                'name' => 'Pelaporan & Analitik',
                'description' => 'Cara membaca statistik dan audit aktivitas.',
                'articles' => 6,
                'icon' => 'chart',
            ],
        ];
    }

    protected function getFeaturedArticles(): array
    {
        return Article::where('is_published', true)
            ->orderByDesc('views')
            ->orderByDesc('published_at')
            ->take(3)
            ->get()
            ->map(function (Article $article) {
                return [
                    'title' => $article->title,
                    'duration' => $this->estimateReadingTime($article->content),
                    'updated_at' => optional($article->published_at)->translatedFormat('d F Y') ?? $article->created_at->translatedFormat('d F Y'),
                    'slug' => $article->slug,
                ];
            })
            ->toArray();
    }

    protected function getReleaseNotes(): array
    {
        return Article::where('is_published', true)
            ->where('category', 'Update')
            ->orderByDesc('published_at')
            ->take(3)
            ->get()
            ->map(function (Article $article) {
                return [
                    'version' => 'v' . $article->published_at?->format('y.m.d') ?? $article->created_at->format('y.m.d'),
                    'date' => optional($article->published_at)->translatedFormat('d F Y') ?? $article->created_at->translatedFormat('d F Y'),
                    'highlights' => $this->extractHighlights($article),
                ];
            })
            ->toArray();
    }

    protected function getContactChannels(): array
    {
        return [
            [
                'name' => 'Email Dukungan',
                'value' => 'support@begawi.id',
                'availability' => '24/7',
                'icon' => 'mail',
            ],
            [
                'name' => 'Hotline Teknis',
                'value' => '0800-123-000',
                'availability' => 'Senin - Jumat, 08.00 - 20.00 WIB',
                'icon' => 'phone',
            ],
            [
                'name' => 'Grup Telegram',
                'value' => '@begawi-support',
                'availability' => 'Respon rata-rata 30 menit',
                'icon' => 'chat',
            ],
        ];
    }

    protected function getSlaOverview(): array
    {
        return [
            'high' => 'Respon awal maksimal 1 jam, penyelesaian 4 jam.',
            'medium' => 'Respon awal maksimal 2 jam, penyelesaian 1 hari kerja.',
            'low' => 'Respon awal maksimal 4 jam, penyelesaian 2 hari kerja.',
        ];
    }

    protected function getContactTopics(): array
    {
        return [
            'Integrasi Domain',
            'Masalah Akses Admin',
            'Permintaan Pelatihan',
            'Bug & Gangguan Sistem',
            'Permintaan Fitur Baru',
        ];
    }

    protected function categoryDescription(string $category): string
    {
        return match ($category) {
            'Tutorial' => 'Langkah demi langkah untuk fitur dan konfigurasi teknis.',
            'Update' => 'Informasi rilis fitur terbaru dan perubahan sistem.',
            'Tips' => 'Rekomendasi praktik terbaik untuk operasional tenant.',
            default => 'Materi referensi untuk pengelolaan tenant.',
        };
    }

    protected function estimateReadingTime(?string $content): string
    {
        if (!$content) {
            return '3 menit';
        }

        $wordCount = str_word_count(strip_tags($content));
        $minutes = max(1, (int) ceil($wordCount / 200));

        return "{$minutes} menit";
    }

    protected function extractHighlights(Article $article): array
    {
        $content = strip_tags($article->content ?? '');
        $sentences = preg_split('/(?<=[.?!])\s+/', $content) ?: [];

        return collect($sentences)
            ->filter()
            ->take(3)
            ->map(function ($sentence) {
                return trim($sentence);
            })
            ->filter()
            ->values()
            ->toArray();
    }

    protected function mapCategoryToTopic(string $categorySlug): string
    {
        return match ($categorySlug) {
            'integrasi' => 'Integrasi Domain',
            'akses-akun' => 'Masalah Akses Admin',
            'pelatihan' => 'Permintaan Pelatihan',
            'data-analitik' => 'Bug & Gangguan Sistem',
            default => 'Bug & Gangguan Sistem',
        };
    }

    protected function baseTicketData(): array
    {
        return [
            [
                'id' => 'TCK-2025-0142',
                'subject' => 'Integrasi domain desa belum aktif',
                'tenant' => 'Desa Sukamaju',
                'priority' => 'high',
                'status' => 'open',
                'category' => 'Integrasi',
                'category_slug' => 'integrasi',
                'channel' => 'Email',
                'created_at' => '13 Nov 2025 09:15',
                'created_at_iso' => '2025-11-13T09:15:00+07:00',
                'updated_at' => '13 Nov 2025 10:02',
                'updated_at_iso' => '2025-11-13T10:02:00+07:00',
                'sla_target' => '4 jam',
                'impact' => 'Domain desa belum dapat diakses karena konfigurasi DNS baru belum tersinkron.',
                'description' => 'Tenant melaporkan bahwa setelah melakukan pembelian domain melalui penyedia lokal, alamat desa belum dapat diarahkan ke server Begawi. Pengaturan DNS masih mengarah ke hosting lama sehingga halaman menampilkan error DNS_PROBE_FINISHED_NXDOMAIN.',
                'requester' => [
                    'name' => 'Rudi Hartono',
                    'role' => 'Admin Desa',
                    'email' => 'admin@desasukamaju.id',
                    'phone' => '+62 812-1234-5678',
                ],
                'assignee' => [
                    'name' => 'Dewi Lestari',
                    'role' => 'Engineer Integrasi',
                ],
                'history' => [
                    [
                        'time' => '13 Nov 2025 09:15',
                        'status' => 'Open',
                        'actor' => 'Sistem',
                        'note' => 'Tiket dibuat otomatis dari email masuk ke support@begawi.id.',
                    ],
                    [
                        'time' => '13 Nov 2025 09:42',
                        'status' => 'In Progress',
                        'actor' => 'Dewi Lestari',
                        'note' => 'Validasi kredensial penyedia domain dan meminta akses panel DNS.',
                    ],
                ],
                'notes' => [
                    [
                        'author' => 'Dewi Lestari',
                        'role' => 'Engineer Integrasi',
                        'time' => '13 Nov 2025 09:55',
                        'visibility' => 'internal',
                        'message' => 'Update record A serta CNAME sudah dilakukan. Menunggu propagasi maksimal 2 jam. Tenant telah diinformasikan melalui email otomatis.',
                    ],
                ],
                'attachments' => [
                    ['name' => 'dns-record-before.png', 'size' => '420 KB'],
                    ['name' => 'surat-permohonan.pdf', 'size' => '310 KB'],
                ],
                'tags' => ['Integrasi', 'Domain', 'Tenant Desa'],
                'watchers' => [
                    ['name' => 'Yasmin Pratiwi', 'role' => 'QA Support'],
                ],
            ],
            [
                'id' => 'TCK-2025-0138',
                'subject' => 'Reset password akun admin UMKM',
                'tenant' => 'UMKM Kopi Wangi',
                'priority' => 'medium',
                'status' => 'in_progress',
                'category' => 'Akses Akun',
                'category_slug' => 'akses-akun',
                'channel' => 'Portal Support',
                'created_at' => '12 Nov 2025 16:40',
                'created_at_iso' => '2025-11-12T16:40:00+07:00',
                'updated_at' => '13 Nov 2025 08:12',
                'updated_at_iso' => '2025-11-13T08:12:00+07:00',
                'sla_target' => '8 jam',
                'impact' => 'Admin UMKM tidak dapat masuk ke panel untuk memproses pesanan baru.',
                'description' => 'Pengaduan menyebutkan akun admin utama terkunci setelah percobaan login berulang gagal. Tenant memerlukan reset segera karena ada pesanan yang menunggu konfirmasi.',
                'requester' => [
                    'name' => 'Meliana Sari',
                    'role' => 'Admin UMKM',
                    'email' => 'meliana@kopiwangi.id',
                    'phone' => '+62 813-7788-9900',
                ],
                'assignee' => [
                    'name' => 'Rangga Saputra',
                    'role' => 'Engineer Onboarding',
                ],
                'history' => [
                    [
                        'time' => '12 Nov 2025 16:40',
                        'status' => 'Open',
                        'actor' => 'Portal Support',
                        'note' => 'Tiket dibuat melalui form pengaduan tenant.',
                    ],
                    [
                        'time' => '12 Nov 2025 17:05',
                        'status' => 'In Progress',
                        'actor' => 'Rangga Saputra',
                        'note' => 'Mengirim tautan reset password lewat email tenant dan meminta konfirmasi.',
                    ],
                    [
                        'time' => '13 Nov 2025 08:12',
                        'status' => 'In Progress',
                        'actor' => 'Meliana Sari',
                        'note' => 'Tenant menginformasikan tautan sudah diterima namun masih gagal karena sesi login lama.',
                    ],
                ],
                'notes' => [
                    [
                        'author' => 'Rangga Saputra',
                        'role' => 'Engineer Onboarding',
                        'time' => '13 Nov 2025 08:20',
                        'visibility' => 'internal',
                        'message' => 'Menonaktifkan sesi lama melalui admin panel. Menunggu konfirmasi akhir tenant.',
                    ],
                ],
                'attachments' => [
                    ['name' => 'log-autentikasi.csv', 'size' => '95 KB'],
                ],
                'tags' => ['Akses Akun', 'UMKM', 'Keamanan'],
                'watchers' => [
                    ['name' => 'Bagus Wicaksono', 'role' => 'Lead Support'],
                ],
            ],
            [
                'id' => 'TCK-2025-0129',
                'subject' => 'Data statistik tidak sinkron',
                'tenant' => 'Desa Mekarjaya',
                'priority' => 'high',
                'status' => 'in_progress',
                'category' => 'Data & Analitik',
                'category_slug' => 'data-analitik',
                'channel' => 'Email',
                'created_at' => '11 Nov 2025 11:05',
                'created_at_iso' => '2025-11-11T11:05:00+07:00',
                'updated_at' => '12 Nov 2025 14:31',
                'updated_at_iso' => '2025-11-12T14:31:00+07:00',
                'sla_target' => '6 jam',
                'impact' => 'Dashboard desa menampilkan jumlah pengunjung yang tidak sesuai dengan laporan Google Analytics.',
                'description' => 'Admin desa melaporkan adanya selisih signifikan antara data statistik pengunjung di dashboard Begawi dan Google Analytics dalam 3 hari terakhir.',
                'requester' => [
                    'name' => 'Siti Rahmawati',
                    'role' => 'Admin Desa',
                    'email' => 'siti.rahmawati@mekarjaya.id',
                    'phone' => '+62 812-5566-8833',
                ],
                'assignee' => [
                    'name' => 'Yasmin Pratiwi',
                    'role' => 'Analyst Support',
                ],
                'history' => [
                    [
                        'time' => '11 Nov 2025 11:05',
                        'status' => 'Open',
                        'actor' => 'Sistem',
                        'note' => 'Tiket dibuat otomatis dari email masuk dengan lampiran CSV.',
                    ],
                    [
                        'time' => '11 Nov 2025 11:32',
                        'status' => 'In Progress',
                        'actor' => 'Yasmin Pratiwi',
                        'note' => 'Mengunduh log agregasi data dan melakukan pengecekan awal.',
                    ],
                    [
                        'time' => '12 Nov 2025 14:31',
                        'status' => 'In Progress',
                        'actor' => 'Tim Data Platform',
                        'note' => 'Ditemukan anomali cache pada worker regional Lampung. Perlu deploy ulang.',
                    ],
                ],
                'notes' => [
                    [
                        'author' => 'Yasmin Pratiwi',
                        'role' => 'Analyst Support',
                        'time' => '12 Nov 2025 15:10',
                        'visibility' => 'internal',
                        'message' => 'Worker cache akan direstart pukul 16:00 WIB. Tenant sudah diinformasikan potensi downtime singkat.',
                    ],
                ],
                'attachments' => [
                    ['name' => 'analytics-diff.xlsx', 'size' => '215 KB'],
                    ['name' => 'worker-log.txt', 'size' => '130 KB'],
                ],
                'tags' => ['Data', 'Analitik', 'Dashboard'],
                'watchers' => [
                    ['name' => 'Rio Pradana', 'role' => 'Data Platform Lead'],
                ],
            ],
            [
                'id' => 'TCK-2025-0115',
                'subject' => 'Permintaan pelatihan fitur baru',
                'tenant' => 'UMKM Batik Lestari',
                'priority' => 'low',
                'status' => 'resolved',
                'category' => 'Pelatihan',
                'category_slug' => 'pelatihan',
                'channel' => 'Portal Support',
                'created_at' => '08 Nov 2025 09:24',
                'created_at_iso' => '2025-11-08T09:24:00+07:00',
                'updated_at' => '10 Nov 2025 15:18',
                'updated_at_iso' => '2025-11-10T15:18:00+07:00',
                'sla_target' => '3 hari kerja',
                'impact' => 'Tenant membutuhkan panduan fitur katalog baru sebelum melakukan pelatihan internal.',
                'description' => 'Tenant meminta sesi coaching clinic untuk fitur katalog produk dan integrasi dengan social commerce. Memerlukan modul pelatihan dan rekaman sesi.',
                'requester' => [
                    'name' => 'Rizky Aditya',
                    'role' => 'Lead Marketing',
                    'email' => 'rizky@batiklestari.id',
                    'phone' => '+62 811-2233-4455',
                ],
                'assignee' => [
                    'name' => 'Rangga Saputra',
                    'role' => 'Engineer Onboarding',
                ],
                'history' => [
                    [
                        'time' => '08 Nov 2025 09:24',
                        'status' => 'Open',
                        'actor' => 'Portal Support',
                        'note' => 'Tiket dibuat melalui form self-service.',
                    ],
                    [
                        'time' => '08 Nov 2025 10:05',
                        'status' => 'In Progress',
                        'actor' => 'Rangga Saputra',
                        'note' => 'Menawarkan jadwal sesi pelatihan secara daring pada 10 Nov 2025.',
                    ],
                    [
                        'time' => '10 Nov 2025 15:18',
                        'status' => 'Resolved',
                        'actor' => 'Rangga Saputra',
                        'note' => 'Sesi pelatihan selesai dan rekaman dikirim ke tenant. Tiket ditutup dengan persetujuan tenant.',
                    ],
                ],
                'notes' => [
                    [
                        'author' => 'Rangga Saputra',
                        'role' => 'Engineer Onboarding',
                        'time' => '10 Nov 2025 16:02',
                        'visibility' => 'public',
                        'message' => 'Tenant memberikan rating 5/5 untuk sesi pelatihan. Materi diunggah ke pusat dokumentasi.',
                    ],
                ],
                'attachments' => [
                    ['name' => 'modul-pelatihan.pdf', 'size' => '1.8 MB'],
                    ['name' => 'rekaman-sesi.mp4', 'size' => '320 MB'],
                ],
                'tags' => ['Pelatihan', 'UMKM'],
                'watchers' => [
                    ['name' => 'Dwi Anggraini', 'role' => 'Customer Success'],
                ],
            ],
        ];
    }
}

