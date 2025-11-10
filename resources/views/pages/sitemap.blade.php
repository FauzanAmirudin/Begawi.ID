@extends('layouts.app')

@section('title', 'Sitemap - Begawi.id')
@section('description', 'Peta situs Begawi.id. Temukan semua halaman dan fitur yang tersedia.')

@section('content')
    <section class="pt-24 pb-12 bg-gradient-to-br from-emerald-50 to-emerald-100">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="font-manrope font-extrabold text-4xl md:text-5xl text-charcoal-grey mb-6">
                    Sitemap
                </h1>
                <p class="text-xl text-gray-600">
                    Navigasi lengkap semua halaman di Begawi.id
                </p>
            </div>
        </div>
    </section>
    
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Main Pages -->
                    <div>
                        <h2 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">Halaman Utama</h2>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-emerald-600 hover:underline">Beranda</a></li>
                            <li><a href="{{ route('templates') }}" class="text-emerald-600 hover:underline">Template & Fitur</a></li>
                            <li><a href="{{ route('directory') }}" class="text-emerald-600 hover:underline">Direktori</a></li>
                            <li><a href="{{ route('about') }}" class="text-emerald-600 hover:underline">Tentang Kami</a></li>
                            <li><a href="{{ route('education') }}" class="text-emerald-600 hover:underline">Edukasi</a></li>
                            <li><a href="{{ route('contact') }}" class="text-emerald-600 hover:underline">Kontak</a></li>
                        </ul>
                    </div>
                    
                    <!-- Legal Pages -->
                    <div>
                        <h2 class="font-poppins font-bold text-2xl text-charcoal-grey mb-4">Informasi Legal</h2>
                        <ul class="space-y-2">
                            <li><a href="{{ route('privacy') }}" class="text-emerald-600 hover:underline">Kebijakan Privasi</a></li>
                            <li><a href="{{ route('terms') }}" class="text-emerald-600 hover:underline">Syarat & Ketentuan</a></li>
                            <li><a href="{{ route('sitemap') }}" class="text-emerald-600 hover:underline">Sitemap</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

