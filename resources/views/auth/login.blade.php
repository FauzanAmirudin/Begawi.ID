@extends('layouts.app')

@section('title', 'Masuk ke Begawi.id')
@section('description', 'Masuk untuk mengelola platform Begawi.id sebagai Super Admin, Admin Desa, atau Admin UMKM.')

@section('content')
<section class="pt-32 pb-24 bg-gradient-to-br from-emerald-50 via-white to-emerald-100">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold mb-4">
                    Selamat Datang Kembali
                </span>
                <h1 class="font-manrope font-extrabold text-4xl text-charcoal-grey mb-6">
                    Kelola Ekosistem Digital Anda
                </h1>
                <p class="text-gray-600 leading-relaxed mb-8">
                    Masuk sebagai Super Admin, Admin Desa, atau Admin UMKM untuk mengelola website, konten, dan statistik digitalisasi dari satu dashboard terpadu.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start gap-3 text-gray-600">
                        <span class="mt-1 w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-sm font-bold">1</span>
                        <div>
                            <h3 class="font-semibold text-lg text-charcoal-grey">Super Admin</h3>
                            <p class="text-sm">Mengatur konfigurasi platform, domain, keuangan, dan log aktivitas secara menyeluruh.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 text-gray-600">
                        <span class="mt-1 w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-sm font-bold">2</span>
                        <div>
                            <h3 class="font-semibold text-lg text-charcoal-grey">Admin Desa</h3>
                            <p class="text-sm">Kelola konten desa, produk UMKM binaan, serta laporan digitalisasi wilayah.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 text-gray-600">
                        <span class="mt-1 w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-sm font-bold">3</span>
                        <div>
                            <h3 class="font-semibold text-lg text-charcoal-grey">Admin UMKM</h3>
                            <p class="text-sm">Perbarui profil usaha, kelola produk, promosi, dan respon pelanggan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 p-8">
                    <h2 class="text-2xl font-semibold text-charcoal-grey mb-6">Masuk ke Dashboard</h2>

                    @if (session('status'))
                        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->login->any())
                        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-600 px-4 py-3 text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->login->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition"
                                placeholder="you@example.com"
                            >
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Kata Sandi
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition"
                                placeholder="Masukkan kata sandi"
                            >
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center text-sm text-gray-600">
                                <input type="checkbox" name="remember" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <span class="ml-2">Ingat saya</span>
                            </label>
                            <a href="#" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                                Lupa kata sandi?
                            </a>
                        </div>

                        <button
                            type="submit"
                            class="w-full inline-flex justify-center items-center gap-2 px-6 py-3 bg-gradient-accent text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition duration-200"
                        >
                            <span>Masuk</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm text-gray-500">
                        Butuh akses akun? Hubungi Super Admin Begawi.id untuk pembuatan akun baru.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

