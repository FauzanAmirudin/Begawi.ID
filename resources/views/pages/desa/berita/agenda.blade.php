@extends('layouts.desa')

@section('title', 'Agenda Kegiatan - Desa Sejahtera')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
    .sticky-subnav {
        position: sticky;
        top: 80px;
        z-index: 40;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }
    
    .agenda-item:hover {
        background: #F1F5EB;
        transform: translateY(-2px);
    }
    
    .agenda-item {
        transition: all 0.3s ease;
    }
    
    .date-circle {
        background: linear-gradient(135deg, #1A723D, #83CD20);
    }
    
    .category-rapat { background: #e8f0d8; color: #1A723D; }
    .category-pelatihan { background: #d1e1b1; color: #1A723D; }
    .category-acara { background: #bad28a; color: #1A723D; }
    .category-kesehatan { background: #a3c363; color: #ffffff; }
    
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .fade-in-up.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* FullCalendar Custom Styles */
    .fc {
        background: white;
        border-radius: 1.5rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }
    
    .fc-header-toolbar {
        margin-bottom: 1.5rem !important;
    }
    
    .fc-button-group {
        gap: 0.5rem !important;
    }
    
    .fc-button-group .fc-button {
        padding: 0.5rem 0.625rem !important;
        font-size: 0.75rem !important;
        margin-right: 0.5rem !important;
    }
    
    .fc-button {
        background: #1A723D !important;
        border-color: #1A723D !important;
        border-radius: 0.5rem !important;
        padding: 0.25rem 0.625rem !important;
        font-weight: 600 !important;
        font-size: 0.75rem !important;
        margin-right: 0.5rem !important;
    }
    
    .fc-button:hover {
        background: #83CD20 !important;
        border-color: #83CD20 !important;
    }
    
    .fc-today-button {
        background: #83CD20 !important;
        border-color: #83CD20 !important;
        color: #ffffff !important;
        padding: 0.25rem 0.625rem !important;
        font-size: 0.75rem !important;
        margin-right: 0.5rem !important;
    }
    
    .fc-daygrid-day.fc-day-today {
        background: #F1F5EB !important;
    }
    
    .fc-event {
        border: none !important;
        border-radius: 0.5rem !important;
        padding: 2px 6px !important;
        font-size: 0.75rem !important;
        font-weight: 500 !important;
    }
    
    .fc-event-rapat { background: #1A723D !important; }
    .fc-event-pelatihan { background: #83CD20 !important; }
    .fc-event-acara { background: #a5d85a !important; }
    .fc-event-kesehatan { background: #c7e394 !important; }
    
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        border-top: 1px solid #e2e8f0;
        z-index: 50;
    }
    
    @media (min-width: 768px) {
        .bottom-nav {
            display: none;
        }
    }
    
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 100;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .modal-content {
        transform: translateY(20px) scale(0.95);
        transition: all 0.3s ease;
    }
    
    .modal-overlay.active .modal-content {
        transform: translateY(0) scale(1);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-light py-16">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center">
            <h1 class="text-4xl lg:text-6xl font-display font-bold text-primary-700 mb-4">
                📅 Agenda Kegiatan
            </h1>
            <p class="text-lg lg:text-xl text-slate-600 max-w-3xl mx-auto">
                Jadwal lengkap kegiatan dan acara yang akan diselenggarakan di Desa Sejahtera
            </p>
        </div>
    </div>
</section>

<!-- Sticky Sub Navigation -->
<div class="sticky-subnav border-b border-slate-200">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between py-4">
            <!-- Tab Navigation -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('desa.berita.index') }}" class="text-slate-600 hover:text-primary-600 font-medium pb-2 transition-colors">
                    📰 Berita
                </a>
                <a href="{{ route('desa.berita.agenda') }}" class="text-primary-600 font-semibold border-b-2 border-primary-600 pb-2">
                    📅 Agenda
                </a>
            </div>
            
        </div>
    </div>
</div>

<!-- Breadcrumb -->
<div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 py-4">
    <nav class="text-sm text-slate-600">
        <a href="{{ route('desa.home') }}" class="hover:text-green-700">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ route('desa.berita.index') }}" class="hover:text-green-700">Berita</a>
        <span class="mx-2">/</span>
        <span class="text-green-700 font-medium">Agenda</span>
    </nav>
</div>

<div class="max-w-[1280px] mx-auto px-6 sm:px-8 lg:px-12 pb-20">
    <!-- Quick Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12 fade-in-up">
        <div class="bg-white rounded-xl p-6 shadow-md text-center">
            <div class="text-3xl font-bold text-green-700 mb-2">{{ count($kegiatan) }}</div>
            <div class="text-sm text-slate-600">Kegiatan Mendatang</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md text-center">
            <div class="text-3xl font-bold text-blue-700 mb-2">{{ collect($kegiatan)->where('kategori', 'Pelatihan')->count() }}</div>
            <div class="text-sm text-slate-600">Pelatihan</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md text-center">
            <div class="text-3xl font-bold text-yellow-700 mb-2">{{ collect($kegiatan)->where('kategori', 'Acara')->count() }}</div>
            <div class="text-sm text-slate-600">Acara Umum</div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-md text-center">
            <div class="text-3xl font-bold text-pink-700 mb-2">{{ collect($kegiatan)->where('kategori', 'Kesehatan')->count() }}</div>
            <div class="text-sm text-slate-600">Kesehatan</div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-8">
        <!-- Jadwal Kegiatan List -->
        <div class="col-span-12 lg:col-span-5">
            <div class="bg-white rounded-2xl shadow-md p-6 fade-in-up">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2">
                        Jadwal Kegiatan
                    </h2>
                </div>
                
                <!-- Mobile Filter -->
                <div class="md:hidden mb-6">
                    <select class="w-full border border-slate-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-700 focus:outline-none text-sm">
                        <option value="">Filter Bulan</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                    </select>
                </div>

                <!-- Kegiatan List -->
                <div class="space-y-4 max-h-[600px] overflow-y-auto" id="agendaList">
                    @foreach($kegiatan as $item)
                    <div class="agenda-item p-4 rounded-xl border border-slate-200 cursor-pointer" onclick="openEventModal({{ json_encode($item) }})">
                        <div class="flex items-start space-x-4">
                            <!-- Date Circle -->
                            <div class="flex-shrink-0">
                                <div class="date-circle w-16 h-16 rounded-full flex flex-col items-center justify-center text-white shadow-md">
                                    <span class="text-xs font-medium">{{ \Carbon\Carbon::parse($item['tanggal'])->format('M') }}</span>
                                    <span class="text-lg font-bold">{{ \Carbon\Carbon::parse($item['tanggal'])->format('d') }}</span>
                                </div>
                            </div>
                            
                            <!-- Event Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-lg font-display font-semibold text-slate-800 group-hover:text-green-700 transition-colors">
                                        {{ $item['judul'] }}
                                    </h3>
                                    <span class="category-{{ strtolower($item['kategori']) }} text-xs px-2 py-1 rounded-full font-medium ml-2">
                                        {{ $item['kategori'] }}
                                    </span>
                                </div>
                                
                                <div class="space-y-1 text-sm text-slate-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $item['waktu'] }} WIB</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        <span>{{ $item['tempat'] }}</span>
                                    </div>
                                </div>
                                
                                <p class="text-sm text-slate-600 mt-2 line-clamp-2">{{ $item['deskripsi'] }}</p>

                                <div class="mt-3 flex items-center gap-3">
                                    <button class="text-xs font-semibold text-green-700 hover:text-green-800 transition" onclick="openEventModal({{ json_encode($item) }}); event.stopPropagation();">
                                        Lihat Ringkas →
                                    </button>
                                    <a href="{{ route('desa.berita.agenda-detail', $item['id']) }}" onclick="event.stopPropagation();" class="text-xs font-semibold text-sky-600 hover:text-sky-700 transition">
                                        Detail Agenda
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                {{-- <!-- Load More Button -->
                <div class="text-center mt-6">
                    <button class="text-green-700 hover:text-green-800 font-medium text-sm hover:underline">
                        Muat Lebih Banyak →
                    </button>
                </div> --}}
            </div>
        </div>

        <!-- Interactive Calendar -->
        <div class="col-span-12 lg:col-span-7">
            <div class="fade-in-up">
                <div class="bg-green-50 rounded-3xl p-6 shadow-inner">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-display font-bold text-green-900">
                            Kalender Desa Interaktif
                        </h2>
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="flex items-center space-x-1">
                                <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                                <span class="text-slate-600">Rapat</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                                <span class="text-slate-600">Pelatihan</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-3 h-3 bg-yellow-600 rounded-full"></div>
                                <span class="text-slate-600">Acara</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-3 h-3 bg-pink-600 rounded-full"></div>
                                <span class="text-slate-600">Kesehatan</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FullCalendar Container -->
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events Preview -->
    <section class="mt-16 fade-in-up">
        <h2 class="text-2xl font-display font-bold text-green-900 border-b-4 border-yellow-400 inline-block pb-2 mb-8">
            🔔 Kegiatan Segera Dimulai
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach(array_slice($kegiatan, 0, 3) as $item)
            <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border-l-4 border-green-600">
                <div class="flex items-center justify-between mb-3">
                    <span class="category-{{ strtolower($item['kategori']) }} text-xs px-2 py-1 rounded-full font-medium">
                        {{ $item['kategori'] }}
                    </span>
                    <span class="text-sm text-slate-500">
                        {{ \Carbon\Carbon::parse($item['tanggal'])->diffForHumans() }}
                    </span>
                </div>
                <h3 class="text-lg font-display font-semibold text-slate-800 mb-2">{{ $item['judul'] }}</h3>
                <div class="space-y-1 text-sm text-slate-600 mb-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $item['waktu'] }} WIB</span>
                    </div>
                </div>
                <p class="text-sm text-slate-600 line-clamp-2">{{ $item['deskripsi'] }}</p>
                <button class="mt-4 text-green-700 hover:text-green-800 font-medium text-sm" onclick="openEventModal({{ json_encode($item) }})">
                    Lihat Detail →
                </button>
            </div>
            @endforeach
        </div>
    </section>
</div>

<!-- Mobile Bottom Navigation -->
<div class="bottom-nav md:hidden">
    <div class="flex items-center justify-around py-3">
        <a href="{{ route('desa.berita.agenda') }}" class="flex flex-col items-center space-y-1 text-green-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="text-xs font-medium">Agenda</span>
        </a>
        <a href="{{ route('desa.berita.index') }}" class="flex flex-col items-center space-y-1 text-slate-600 hover:text-green-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <span class="text-xs">Berita</span>
        </a>
        <button onclick="openAddEventModal()" class="flex flex-col items-center space-y-1 text-slate-600 hover:text-green-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span class="text-xs">Tambah</span>
        </button>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal-overlay" id="eventModal" onclick="closeEventModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="modal-content bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-display font-bold text-green-900" id="modalTitle">Detail Kegiatan</h3>
                <button onclick="closeEventModal()" class="text-slate-500 hover:text-slate-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="modalContent">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal-overlay" id="addEventModal" onclick="closeAddEventModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="modal-content bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-display font-bold text-green-900">Tambah Jadwal Kegiatan</h3>
                <button onclick="closeAddEventModal()" class="text-slate-500 hover:text-slate-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Judul Kegiatan</label>
                    <input type="text" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-green-600 focus:outline-none" placeholder="Masukkan judul kegiatan">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal</label>
                        <input type="date" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-green-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Waktu</label>
                        <input type="time" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-green-600 focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tempat</label>
                    <input type="text" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-green-600 focus:outline-none" placeholder="Lokasi kegiatan">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                    <select class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-green-600 focus:outline-none">
                        <option value="Rapat">Rapat</option>
                        <option value="Pelatihan">Pelatihan</option>
                        <option value="Acara">Acara</option>
                        <option value="Kesehatan">Kesehatan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                    <textarea class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-green-600 focus:outline-none" rows="3" placeholder="Deskripsi kegiatan"></textarea>
                </div>
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeAddEventModal()" class="flex-1 bg-slate-200 text-slate-700 py-3 rounded-xl font-semibold hover:bg-slate-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-green-700 text-white py-3 rounded-xl font-semibold hover:bg-green-800 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize FullCalendar
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan',
            list: 'Daftar'
        },
        events: @json($kalender_events),
        eventClick: function(info) {
            // Find the event details from kegiatan data
            const eventData = @json($kegiatan).find(item => 
                item.judul === info.event.title
            );
            if (eventData) {
                openEventModal(eventData);
            }
        },
        eventClassNames: function(arg) {
            return ['fc-event-' + arg.event.extendedProps.category];
        },
        height: 'auto',
        aspectRatio: 1.35
    });
    
    calendar.render();

    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });

    // Filter functionality
    const monthFilter = document.getElementById('monthFilter');
    if (monthFilter) {
        monthFilter.addEventListener('change', function() {
            filterEventsByMonth(this.value);
        });
    }
});

