<div class="p-6">
    <!-- Logo -->
    <div class="flex items-center gap-3 mb-8">
        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
        </div>
        <span class="text-xl font-semibold text-gray-800">Constructor</span>
    </div>

    <!-- Navigation Menu -->
    <nav class="space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard.index') }}" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-orange-500 to-pink-500 rounded-xl font-medium">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span>Dashboard</span>
            </div>
            <span class="bg-white/20 text-xs px-2 py-1 rounded-full">1</span>
        </a>

        <!-- Pages -->
        <a href="#" class="flex items-center justify-between px-4 py-3 text-white bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl font-medium">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Pages</span>
            </div>
            <span class="bg-white/20 text-xs px-2 py-1 rounded-full">5</span>
        </a>

        <!-- Posts -->
        <div class="flex items-center justify-between px-4 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl font-medium cursor-pointer">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
                <span>Posts</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">NEW</span>
                <span class="text-xs text-gray-400">1</span>
            </div>
        </div>

        <!-- Media Files -->
        <div class="flex items-center justify-between px-4 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl font-medium cursor-pointer">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                <span>Media Files</span>
            </div>
            <span class="text-xs text-gray-400">1</span>
        </div>

        <!-- Users -->
        <div class="flex items-center justify-between px-4 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl font-medium cursor-pointer">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                </svg>
                <span>Users</span>
            </div>
            <span class="text-xs text-gray-400">1</span>
        </div>
    </nav>

    <!-- User List -->
    <div class="mt-8">
        <div class="space-y-3">
            @foreach($users as $user)
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                    {{ $user['avatar'] }}
                </div>
                <div class="flex-1">
                    <div class="text-sm font-medium text-gray-800">{{ $user['name'] }}</div>
                </div>
                <div class="w-2 h-2 rounded-full {{ $user['status'] == 'active' ? 'bg-green-400' : ($user['status'] == 'wait' ? 'bg-amber-400' : 'bg-gray-300') }}"></div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Bottom Menu -->
    <div class="mt-auto pt-8 space-y-2">
        <div class="flex items-center justify-between px-4 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl font-medium cursor-pointer">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <span>Categories</span>
            </div>
            <span class="text-xs text-gray-400">1</span>
        </div>

        <div class="flex items-center justify-between px-4 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl font-medium cursor-pointer">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                <span>Tags</span>
            </div>
            <span class="text-xs text-gray-400">1</span>
        </div>

        <div class="flex items-center justify-between px-4 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl font-medium cursor-pointer">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span>Comments</span>
            </div>
            <span class="text-xs text-gray-400">1</span>
        </div>

        <div class="flex items-center justify-between px-4 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-xl font-medium cursor-pointer">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Settings</span>
            </div>
        </div>
    </div>
</div>