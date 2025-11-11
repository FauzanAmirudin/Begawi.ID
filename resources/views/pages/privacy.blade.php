@extends('layouts.app')

@section('title', 'Kebijakan Privasi - Begawi.id')
@section('description', 'Kebijakan privasi dan perlindungan data pengguna Begawi.id. Kami berkomitmen melindungi privasi Anda.')

@section('content')
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-emerald-50 to-emerald-100">
        <div class="container mx-auto px-4 relative z-10 pt-24 md:pt-32">
            <div class="max-w-4xl mx-auto">
                <h1 class="font-manrope font-extrabold text-4xl md:text-5xl text-charcoal-grey mb-6">
                    Kebijakan Privasi
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Terakhir diperbarui: {{ date('d F Y') }}
                </p>
            </div>
        </div>
    </section>
    
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto prose prose-lg">
                <h2>1. Pengumpulan Informasi</h2>
                <p>Kami mengumpulkan informasi yang Anda berikan secara langsung saat menggunakan layanan kami.</p>
                
                <h2>2. Penggunaan Informasi</h2>
                <p>Informasi yang kami kumpulkan digunakan untuk menyediakan, memelihara, dan meningkatkan layanan kami.</p>
                
                <h2>3. Perlindungan Data</h2>
                <p>Kami menggunakan berbagai langkah keamanan untuk melindungi informasi pribadi Anda.</p>
                
                <h2>4. Cookie</h2>
                <p>Kami menggunakan cookie untuk meningkatkan pengalaman pengguna di website kami.</p>
                
                <h2>5. Hak Anda</h2>
                <p>Anda memiliki hak untuk mengakses, memperbarui, atau menghapus informasi pribadi Anda.</p>
                
                <h2>6. Kontak</h2>
                <p>Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan <a href="{{ route('contact') }}">hubungi kami</a>.</p>
            </div>
        </div>
    </section>
@endsection