// View toggle functions
function toggleView(view) {
    const listBtn = document.getElementById('listViewBtn');
    const calendarBtn = document.getElementById('calendarViewBtn');
    
    if (view === 'list') {
        listBtn.querySelector('svg').classList.add('text-green-700');
        listBtn.querySelector('svg').classList.remove('text-slate-500');
        calendarBtn.querySelector('svg').classList.add('text-slate-500');
        calendarBtn.querySelector('svg').classList.remove('text-green-700');
        // Show list view logic here
    } else {
        calendarBtn.querySelector('svg').classList.add('text-green-700');
        calendarBtn.querySelector('svg').classList.remove('text-slate-500');
        listBtn.querySelector('svg').classList.add('text-slate-500');
        listBtn.querySelector('svg').classList.remove('text-green-700');
        // Show calendar view logic here
    }
}

// Modal functions
function openEventModal(eventData) {
    const modal = document.getElementById('eventModal');
    const modalContent = document.getElementById('modalContent');
    const modalTitle = document.getElementById('modalTitle');
    
    modalTitle.textContent = eventData.judul;
    
    const categoryClass = 'category-' + eventData.kategori.toLowerCase();
    const formatDate = new Date(eventData.tanggal).toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    modalContent.innerHTML = `
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="${categoryClass} text-sm px-3 py-1 rounded-full font-medium">
                    ${eventData.kategori}
                </span>
                <span class="text-sm text-slate-500">${formatDate}</span>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center gap-3 text-slate-700">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>${eventData.waktu} WIB</span>
                </div>
                
                <div class="flex items-center gap-3 text-slate-700">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    </svg>
                    <span>${eventData.tempat}</span>
                </div>
            </div>
            
            <div class="bg-slate-50 rounded-xl p-4">
                <h4 class="font-semibold text-slate-800 mb-2">Deskripsi</h4>
                <p class="text-slate-700 text-sm leading-relaxed">${eventData.deskripsi}</p>
            </div>
            
            <div class="flex space-x-3 pt-4">
                <button onclick="closeEventModal()" class="flex-1 bg-slate-200 text-slate-700 py-3 rounded-xl font-semibold hover:bg-slate-300 transition-colors">
                    Tutup
                </button>
                <button class="flex-1 bg-green-700 text-white py-3 rounded-xl font-semibold hover:bg-green-800 transition-colors">
                    Tambahkan ke Kalender
                </button>
            </div>
        </div>
    `;
    
    modal.classList.add('active');
}

function closeEventModal() {
    const modal = document.getElementById('eventModal');
    modal.classList.remove('active');
}

function openAddEventModal() {
    const modal = document.getElementById('addEventModal');
    modal.classList.add('active');
}

function closeAddEventModal() {
    const modal = document.getElementById('addEventModal');
    modal.classList.remove('active');
}

// Filter events by month
function filterEventsByMonth(month) {
    const agendaItems = document.querySelectorAll('.agenda-item');
    
    agendaItems.forEach(item => {
        if (month === '') {
            item.style.display = 'block';
        } else {
            // This would need to be implemented based on actual data attributes
            // For demo purposes, showing all items
            item.style.display = 'block';
        }
    });
}

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        closeEventModal();
        closeAddEventModal();
    }
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEventModal();
        closeAddEventModal();
    }
});
</script>
@endpush