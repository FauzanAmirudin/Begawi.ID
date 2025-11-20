<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Constructor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>
<body class="bg-gray-50 font-inter">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="admin-sidebar" class="w-64 bg-white shadow-sm border-r border-gray-200 flex flex-col transition-all duration-300 ease-in-out">
            @include('admin.partials.sidebar')
        </aside>

        <!-- Main Content -->
        <div id="admin-main-content" class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                @include('admin.partials.header')
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>