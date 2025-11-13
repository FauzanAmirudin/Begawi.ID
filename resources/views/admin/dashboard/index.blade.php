@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <div class="flex gap-6">
        <!-- Main Content Area -->
        <div class="flex-1">
            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Pages Card -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Pages</p>
                            <p class="text-3xl font-bold">{{ number_format($stats['pages']) }}</p>
                        </div>
                        <button class="text-green-200 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                    </div>
                    <button class="flex items-center gap-2 text-green-100 hover:text-white text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        View All
                    </button>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>

                <!-- Posts Card -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Posts</p>
                            <p class="text-3xl font-bold">{{ number_format($stats['posts']) }}</p>
                        </div>
                        <button class="text-purple-200 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                    </div>
                    <button class="flex items-center gap-2 text-purple-100 hover:text-white text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        View All
                    </button>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>

                <!-- Users Card -->
                <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Users</p>
                            <p class="text-3xl font-bold">{{ $stats['users'] }}</p>
                        </div>
                        <button class="text-orange-200 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                    </div>
                    <button class="flex items-center gap-2 text-orange-100 hover:text-white text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        View All
                    </button>
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full"></div>
                </div>
            </div>

            <!-- Second Row Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Files Card -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Files</p>
                            <p class="text-3xl font-bold">{{ number_format($stats['files']) }}</p>
                        </div>
                        <button class="text-blue-200 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                    </div>
                    <button class="flex items-center gap-2 text-blue-100 hover:text-white text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        View All
                    </button>
                </div>

                <!-- Categories Card -->
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-300 text-sm font-medium">Categories</p>
                            <p class="text-3xl font-bold">{{ $stats['categories'] }}</p>
                        </div>
                        <button class="text-gray-400 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                    </div>
                    <button class="flex items-center gap-2 text-gray-300 hover:text-white text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        View All
                    </button>
                </div>

                <!-- Comments Card -->
                <div class="bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-cyan-100 text-sm font-medium">Comments</p>
                            <p class="text-3xl font-bold">{{ number_format($stats['comments']) }}</p>
                        </div>
                        <button class="text-cyan-200 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                    </div>
                    <button class="flex items-center gap-2 text-cyan-100 hover:text-white text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        View All
                    </button>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- User Stats Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">User Stat</h3>
                        <div class="flex items-center gap-4">
                            <button class="text-purple-600 font-semibold text-sm border-b-2 border-purple-600 pb-1">Month</button>
                            <button class="text-gray-400 text-sm">3 Month</button>
                            <button class="text-gray-400 text-sm">Year</button>
                        </div>
                    </div>
                    <div class="relative">
                        <canvas id="userStatsChart" width="400" height="200"></canvas>
                        <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            432 Users
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Statistics</h3>
                        <div class="flex items-center gap-4">
                            <button class="text-purple-600 font-semibold text-sm">Now</button>
                            <button class="text-gray-400 text-sm">Today</button>
                            <button class="text-gray-400 text-sm">Month</button>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <!-- Visitors -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Visitors</span>
                            <div class="flex items-center gap-3">
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                                <span class="bg-orange-500 text-white px-2 py-1 rounded text-xs font-bold">11k</span>
                            </div>
                        </div>

                        <!-- Subscriber -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Subscriber</span>
                            <div class="flex items-center gap-3">
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                                <span class="text-xs text-gray-500">60%</span>
                            </div>
                        </div>

                        <!-- Contributor -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Contributor</span>
                            <div class="flex items-center gap-3">
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-500 h-2 rounded-full" style="width: 45%"></div>
                                </div>
                                <span class="text-xs text-gray-500">45%</span>
                            </div>
                        </div>

                        <!-- Author -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Author</span>
                            <div class="flex items-center gap-3">
                                <div class="w-32 bg-gray-200 rounded-full h-2">
                                    <div class="bg-teal-500 h-2 rounded-full" style="width: 30%"></div>
                                </div>
                                <span class="text-xs text-gray-500">30%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Site Speed Chart -->
            <div class="mt-6 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Site Speed</h3>
                    <div class="flex items-center gap-4">
                        <button class="text-purple-600 font-semibold text-sm">Now</button>
                        <button class="text-gray-400 text-sm">Today</button>
                        <button class="text-gray-400 text-sm">Month</button>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="relative w-40 h-40">
                        <canvas id="siteSpeedChart" width="160" height="160"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-bold text-blue-600">631</span>
                            <span class="text-xs text-gray-500">ms</span>
                        </div>
                    </div>
                    <div class="flex-1 ml-8 grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">75</div>
                            <div class="text-xs text-gray-500">Grade</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">1.9 mb</div>
                            <div class="text-xs text-gray-500">Page Size</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">631 ms</div>
                            <div class="text-xs text-gray-500">Load Time</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">42</div>
                            <div class="text-xs text-gray-500">Requests</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Latest Events -->
        <div class="w-80">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Latest Events</h3>
                    <button class="text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    @foreach($events as $event)
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            @if($event['type'] == 'page')
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            @elseif($event['type'] == 'comment')
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            @elseif($event['type'] == 'user')
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            @else
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">{{ $event['time'] }}</span>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900 mb-1">{{ $event['title'] }}</h4>
                            <p class="text-xs text-gray-500 mb-1">{{ $event['user'] }}</p>
                            <p class="text-xs text-gray-600 leading-relaxed">{{ $event['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Stats Chart
    const ctx1 = document.getElementById('userStatsChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['1', '3', '5', '7', '9', '11', '13', '15', '17', '19', '21', '23', '25', '27', '29', '31'],
            datasets: [{
                data: [120, 180, 150, 200, 170, 190, 160, 210, 180, 220, 190, 240, 200, 180, 160, 190],
                backgroundColor: '#22C55E',
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    display: false,
                    grid: {
                        display: false
                    }
                },
                y: {
                    display: false,
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Site Speed Chart (Doughnut)
    const ctx2 = document.getElementById('siteSpeedChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [75, 25],
                backgroundColor: ['#3B82F6', '#E5E7EB'],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection