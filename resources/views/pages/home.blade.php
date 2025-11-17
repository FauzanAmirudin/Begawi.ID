@extends('layouts.app')

@section('title', 'Begawi.id - Platform Website Instan untuk Desa & UMKM Indonesia')
@section('description', 'Platform pembuat website instan berbasis lokal untuk UMKM dan lembaga desa. Tanpa keahlian teknis, tanpa biaya besar. Mulai digitalisasi dari Begawi.id')

@section('content')
<!-- Hero Section -->
@include('components.hero-section')

<!-- Stats Section -->
@include('components.stats-section')

<!-- Features Timeline Section -->
<section class="py-20 bg-gradient-to-br from-emerald-50 to-emerald-100 relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="font-manrope font-extrabold text-4xl md:text-5xl text-charcoal-grey mb-4">
                Mengapa Memilih
                <span class="text-gradient">Begawi.id?</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Platform yang dirancang khusus untuk kebutuhan digitalisasi Indonesia
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            <!-- Timeline -->
            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-emerald-500 to-emerald-300 rounded-full"></div>

                <!-- Timeline Items -->
                <div class="space-y-16">
                    <!-- Item 1 -->
                    <div class="flex flex-col lg:flex-row items-center">
                        <div class="lg:w-1/2 lg:pr-12 mb-8 lg:mb-0">
                            <div class="bg-white rounded-2xl p-8 shadow-xl hover-tilt">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mr-4">
                                        <span class="text-white font-bold">1</span>
                                    </div>
                                    <h3 class="font-poppins font-bold text-2xl text-charcoal-grey">Mudah Digunakan</h3>
                                </div>
                                <p class="text-gray-600 leading-relaxed mb-6">
                                    Interface drag-and-drop yang intuitif. Tidak perlu coding atau keahlian teknis. Siapapun bisa membuat website profesional dalam hitungan menit.
                                </p>
                                <ul class="space-y-2 text-sm text-gray-500">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Visual Editor
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        One-Click Setup
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Tutorial Lengkap
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="lg:w-1/2 lg:pl-12">
                            <div class="relative">
                                <img src="{{ asset('images/web-1.png') }}" alt="Easy to Use" class="w-full rounded-2xl shadow-2xl">
                                <div class="absolute inset-0 bg-gradient-to-tr from-emerald-600/20 to-transparent rounded-2xl"></div>
                            </div>
                        </div>
                        <!-- Timeline Dot -->
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-emerald-500 rounded-full border-4 border-white shadow-lg"></div>
                    </div>

                    <!-- Item 2 -->
                    <div class="flex flex-col lg:flex-row-reverse items-center">
                        <div class="lg:w-1/2 lg:pl-12 mb-8 lg:mb-0">
                            <div class="bg-white rounded-2xl p-8 shadow-xl hover-tilt">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4">
                                        <span class="text-white font-bold">2</span>
                                    </div>
                                    <h3 class="font-poppins font-bold text-2xl text-charcoal-grey">Fokus Lokal</h3>
                                </div>
                                <p class="text-gray-600 leading-relaxed mb-6">
                                    Template dan fitur yang disesuaikan dengan kebutuhan desa dan UMKM Indonesia. Mendukung bahasa lokal dan budaya setempat.
                                </p>
                                <ul class="space-y-2 text-sm text-gray-500">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Template Khusus Indonesia
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Dukungan Bahasa Daerah
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Integrasi Payment Lokal
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="lg:w-1/2 lg:pr-12">
                            <div class="relative">
                                <img src="{{ asset('images/web-2.png') }}" alt="Local Focus" class="w-full rounded-2xl shadow-2xl">
                                <div class="absolute inset-0 bg-gradient-to-tr from-emerald-600/20 to-transparent rounded-2xl"></div>
                            </div>
                        </div>
                        <!-- Timeline Dot -->
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-emerald-500 rounded-full border-4 border-white shadow-lg"></div>
                    </div>

                    <!-- Item 3 -->
                    <div class="flex flex-col lg:flex-row items-center">
                        <div class="lg:w-1/2 lg:pr-12 mb-8 lg:mb-0">
                            <div class="bg-white rounded-2xl p-8 shadow-xl hover-tilt">
                                <div class="flex items-center mb-6">
                                    <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mr-4">
                                        <span class="text-white font-bold">3</span>
                                    </div>
                                    <h3 class="font-poppins font-bold text-2xl text-charcoal-grey">Gratis Selamanya</h3>
                                </div>
                                <p class="text-gray-600 leading-relaxed mb-6">
                                    Komitmen kami untuk mendukung digitalisasi Indonesia. Fitur dasar gratis selamanya, upgrade premium dengan harga terjangkau.
                                </p>
                                <ul class="space-y-2 text-sm text-gray-500">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Website Gratis Selamanya
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Hosting Reliable
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Support 24/7
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="lg:w-1/2 lg:pl-12">
                            <div class="relative">
                                <img src="{{ asset('images/web-3.png') }}" alt="Free Forever" class="w-full rounded-2xl shadow-2xl">
                                <div class="absolute inset-0 bg-gradient-to-tr from-purple-600/20 to-transparent rounded-2xl"></div>
                            </div>
                        </div>
                        <!-- Timeline Dot -->
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-purple-500 rounded-full border-4 border-white shadow-lg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
@include('components.testimonial-section')

<!-- Quick Actions Section -->
@include('components.quick-actions')

@endsection

@push('scripts')
<script>
    // Initialize homepage specific functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Animate timeline items on scroll
        const timelineItems = document.querySelectorAll('.timeline-item');
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px 0px -100px 0px'
        };

        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                }
            });
        }, observerOptions);

        timelineItems.forEach(item => {
            timelineObserver.observe(item);
        });
    });
</script>
@endpush