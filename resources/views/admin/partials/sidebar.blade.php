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
        <div class="space-y-1">
            <button onclick="toggleDropdown('village-content-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.desa-management.index') || request()->routeIs('admin.desa-management.profile') || request()->routeIs('admin.desa-management.news') || request()->routeIs('admin.desa-management.agendas') || request()->routeIs('admin.desa-management.gallery') || request()->routeIs('admin.desa-management.potentials') || request()->routeIs('admin.desa-management.achievements') ? 'ring-2 ring-indigo-300' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Manajemen Desa</span>
                </div>
                <svg id="village-content-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.desa-management.index') || request()->routeIs('admin.desa-management.profile') || request()->routeIs('admin.desa-management.news') || request()->routeIs('admin.desa-management.agendas') || request()->routeIs('admin.desa-management.gallery') || request()->routeIs('admin.desa-management.potentials') || request()->routeIs('admin.desa-management.achievements') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="village-content-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.desa-management.index') || request()->routeIs('admin.desa-management.profile') || request()->routeIs('admin.desa-management.news') || request()->routeIs('admin.desa-management.agendas') || request()->routeIs('admin.desa-management.gallery') || request()->routeIs('admin.desa-management.potentials') || request()->routeIs('admin.desa-management.achievements') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.desa-management.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.index') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.desa-management.profile') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.profile') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 5c-4.418 0-8 2.239-8 5v1a1 1 0 001 1h14a1 1 0 001-1v-1c0-2.761-3.582-5-8-5z"></path>
                    </svg>
                    <span>Profil Desa</span>
                </a>
                <a href="{{ route('admin.desa-management.news') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.news') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 5H9a2 2 0 00-2 2v12m12-14h2a1 1 0 011 1v12a1 1 0 01-1 1h-2m0-14v14M7 9h6m-6 4h6m-6 4h6"></path>
                    </svg>
                    <span>Berita</span>
                </a>
                <a href="{{ route('admin.desa-management.agendas') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.agendas') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Agenda</span>
                </a>
                <a href="{{ route('admin.desa-management.gallery') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.gallery') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a2 2 0 012-2h12a2 2 0 012 2v6l-4-3-4 5-3-2-5 4V5z"></path>
                    </svg>
                    <span>Galeri Desa</span>
                </a>
                <a href="{{ route('admin.desa-management.potentials') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.potentials') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l2.09 6.26L20 9.27l-5 3.64 1.91 6.09L12 15.77l-4.91 3.23L9 12.91 4 9.27l5.91-.99L12 2z"></path>
                    </svg>
                    <span>Potensi & Wisata</span>
                </a>
                <a href="{{ route('admin.desa-management.achievements') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.achievements') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    <span>Prestasi & Program</span>
                </a>
            </div>
        </div>

        <!-- Manajemen UMKM Desa -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('umkm-management-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-purple-500 to-indigo-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.desa-management.umkm-management.*') ? 'ring-2 ring-purple-300' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                    <span>Manajemen UMKM</span>
                </div>
                <svg id="umkm-management-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.desa-management.umkm-management.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="umkm-management-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.desa-management.umkm-management.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.desa-management.umkm-management.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.umkm-management.index') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.desa-management.umkm-management.list') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.umkm-management.list') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span>Daftar UMKM</span>
                </a>
                <a href="{{ route('admin.desa-management.umkm-management.create') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.umkm-management.create') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah UMKM Baru</span>
                </a>
                <a href="{{ route('admin.desa-management.umkm-management.monitoring') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.umkm-management.monitoring') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Monitoring</span>
                </a>
            </div>
        </div>

        <!-- Konten Desa Dropdown -->
        

        <!-- Manajemen Pengguna Lokal -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('local-users-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.desa-management.local-users.*') ? 'ring-2 ring-teal-300' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                    </svg>
                    <span>Manajemen Pengguna Lokal</span>
                </div>
                <svg id="local-users-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.desa-management.local-users.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="local-users-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.desa-management.local-users.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0 pointer-events-none' }}">
                <a href="{{ route('admin.desa-management.local-users.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.local-users.index') ? 'bg-teal-50 text-teal-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>Daftar Pengguna Desa</span>
                </a>
                <a href="{{ route('admin.desa-management.local-users.create') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.local-users.create') ? 'bg-teal-50 text-teal-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Pengguna</span>
                </a>
                <a href="{{ route('admin.desa-management.local-users.roles') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-teal-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.local-users.roles') ? 'bg-teal-50 text-teal-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    <span>Role Lokal</span>
                </a>
            </div>
        </div>

        <!-- Surat Online -->
        <a href="{{ route('admin.desa-management.letters.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-teal-500 to-emerald-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.desa-management.letters.*') ? 'ring-2 ring-teal-300' : '' }}">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Surat Online</span>
            </div>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

        <!-- Pengaduan Warga -->
        <a href="{{ route('admin.desa-management.complaints.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-orange-500 to-amber-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.desa-management.complaints.*') ? 'ring-2 ring-orange-300' : '' }}">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                <span>Pengaduan Warga</span>
            </div>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

        <!-- Laporan & Statistik -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('reports-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.desa-management.reports.*') ? 'ring-2 ring-indigo-300' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Laporan & Statistik</span>
                </div>
                <svg id="reports-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.desa-management.reports.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="reports-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.desa-management.reports.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.desa-management.reports.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.reports.index') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Ringkasan</span>
                </a>
                <a href="{{ route('admin.desa-management.reports.visitor-statistics') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.reports.visitor-statistics') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 0118 0 9 9 0 01-18 0zm9-3a3 3 0 100 6 3 3 0 000-6z"></path>
                    </svg>
                    <span>Statistik Pengunjung</span>
                </a>
                <a href="{{ route('admin.desa-management.reports.umkm-statistics') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.reports.umkm-statistics') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                    <span>Statistik UMKM</span>
                </a>
                <a href="{{ route('admin.desa-management.reports.digitalization-report') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.reports.digitalization-report') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Laporan Digitalisasi</span>
                </a>
                <a href="{{ route('admin.desa-management.reports.umkm-ranking') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('admin.desa-management.reports.umkm-ranking') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    <span>Ranking UMKM</span>
                </a>
            </div>
        </div>

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
        <!-- Manajemen Produk -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('umkm-products-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-purple-500 to-indigo-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.umkm.products.*') ? 'ring-2 ring-purple-300' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                    <span>Manajemen Produk</span>
                </div>
                <svg id="umkm-products-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.umkm.products.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="umkm-products-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.umkm.products.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.umkm.products.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition {{ request()->routeIs('admin.umkm.products.index') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span>Daftar Produk</span>
                </a>
                <a href="{{ route('admin.umkm.products.create') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition {{ request()->routeIs('admin.umkm.products.create') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Produk</span>
                </a>
                <a href="{{ route('admin.umkm.products.stock') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition {{ request()->routeIs('admin.umkm.products.stock') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Stok & Ketersediaan</span>
                </a>
                <a href="{{ route('admin.umkm.products.categories') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 rounded-lg transition {{ request()->routeIs('admin.umkm.products.categories*') ? 'bg-purple-50 text-purple-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>Kategori Produk</span>
                </a>
            </div>
        </div>

        <!-- Profil Usaha -->
        <a href="{{ route('admin.umkm.profile.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.umkm.profile.*') ? 'ring-2 ring-blue-300' : '' }}">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 5c-4.418 0-8 2.239-8 5v1a1 1 0 001 1h14a1 1 0 001-1v-1c0-2.761-3.582-5-8-5z"></path>
                </svg>
                <span>Profil Usaha</span>
            </div>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>

        <!-- Statistik & Analitik -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('umkm-statistics-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.umkm.statistics.*') ? 'ring-2 ring-indigo-300' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Statistik & Analitik</span>
                </div>
                <svg id="umkm-statistics-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.umkm.statistics.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="umkm-statistics-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.umkm.statistics.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.umkm.statistics.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('admin.umkm.statistics.index') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Ringkasan</span>
                </a>
                <a href="{{ route('admin.umkm.statistics.visitor-statistics') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('admin.umkm.statistics.visitor-statistics') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 0118 0 9 9 0 01-18 0zm9-3a3 3 0 100 6 3 3 0 000-6z"></path>
                    </svg>
                    <span>Statistik Pengunjung</span>
                </a>
                <a href="{{ route('admin.umkm.statistics.popular-products') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('admin.umkm.statistics.popular-products') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                    <span>Produk Terpopuler</span>
                </a>
                <a href="{{ route('admin.umkm.statistics.visitor-sources') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('admin.umkm.statistics.visitor-sources') ? 'bg-indigo-50 text-indigo-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>Sumber Pengunjung</span>
                </a>
            </div>
        </div>

        <!-- Laporan UMKM -->
        <div class="space-y-1">
            <button onclick="toggleDropdown('umkm-reports-dropdown')" class="w-full flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-orange-500 to-pink-500 rounded-xl font-medium hover:opacity-95 transition {{ request()->routeIs('admin.umkm.reports.*') ? 'ring-2 ring-orange-300' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Laporan UMKM</span>
                </div>
                <svg id="umkm-reports-dropdown-icon" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.umkm.reports.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="umkm-reports-dropdown" class="ml-4 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.umkm.reports.*') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                <a href="{{ route('admin.umkm.reports.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 rounded-lg transition {{ request()->routeIs('admin.umkm.reports.index') ? 'bg-orange-50 text-orange-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm8 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Ringkasan</span>
                </a>
                <a href="{{ route('admin.umkm.reports.product-reports', ['type' => 'most-viewed']) }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 rounded-lg transition {{ request()->routeIs('admin.umkm.reports.product-reports') ? 'bg-orange-50 text-orange-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                    </svg>
                    <span>Laporan Produk</span>
                </a>
                <a href="{{ route('admin.umkm.reports.activity-reports') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 rounded-lg transition {{ request()->routeIs('admin.umkm.reports.activity-reports') ? 'bg-orange-50 text-orange-700 font-medium' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Laporan Aktivitas</span>
                </a>
            </div>
        </div>
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
    
    // List of all dropdown IDs
    const allDropdowns = ['website-dropdown', 'finance-dropdown', 'content-dropdown', 'logs-dropdown', 'support-dropdown', 'village-content-dropdown', 'umkm-management-dropdown', 'reports-dropdown', 'local-users-dropdown', 'umkm-products-dropdown', 'umkm-statistics-dropdown', 'umkm-reports-dropdown'];
    
    // Close all other dropdowns
    allDropdowns.forEach(id => {
        if (id !== dropdownId) {
            const otherDropdown = document.getElementById(id);
            const otherIcon = document.getElementById(id + '-icon');
            if (otherDropdown) {
                // Check if dropdown is currently open (has max-h-96 or doesn't have max-h-0)
                const isOpen = otherDropdown.classList.contains('max-h-96') || 
                              (!otherDropdown.classList.contains('max-h-0') && !otherDropdown.classList.contains('hidden'));
                if (isOpen) {
                    otherDropdown.classList.remove('max-h-96', 'opacity-100', 'hidden');
                    otherDropdown.classList.add('max-h-0', 'opacity-0', 'pointer-events-none');
                    if (otherIcon) otherIcon.classList.remove('rotate-180');
                }
            }
        }
    });
    
    // Toggle current dropdown
    if (!dropdown) return;
    
    const isCurrentlyOpen = dropdown.classList.contains('max-h-96') && 
                           dropdown.classList.contains('opacity-100');
    
    if (isCurrentlyOpen) {
        // Collapse
        dropdown.classList.remove('max-h-96', 'opacity-100');
        dropdown.classList.add('max-h-0', 'opacity-0', 'pointer-events-none');
        if (icon) icon.classList.remove('rotate-180');
    } else {
        // Expand
        dropdown.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none', 'hidden');
        dropdown.classList.add('max-h-96', 'opacity-100');
        if (icon) icon.classList.add('rotate-180');
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

    @if(request()->routeIs('admin.desa-management.reports.*'))
    const reportsDropdown = document.getElementById('reports-dropdown');
    const reportsIcon = document.getElementById('reports-dropdown-icon');
    if (reportsDropdown && !reportsDropdown.classList.contains('max-h-96')) {
        reportsDropdown.classList.remove('max-h-0', 'opacity-0');
        reportsDropdown.classList.add('max-h-96', 'opacity-100');
        if (reportsIcon) reportsIcon.classList.add('rotate-180');
    }
    @endif

    @if(request()->routeIs('admin.desa-management.index') || request()->routeIs('admin.desa-management.profile') || request()->routeIs('admin.desa-management.news') || request()->routeIs('admin.desa-management.gallery') || request()->routeIs('admin.desa-management.potentials') || request()->routeIs('admin.desa-management.achievements'))
    const villageContentDropdown = document.getElementById('village-content-dropdown');
    const villageContentIcon = document.getElementById('village-content-dropdown-icon');
    if (villageContentDropdown && !villageContentDropdown.classList.contains('max-h-96')) {
        villageContentDropdown.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none');
        villageContentDropdown.classList.add('max-h-96', 'opacity-100');
        if (villageContentIcon) villageContentIcon.classList.add('rotate-180');
    }
    @endif

    @if(request()->routeIs('admin.desa-management.umkm-management.*'))
    const umkmManagementDropdown = document.getElementById('umkm-management-dropdown');
    const umkmManagementIcon = document.getElementById('umkm-management-dropdown-icon');
    if (umkmManagementDropdown && !umkmManagementDropdown.classList.contains('max-h-96')) {
        umkmManagementDropdown.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none', 'hidden');
        umkmManagementDropdown.classList.add('max-h-96', 'opacity-100');
        if (umkmManagementIcon) umkmManagementIcon.classList.add('rotate-180');
    }
    @endif

    @if(request()->routeIs('admin.desa-management.local-users.*'))
    const localUsersDropdown = document.getElementById('local-users-dropdown');
    const localUsersIcon = document.getElementById('local-users-dropdown-icon');
    if (localUsersDropdown && !localUsersDropdown.classList.contains('max-h-96')) {
        localUsersDropdown.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none');
        localUsersDropdown.classList.add('max-h-96', 'opacity-100');
        if (localUsersIcon) localUsersIcon.classList.add('rotate-180');
    }
    @endif

    @if(request()->routeIs('admin.umkm.products.*'))
    const umkmProductsDropdown = document.getElementById('umkm-products-dropdown');
    const umkmProductsIcon = document.getElementById('umkm-products-dropdown-icon');
    if (umkmProductsDropdown && !umkmProductsDropdown.classList.contains('max-h-96')) {
        umkmProductsDropdown.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none', 'hidden');
        umkmProductsDropdown.classList.add('max-h-96', 'opacity-100');
        if (umkmProductsIcon) umkmProductsIcon.classList.add('rotate-180');
    }
    @endif

    @if(request()->routeIs('admin.umkm.statistics.*'))
    const umkmStatisticsDropdown = document.getElementById('umkm-statistics-dropdown');
    const umkmStatisticsIcon = document.getElementById('umkm-statistics-dropdown-icon');
    if (umkmStatisticsDropdown && !umkmStatisticsDropdown.classList.contains('max-h-96')) {
        umkmStatisticsDropdown.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none', 'hidden');
        umkmStatisticsDropdown.classList.add('max-h-96', 'opacity-100');
        if (umkmStatisticsIcon) umkmStatisticsIcon.classList.add('rotate-180');
    }
    @endif

    @if(request()->routeIs('admin.umkm.reports.*'))
    const umkmReportsDropdown = document.getElementById('umkm-reports-dropdown');
    const umkmReportsIcon = document.getElementById('umkm-reports-dropdown-icon');
    if (umkmReportsDropdown && !umkmReportsDropdown.classList.contains('max-h-96')) {
        umkmReportsDropdown.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none', 'hidden');
        umkmReportsDropdown.classList.add('max-h-96', 'opacity-100');
        if (umkmReportsIcon) umkmReportsIcon.classList.add('rotate-180');
    }
    @endif
});
</script>
