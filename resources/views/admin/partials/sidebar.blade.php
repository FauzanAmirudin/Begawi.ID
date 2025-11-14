<div class="p-6 flex flex-col h-full">
    <!-- Logo -->
    <div class="flex items-center gap-3 mb-8">
        <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
            </svg>
        </div>
        <span class="text-xl font-semibold text-gray-800">Begawi.id</span>
    </div>

    <!-- Navigation Menu -->
    <nav class="space-y-2 flex-1 overflow-y-auto pr-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-orange-500 to-pink-500 rounded-xl font-medium {{ request()->routeIs('admin.dashboard.*') ? 'ring-2 ring-orange-300' : '' }}">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span>Dashboard</span>
            </div>
        </a>

        @if(auth()->user()->role === \App\Models\User::ROLE_SUPER_ADMIN)
        <!-- Direktori Platform -->
        <a href="{{ route('admin.platform-directory.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl font-medium {{ request()->routeIs('admin.platform-directory.*') ? 'ring-2 ring-emerald-300' : '' }}">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h12m-7 5h7"></path>
                </svg>
                <span>Direktori Platform</span>
            </div>
            <span class="bg-white/20 text-xs px-2 py-1 rounded-full">{{ \App\Models\Website::where('status', 'active')->count() }}</span>
        </a>

        <!-- Manajemen Pengguna -->
        <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl font-medium {{ request()->routeIs('admin.users.*') ? 'ring-2 ring-emerald-300' : '' }}">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                </svg>
                <span>Manajemen Pengguna</span>
            </div>
            <span class="bg-white/20 text-xs px-2 py-1 rounded-full">{{ \App\Models\User::count() }}</span>
        </a>

        <!-- Manajemen Website - Dropdown -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('website-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl font-medium {{ request()->routeIs('admin.websites.*') ? 'ring-2 ring-blue-300' : '' }} hover:opacity-90 transition">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    <span>Manajemen Website</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-white/20 text-xs px-2 py-1 rounded-full">{{ \App\Models\Website::count() }}</span>
                    <svg id="website-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.websites.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </button>
            <div id="website-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.websites.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.websites.desa') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.websites.desa') ? 'bg-emerald-50 text-emerald-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Website Desa</span>
                </a>
                <a href="{{ route('admin.websites.umkm') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.websites.umkm') ? 'bg-emerald-50 text-emerald-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>Website UMKM</span>
                </a>
                <a href="{{ route('admin.websites.domain') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.websites.domain') ? 'bg-emerald-50 text-emerald-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                    <span>Status Aktivasi & Domain</span>
                </a>
                <a href="{{ route('admin.websites.template') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.websites.template') ? 'bg-emerald-50 text-emerald-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"></path>
                    </svg>
                    <span>Integrasi Template</span>
                </a>
            </div>
        </div>

        <!-- Keuangan & Transaksi - Dropdown -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('finance-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl font-medium {{ request()->routeIs('admin.finance.*') ? 'ring-2 ring-purple-300' : '' }} hover:opacity-90 transition">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Keuangan & Transaksi</span>
                </div>
                <svg id="finance-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.finance.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="finance-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.finance.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.finance.packages.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.finance.packages.*') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Paket Langganan</span>
                </a>
                <a href="{{ route('admin.finance.transactions.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.finance.transactions.*') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Riwayat Pembayaran</span>
                </a>
                <a href="{{ route('admin.finance.payment-gateways.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.finance.payment-gateways.*') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Integrasi Payment Gateway</span>
                </a>
                <a href="{{ route('admin.finance.reports.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.finance.reports.*') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Laporan Keuangan</span>
                </a>
            </div>
        </div>

        <!-- Konten & Edukasi - Dropdown -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('content-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl font-medium {{ request()->routeIs('admin.content.*') ? 'ring-2 ring-indigo-300' : '' }} hover:opacity-90 transition">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Konten & Edukasi</span>
                </div>
                <svg id="content-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.content.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="content-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.content.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.content.articles.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.content.articles.*') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Artikel / Berita</span>
                </a>
                <a href="{{ route('admin.content.videos.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.content.videos.*') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span>Video & Dokumentasi</span>
                </a>
                <a href="{{ route('admin.content.pages.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.content.pages.*') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Pusat Informasi & Edukasi</span>
                </a>
            </div>
        </div>

        <!-- Audit & Log Aktivitas - Dropdown -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('logs-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl font-medium {{ request()->routeIs('admin.logs.*') ? 'ring-2 ring-gray-600' : '' }} hover:opacity-90 transition">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h6m-8 8h8a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span>Audit & Log Aktivitas</span>
                </div>
                <svg id="logs-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.logs.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="logs-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.logs.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.logs.user') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.logs.user') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Aktivitas Pengguna</span>
                </a>
                <a href="{{ route('admin.logs.system') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.logs.system') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 11V7a1 1 0 012 0v4h4a1 1 0 010 2h-4v4a1 1 0 01-2 0v-4H7a1 1 0 010-2h4z"></path>
                    </svg>
                    <span>Audit Sistem</span>
                </a>
            </div>
        </div>

        <!-- Support & Pengaduan -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('support-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl font-medium {{ request()->routeIs('admin.support.*') ? 'ring-2 ring-cyan-300' : '' }} hover:opacity-90 transition">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414M6.05 17.95l-1.414 1.414M9 5H5a2 2 0 00-2 2v4m16 0v4a2 2 0 01-2 2h-4M15 9h.01M19 9h.01M9 15h.01M5 15h.01"></path>
                    </svg>
                    <span>Support & Pengaduan</span>
                </div>
                <svg id="support-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.support.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="support-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.support.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.support.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.support.index') ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M8 7h8M5 11h14M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                    </svg>
                    <span>Ringkasan Support</span>
                </a>
                <a href="{{ route('admin.support.tickets') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.support.tickets') ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Tiket Pengaduan</span>
                </a>
                <a href="{{ route('admin.support.documentation') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition {{ request()->routeIs('admin.support.documentation') ? 'bg-cyan-50 text-cyan-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Dokumentasi Bantuan</span>
                </a>
            </div>
        </div>
        @elseif(auth()->user()->role === \App\Models\User::ROLE_ADMIN_DESA)
        <!-- Manajemen Website Desa -->
        <a href="{{ route('admin.desa-management.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl font-medium {{ request()->routeIs('admin.desa-management.index') ? 'ring-2 ring-emerald-300' : '' }} hover:opacity-95 transition">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>Manajemen Desa</span>
            </div>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

        <!-- Manajemen UMKM Desa -->
        <a href="{{ route('admin.desa-management.umkm') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-purple-500 to-indigo-500 rounded-xl font-medium {{ request()->routeIs('admin.desa-management.umkm') ? 'ring-2 ring-purple-300' : '' }} hover:opacity-95 transition">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                </svg>
                <span>Manajemen UMKM</span>
            </div>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

        <!-- Direktori UMKM -->

        <!-- Konten Desa Dropdown -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('village-content-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.desa-management.*') ? 'ring-2 ring-indigo-300' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Konten Desa</span>
                </div>
                <svg id="village-content-dropdown-icon" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="village-content-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.desa-management.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.desa-management.index') }}#profile" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 5c-4.418 0-8 2.239-8 5v1a1 1 0 001 1h14a1 1 0 001-1v-1c0-2.761-3.582-5-8-5z"></path>
                    </svg>
                    <span>Profil Desa</span>
                </a>
                <a href="{{ route('admin.desa-management.index') }}#news" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 5H9a2 2 0 00-2 2v12m12-14h2a1 1 0 011 1v12a1 1 0 01-1 1h-2m0-14v14M7 9h6m-6 4h6m-6 4h6"></path>
                    </svg>
                    <span>Berita Desa</span>
                </a>
                <a href="{{ route('admin.desa-management.index') }}#gallery" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a2 2 0 012-2h12a2 2 0 012 2v6l-4-3-4 5-3-2-5 4V5z"></path>
                    </svg>
                    <span>Galeri Kegiatan</span>
                </a>
                <a href="{{ route('admin.desa-management.index') }}#potency" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l2.09 6.26L20 9.27l-5 3.64 1.91 6.09L12 15.77l-4.91 3.23L9 12.91 4 9.27l5.91-.99L12 2z"></path>
                    </svg>
                    <span>Potensi & Wisata</span>
                </a>
                <a href="{{ route('admin.desa-management.index') }}#achievement" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l7 7-7 7"></path>
                    </svg>
                    <span>Prestasi & Program</span>
                </a>
            </div>
        </div>

        <!-- Validasi Konten -->
        <a href="{{ route('admin.desa-management.index') }}#news" class="flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-medium hover:border-amber-400 hover:text-amber-600 transition">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Validasi Konten</span>
            </div>
            <span class="text-xs font-semibold text-amber-500">Prioritas</span>
        </a>

        <!-- Support -->
        <a href="{{ route('admin.support.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl font-medium hover:opacity-95 transition">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414M6.05 17.95l-1.414 1.414M9 5H5a2 2 0 00-2 2v4m16 0v4a2 2 0 01-2 2h-4M15 9h.01M19 9h.01M9 15h.01M5 15h.01"></path>
                </svg>
                <span>Pusat Bantuan</span>
            </div>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

        @elseif(auth()->user()->role === \App\Models\User::ROLE_ADMIN_UMKM)
        <a href="{{ route('desa.umkm.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-purple-500 to-indigo-500 rounded-xl font-medium hover:opacity-95 transition">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                </svg>
                <span>Produk & Toko</span>
            </div>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
        <a href="{{ route('admin.support.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl font-medium hover:opacity-95 transition">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414M6.05 17.95l-1.414 1.414M9 5H5a2 2 0 00-2 2v4m16 0v4a2 2 0 01-2 2h-4M15 9h.01M19 9h.01M9 15h.01M5 15h.01"></path>
                </svg>
                <span>Pusat Bantuan</span>
            </div>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
        @endif
    </nav>

    <!-- User Info (Bottom) -->
    <div class="mt-auto pt-6 border-t border-gray-200">
        <div class="flex items-center gap-3 px-4 py-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-500 truncate">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const icon = document.getElementById(dropdownId + '-icon');
    
    if (dropdown.classList.contains('max-h-0')) {
        // Expand
        dropdown.classList.remove('max-h-0', 'opacity-0');
        dropdown.classList.add('max-h-96', 'opacity-100');
        if (icon) icon.classList.add('rotate-180');
    } else {
        // Collapse
        dropdown.classList.remove('max-h-96', 'opacity-100');
        dropdown.classList.add('max-h-0', 'opacity-0');
        if (icon) icon.classList.remove('rotate-180');
    }
}

// Auto-expand dropdown if current route matches
document.addEventListener('DOMContentLoaded', function() {
    @if(request()->routeIs('admin.websites.*'))
    const dropdown = document.getElementById('website-dropdown');
    const icon = document.getElementById('website-dropdown-icon');
    if (dropdown && !dropdown.classList.contains('max-h-96')) {
        dropdown.classList.remove('max-h-0', 'opacity-0');
        dropdown.classList.add('max-h-96', 'opacity-100');
        if (icon) icon.classList.add('rotate-180');
    }
    @endif
    
    @if(request()->routeIs('admin.finance.*'))
    const financeDropdown = document.getElementById('finance-dropdown');
    const financeIcon = document.getElementById('finance-dropdown-icon');
    if (financeDropdown && !financeDropdown.classList.contains('max-h-96')) {
        financeDropdown.classList.remove('max-h-0', 'opacity-0');
        financeDropdown.classList.add('max-h-96', 'opacity-100');
        if (financeIcon) financeIcon.classList.add('rotate-180');
    }
    @endif
    
    @if(request()->routeIs('admin.content.*'))
    const contentDropdown = document.getElementById('content-dropdown');
    const contentIcon = document.getElementById('content-dropdown-icon');
    if (contentDropdown && !contentDropdown.classList.contains('max-h-96')) {
        contentDropdown.classList.remove('max-h-0', 'opacity-0');
        contentDropdown.classList.add('max-h-96', 'opacity-100');
        if (contentIcon) contentIcon.classList.add('rotate-180');
    }
    @endif

    @if(request()->routeIs('admin.logs.*'))
    const logsDropdown = document.getElementById('logs-dropdown');
    const logsIcon = document.getElementById('logs-dropdown-icon');
    if (logsDropdown && !logsDropdown.classList.contains('max-h-96')) {
        logsDropdown.classList.remove('max-h-0', 'opacity-0');
        logsDropdown.classList.add('max-h-96', 'opacity-100');
        if (logsIcon) logsIcon.classList.add('rotate-180');
    }
    @endif

    @if(request()->routeIs('admin.support.*'))
    const supportDropdown = document.getElementById('support-dropdown');
    const supportIcon = document.getElementById('support-dropdown-icon');
    if (supportDropdown && !supportDropdown.classList.contains('max-h-96')) {
        supportDropdown.classList.remove('max-h-0', 'opacity-0');
        supportDropdown.classList.add('max-h-96', 'opacity-100');
        if (supportIcon) supportIcon.classList.add('rotate-180');
    }
    @endif
});
</script>
