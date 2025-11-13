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
    <nav class="space-y-2 flex-1">
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
});
</script>
