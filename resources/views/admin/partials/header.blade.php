<div class="flex items-center justify-between">
    <!-- Left Side - Navigation -->
    {{-- <div class="flex items-center gap-6">
        <div class="flex items-center gap-4">
            <nav class="flex items-center gap-6 ml-8">
                @if(auth()->user()->role === \App\Models\User::ROLE_SUPER_ADMIN)
                <a href="{{ route('admin.platform-directory.index') }}" class="{{ request()->routeIs('admin.platform-directory.*') ? 'text-emerald-600 font-semibold border-b-2 border-emerald-600 pb-1' : 'text-gray-500 hover:text-gray-700' }}">
                    Direktori Platform
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'text-purple-600 font-semibold border-b-2 border-purple-600 pb-1' : 'text-gray-500 hover:text-gray-700' }}">
                    Manajemen Pengguna
                </a>
                <div class="relative group">
                    <a href="#" class="{{ request()->routeIs('admin.websites.*') ? 'text-purple-600 font-semibold border-b-2 border-purple-600 pb-1' : 'text-gray-500 hover:text-gray-700' }}">
                        Manajemen Website
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <div class="py-2">
                            <a href="{{ route('admin.websites.desa') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.websites.desa') ? 'bg-emerald-50 text-emerald-700' : '' }}">
                                Website Desa
                            </a>
                            <a href="{{ route('admin.websites.umkm') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.websites.umkm') ? 'bg-emerald-50 text-emerald-700' : '' }}">
                                Website UMKM
                            </a>
                            <a href="{{ route('admin.websites.domain') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.websites.domain') ? 'bg-emerald-50 text-emerald-700' : '' }}">
                                Status Aktivasi & Domain
                            </a>
                            <a href="{{ route('admin.websites.template') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.websites.template') ? 'bg-emerald-50 text-emerald-700' : '' }}">
                                Integrasi Template
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <a href="#" class="{{ request()->routeIs('admin.finance.*') ? 'text-purple-600 font-semibold border-b-2 border-purple-600 pb-1' : 'text-gray-500 hover:text-gray-700' }}">
                        Keuangan & Transaksi
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <div class="py-2">
                            <a href="{{ route('admin.finance.packages.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.finance.packages.*') ? 'bg-purple-50 text-purple-700' : '' }}">
                                Paket Langganan
                            </a>
                            <a href="{{ route('admin.finance.transactions.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.finance.transactions.*') ? 'bg-purple-50 text-purple-700' : '' }}">
                                Riwayat Pembayaran
                            </a>
                            <a href="{{ route('admin.finance.payment-gateways.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.finance.payment-gateways.*') ? 'bg-purple-50 text-purple-700' : '' }}">
                                Integrasi Payment Gateway
                            </a>
                            <a href="{{ route('admin.finance.reports.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.finance.reports.*') ? 'bg-purple-50 text-purple-700' : '' }}">
                                Laporan Keuangan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <a href="#" class="{{ request()->routeIs('admin.content.*') ? 'text-indigo-600 font-semibold border-b-2 border-indigo-600 pb-1' : 'text-gray-500 hover:text-gray-700' }}">
                        Konten & Edukasi
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <div class="py-2">
                            <a href="{{ route('admin.content.articles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.content.articles.*') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                                Artikel / Berita
                            </a>
                            <a href="{{ route('admin.content.videos.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.content.videos.*') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                                Video & Dokumentasi
                            </a>
                            <a href="{{ route('admin.content.pages.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.content.pages.*') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                                Pusat Informasi & Edukasi
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <a href="#" class="{{ request()->routeIs('admin.logs.*') ? 'text-purple-600 font-semibold border-b-2 border-purple-600 pb-1' : 'text-gray-500 hover:text-gray-700' }}">
                        Audit & Log Aktivitas
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <div class="py-2">
                            <a href="{{ route('admin.logs.user') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.logs.user') ? 'bg-purple-50 text-purple-700' : '' }}">
                                Aktivitas Pengguna
                            </a>
                            <a href="{{ route('admin.logs.system') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.logs.system') ? 'bg-purple-50 text-purple-700' : '' }}">
                                Audit Sistem
                            </a>
                            <a href="{{ route('admin.logs.download.page') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.logs.download.page') ? 'bg-purple-50 text-purple-700' : '' }}">
                                Download Report
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <div class="relative group">
                    <a href="{{ route('admin.support.index') }}" class="{{ request()->routeIs('admin.support.*') ? 'text-cyan-600 font-semibold border-b-2 border-cyan-600 pb-1' : 'text-gray-500 hover:text-gray-700' }}">
                        Support & Pengaduan
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div class="absolute left-0 mt-2 w-60 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <div class="py-2">
                            <a href="{{ route('admin.support.tickets') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.support.tickets') ? 'bg-cyan-50 text-cyan-700' : '' }}">
                                Tiket Pengaduan
                            </a>
                            <a href="{{ route('admin.support.documentation') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.support.documentation') ? 'bg-cyan-50 text-cyan-700' : '' }}">
                                Dokumentasi Bantuan
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div> --}}

    @php
        $user = auth()->user();
        $roleLabel = ucfirst(str_replace('_', ' ', $user->role));
        $roleBadgeClass = match ($user->role) {
            \App\Models\User::ROLE_SUPER_ADMIN => 'bg-purple-100 text-purple-600',
            \App\Models\User::ROLE_ADMIN_DESA => 'bg-emerald-100 text-emerald-600',
            default => 'bg-blue-100 text-blue-600',
        };
    @endphp

    <!-- Role Context & Quick Actions -->
    <div class="flex items-center gap-4">
        <div class="hidden lg:flex items-center gap-2">
            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $roleBadgeClass }}">
                {{ $roleLabel }}
            </span>
            @if($user->role === \App\Models\User::ROLE_ADMIN_DESA)
            <span class="text-sm text-gray-500">Panel Desa Sejahtera</span>
            @endif
        </div>

        @if($user->role === \App\Models\User::ROLE_ADMIN_DESA)
        <div class="hidden md:flex items-center gap-2">
            <a href="{{ route('admin.desa-management.index') }}" class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold rounded-lg bg-gradient-to-r from-gray-900 to-gray-700 text-white shadow-sm hover:opacity-95 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h12m-7 5h7"></path>
                </svg>
                Kelola Website
            </a>
            <a href="{{ route('admin.desa-management.umkm') }}" class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold rounded-lg bg-gradient-to-r from-purple-500 to-indigo-500 text-white shadow-sm hover:opacity-95 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6"></path>
                </svg>
                Panel UMKM
            </a>
            <a href="{{ route('desa.umkm.index') }}" class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold rounded-lg bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-sm hover:opacity-95 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah UMKM
            </a>
            <a href="{{ route('desa.berita.index') }}" class="inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold rounded-lg bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-sm hover:opacity-95 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"></path>
                </svg>
                Tambah Berita
            </a>
        </div>
        @endif
    </div>

    <!-- Center - Search -->
    <div class="flex-1 max-w-md mx-8">
        <div class="relative">
            <input type="text" 
                   placeholder="Cari..." 
                   class="w-full pl-4 pr-10 py-2 bg-gray-100 border-0 rounded-lg text-sm text-gray-600 placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:outline-none">
            <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Right Side - Actions -->
    <div class="flex items-center gap-4">
        <!-- Notifications -->
        <button class="relative p-2 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="absolute -top-1 -right-1 w-5 h-5 bg-purple-500 text-white text-xs rounded-full flex items-center justify-center font-bold">1</span>
        </button>

        <!-- Profile -->
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                {{ substr($user->name, 0, 2) }}
            </div>
            <div class="text-sm">
                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                <div class="text-xs text-gray-500">{{ $roleLabel }}</div>
            </div>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="p-2 text-gray-400 hover:text-gray-600" title="Logout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </button>
        </form>
    </div>
</div>
