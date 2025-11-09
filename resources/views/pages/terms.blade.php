@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - Begawi.id')
@section('description', 'Syarat dan ketentuan penggunaan platform Begawi.id. Baca sebelum menggunakan layanan kami.')

@section('content')
    <section class="pt-24 pb-12 bg-gradient-to-br from-blue-50 to-emerald-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h1 class="font-manrope font-extrabold text-4xl md:text-5xl text-charcoal-grey mb-6">
                    Syarat & Ketentuan
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
                <h2>1. Penerimaan Syarat</h2>
                <p>Dengan mengakses dan menggunakan platform Begawi.id, Anda menyetujui untuk terikat oleh syarat dan ketentuan ini.</p>
                
                <h2>2. Penggunaan Layanan</h2>
                <p>Anda setuju untuk menggunakan layanan kami hanya untuk tujuan yang sah dan sesuai dengan ketentuan yang berlaku.</p>
                
                <h2>3. Akun Pengguna</h2>
                <p>Anda bertanggung jawab untuk menjaga kerahasiaan informasi akun Anda.</p>
                
                <h2>4. Konten</h2>
                <p>Anda mempertahankan kepemilikan atas konten yang Anda unggah, namun memberikan kami lisensi untuk menggunakannya.</p>
                
                <h2>5. Pembatasan Tanggung Jawab</h2>
                <p>Kami tidak bertanggung jawab atas kerugian yang timbul dari penggunaan layanan kami.</p>
                
                <h2>6. Perubahan Syarat</h2>
                <p>Kami berhak mengubah syarat dan ketentuan ini kapan saja tanpa pemberitahuan sebelumnya.</p>
            </div>
        </div>
    </section>
@endsection

