@extends('layouts.app')

@section('title', 'Hubungi Kami - Begawi.id')
@section('description', 'Hubungi tim Begawi.id untuk pertanyaan, konsultasi, atau dukungan. Kami siap membantu digitalisasi desa dan UMKM Anda.')

@section('content')
    <!-- Hero Section -->
    <section class="pt-24 pb-12 bg-gradient-to-br from-emerald-50 to-emerald-100 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl animate-float" style="animation-delay: -2s;"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="font-manrope font-extrabold text-4xl md:text-6xl text-charcoal-grey mb-6">
                    Hubungi Kami
                    <span class="text-gradient">📧</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Ada pertanyaan? Ingin konsultasi? Atau butuh bantuan? Tim kami siap membantu Anda 24/7
                </p>
            </div>
        </div>
    </section>
    
    <!-- Contact Form Section -->
    <section class="py-20 bg-gradient-to-br from-emerald-50 via-white to-emerald-100">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-4">
                        Kirim Pesan kepada Kami
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Isi form di bawah ini dan kami akan merespons secepat mungkin
                    </p>
                </div>
                
                <!-- Contact Form -->
                <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
                    <form id="contactForm" class="space-y-6">
                        @csrf
                        
                        <!-- Row 1: Name, Email, Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Name Field -->
                            <div class="form-group">
                                <label for="name" class="block text-sm font-semibold text-charcoal-grey mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        required
                                        class="w-full px-4 py-3 pl-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                        placeholder="Masukkan nama Anda"
                                    >
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-xl" id="nameEmoji">👤</span>
                                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-xl hidden" id="nameStatus"></span>
                                </div>
                                <p class="text-xs text-red-500 mt-1 hidden" id="nameError"></p>
                            </div>
                            
                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="email" class="block text-sm font-semibold text-charcoal-grey mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        required
                                        class="w-full px-4 py-3 pl-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                        placeholder="nama@email.com"
                                    >
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-xl" id="emailEmoji">📧</span>
                                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-xl hidden" id="emailStatus"></span>
                                </div>
                                <p class="text-xs text-red-500 mt-1 hidden" id="emailError"></p>
                            </div>
                            
                            <!-- Phone Field -->
                            <div class="form-group">
                                <label for="phone" class="block text-sm font-semibold text-charcoal-grey mb-2">
                                    No. Telepon
                                </label>
                                <div class="relative">
                                    <input 
                                        type="tel" 
                                        id="phone" 
                                        name="phone"
                                        class="w-full px-4 py-3 pl-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                        placeholder="08xx xxxx xxxx"
                                    >
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-xl" id="phoneEmoji">📱</span>
                                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-xl hidden" id="phoneStatus"></span>
                                </div>
                                <p class="text-xs text-red-500 mt-1 hidden" id="phoneError"></p>
                            </div>
                        </div>
                        
                        <!-- Subject Field -->
                        <div class="form-group">
                            <label for="subject" class="block text-sm font-semibold text-charcoal-grey mb-2">
                                Subjek <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="subject" 
                                    name="subject" 
                                    required
                                    class="w-full px-4 py-3 pl-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                    placeholder="Apa yang ingin Anda tanyakan?"
                                >
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-xl" id="subjectEmoji">💬</span>
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-xl hidden" id="subjectStatus"></span>
                            </div>
                            <p class="text-xs text-red-500 mt-1 hidden" id="subjectError"></p>
                        </div>
                        
                        <!-- Message Field -->
                        <div class="form-group">
                            <label for="message" class="block text-sm font-semibold text-charcoal-grey mb-2">
                                Pesan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea 
                                    id="message" 
                                    name="message" 
                                    required
                                    rows="6"
                                    class="w-full px-4 py-3 pl-12 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none"
                                    placeholder="Tulis pesan Anda di sini..."
                                ></textarea>
                                <span class="absolute left-4 top-4 text-xl" id="messageEmoji">✍️</span>
                                <span class="absolute right-4 top-4 text-xl hidden" id="messageStatus"></span>
                            </div>
                            <p class="text-xs text-red-500 mt-1 hidden" id="messageError"></p>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="text-center pt-4">
                            <button 
                                type="submit" 
                                id="submitBtn"
                                class="inline-flex items-center px-12 py-5 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white font-poppins font-bold text-xl rounded-2xl hover-glow transition-all transform hover:scale-105 shadow-xl"
                            >
                                <span class="mr-3 text-2xl">🚀</span>
                                Kirim Pesan Sekarang
                                <svg class="ml-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Success Message (Hidden by default) -->
                    <div id="successMessage" class="hidden mt-8 p-6 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-2xl text-center">
                        <div class="text-4xl mb-4">🎉</div>
                        <h3 class="font-poppins font-bold text-2xl mb-2">Pesan Terkirim!</h3>
                        <p class="text-lg">Terima kasih! Kami akan menghubungi Anda segera.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Office Location Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-4">
                    Lokasi Kantor Kami
                    <span class="text-gradient">📍</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Kunjungi kantor kami atau hubungi melalui peta interaktif di bawah ini
                </p>
            </div>
            
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Map Container -->
                    <div class="lg:col-span-2">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl" style="height: 500px;">
                            <!-- Google Maps Embed -->
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.9044!2d106.8164!3d-6.2088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMzEuNiJTIDEwNsKwNDknMDkuMSJF!5e0!3m2!1sen!2sid!4v1234567890"
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                class="w-full h-full"
                            ></iframe>
                            
                            <!-- Pulsing Pin Animation -->
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none">
                                <div class="relative">
                                    <!-- Outer pulse -->
                                    <div class="absolute inset-0 bg-emerald-500 rounded-full animate-ping opacity-75" style="width: 60px; height: 60px; animation-duration: 2s;"></div>
                                    <!-- Middle pulse -->
                                    <div class="absolute inset-0 bg-emerald-500 rounded-full animate-ping opacity-50" style="width: 40px; height: 40px; animation-delay: 0.5s; animation-duration: 2s;"></div>
                                    <!-- Inner pin -->
                                    <div class="relative bg-emerald-600 rounded-full flex items-center justify-center" style="width: 30px; height: 30px;">
                                        <span class="text-white text-lg">📍</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Box -->
                    <div class="lg:col-span-1">
                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl p-8 shadow-xl h-full">
                            <h3 class="font-poppins font-bold text-2xl text-charcoal-grey mb-6">
                                Informasi Kontak
                            </h3>
                            
                            <div class="space-y-6">
                                <!-- Address -->
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <span class="text-2xl">🏢</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-charcoal-grey mb-1">Alamat</h4>
                                        <p class="text-gray-600 text-sm leading-relaxed">
                                            Jl. Sudirman No. 123<br>
                                            Jakarta Pusat 10220<br>
                                            Indonesia
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Phone -->
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <span class="text-2xl">📞</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-charcoal-grey mb-1">Telepon</h4>
                                        <p class="text-gray-600 text-sm">
                                            <a href="tel:+6281234567890" class="hover:text-emerald-600 transition-colors">
                                                +62 812 3456 7890
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Email -->
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <span class="text-2xl">✉️</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-charcoal-grey mb-1">Email</h4>
                                        <p class="text-gray-600 text-sm">
                                            <a href="mailto:info@begawi.id" class="hover:text-emerald-600 transition-colors">
                                                info@begawi.id
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Office Hours -->
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <span class="text-2xl">🕐</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-charcoal-grey mb-1">Jam Operasional</h4>
                                        <p class="text-gray-600 text-sm">
                                            Senin - Jumat: 09:00 - 18:00 WIB<br>
                                            Sabtu: 09:00 - 13:00 WIB<br>
                                            Minggu: Tutup
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Google Maps Link -->
                                <div class="pt-4">
                                    <a 
                                        href="https://www.google.com/maps?q=-6.2088,106.8164" 
                                        target="_blank"
                                        class="inline-flex items-center w-full justify-center px-6 py-3 bg-gradient-accent text-white font-semibold rounded-xl hover-glow transition-all"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Buka di Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Social Media Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-manrope font-extrabold text-3xl md:text-4xl text-charcoal-grey mb-4">
                    Ikuti Kami di Media Sosial
                    <span class="text-gradient">🔗</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Dapatkan update terbaru, tips, dan konten eksklusif dari kami
                </p>
            </div>
            
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <!-- Instagram -->
                    <a 
                        href="https://instagram.com/begawi.id" 
                        target="_blank"
                        class="group relative bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl p-8 text-center transition-all transform hover:scale-105 shadow-lg social-glow"
                    >
                        <div class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <div class="text-5xl mb-4">📷</div>
                            <h3 class="font-poppins font-bold text-white text-lg mb-2">Instagram</h3>
                            <p class="text-white/80 text-sm">@begawi.id</p>
                            <div class="mt-4 text-white/60 text-xs group-hover:text-white transition-colors">
                                Ikuti kami →
                            </div>
                        </div>
                    </a>
                    
                    <!-- Facebook -->
                    <a 
                        href="https://facebook.com/begawi.id" 
                        target="_blank"
                        class="group relative bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl p-8 text-center transition-all transform hover:scale-105 shadow-lg social-glow"
                    >
                        <div class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <div class="text-5xl mb-4">👥</div>
                            <h3 class="font-poppins font-bold text-white text-lg mb-2">Facebook</h3>
                            <p class="text-white/80 text-sm">Begawi.id</p>
                            <div class="mt-4 text-white/60 text-xs group-hover:text-white transition-colors">
                                Ikuti kami →
                            </div>
                        </div>
                    </a>
                    
                    <!-- Twitter -->
                    <a 
                        href="https://twitter.com/begawi_id" 
                        target="_blank"
                        class="group relative bg-gradient-to-br from-emerald-500 to-emerald-400 rounded-2xl p-8 text-center transition-all transform hover:scale-105 shadow-lg social-glow"
                    >
                        <div class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <div class="text-5xl mb-4">🐦</div>
                            <h3 class="font-poppins font-bold text-white text-lg mb-2">Twitter</h3>
                            <p class="text-white/80 text-sm">@begawi_id</p>
                            <div class="mt-4 text-white/60 text-xs group-hover:text-white transition-colors">
                                Ikuti kami →
                            </div>
                        </div>
                    </a>
                    
                    <!-- YouTube -->
                    <a 
                        href="https://youtube.com/@begawi" 
                        target="_blank"
                        class="group relative bg-gradient-to-br from-red-600 to-red-700 rounded-2xl p-8 text-center transition-all transform hover:scale-105 shadow-lg social-glow"
                    >
                        <div class="absolute inset-0 bg-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <div class="text-5xl mb-4">📺</div>
                            <h3 class="font-poppins font-bold text-white text-lg mb-2">YouTube</h3>
                            <p class="text-white/80 text-sm">Begawi Channel</p>
                            <div class="mt-4 text-white/60 text-xs group-hover:text-white transition-colors">
                                Subscribe →
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Instagram Feed Section (in footer area) -->
    <section class="py-16 bg-charcoal-grey text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-manrope font-extrabold text-2xl md:text-3xl mb-4">
                    Ikuti Perjalanan Kami di Instagram
                    <span class="text-gradient bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">📸</span>
                </h2>
                <p class="text-gray-300 max-w-2xl mx-auto">
                    Lihat update terbaru dari komunitas Begawi.id
                </p>
            </div>
            
            <!-- Instagram Feed Grid -->
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4" id="instagramFeed">
                    <!-- Placeholder for Instagram posts -->
                    <!-- These will be populated via JavaScript or API -->
                    @for($i = 1; $i <= 6; $i++)
                    <div class="relative group cursor-pointer">
                        <div class="aspect-square bg-gradient-to-br from-pink-500/20 to-purple-600/20 rounded-xl overflow-hidden">
                            <div class="w-full h-full flex items-center justify-center text-4xl">
                                📷
                            </div>
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="text-white font-semibold">Lihat Post</span>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
                
                <!-- Follow Button -->
                <div class="text-center mt-8">
                    <a 
                        href="https://instagram.com/begawi.id" 
                        target="_blank"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold rounded-xl hover-glow transition-all"
                    >
                        <span class="mr-2">📷</span>
                        Ikuti @begawi.id di Instagram
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* Custom animations for form validation */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
    
    .shake {
        animation: shake 0.5s;
    }
    
    /* Glow effect for social media */
    .social-glow {
        box-shadow: 0 0 20px rgba(46, 204, 113, 0.3);
    }
    
    .social-glow:hover {
        box-shadow: 0 0 40px rgba(46, 204, 113, 0.6);
    }
    
    /* Pulsing pin animation */
    @keyframes pulse-pin {
        0%, 100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 0.7;
        }
    }
    
    .pulse-pin {
        animation: pulse-pin 2s ease-in-out infinite;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');
    
    // Real-time validation with emoji indicators
    const fields = {
        name: { emoji: 'nameEmoji', status: 'nameStatus', error: 'nameError', input: 'name' },
        email: { emoji: 'emailEmoji', status: 'emailStatus', error: 'emailError', input: 'email' },
        phone: { emoji: 'phoneEmoji', status: 'phoneStatus', error: 'phoneError', input: 'phone' },
        subject: { emoji: 'subjectEmoji', status: 'subjectStatus', error: 'subjectError', input: 'subject' },
        message: { emoji: 'messageEmoji', status: 'messageStatus', error: 'messageError', input: 'message' }
    };
    
    // Validation functions
    function validateName(value) {
        if (value.length < 2) return { valid: false, message: 'Nama minimal 2 karakter' };
        return { valid: true };
    }
    
    function validateEmail(value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) return { valid: false, message: 'Format email tidak valid' };
        return { valid: true };
    }
    
    function validatePhone(value) {
        if (value && value.length < 10) return { valid: false, message: 'Nomor telepon minimal 10 digit' };
        return { valid: true };
    }
    
    function validateSubject(value) {
        if (value.length < 5) return { valid: false, message: 'Subjek minimal 5 karakter' };
        return { valid: true };
    }
    
    function validateMessage(value) {
        if (value.length < 10) return { valid: false, message: 'Pesan minimal 10 karakter' };
        return { valid: true };
    }
    
    const validators = {
        name: validateName,
        email: validateEmail,
        phone: validatePhone,
        subject: validateSubject,
        message: validateMessage
    };
    
    // Real-time validation
    Object.keys(fields).forEach(fieldName => {
        const field = fields[fieldName];
        const input = document.getElementById(field.input);
        const emojiEl = document.getElementById(field.emoji);
        const statusEl = document.getElementById(field.status);
        const errorEl = document.getElementById(field.error);
        
        input.addEventListener('input', function() {
            const value = this.value.trim();
            const validator = validators[fieldName];
            
            if (fieldName === 'phone' && !value) {
                // Phone is optional
                statusEl.classList.add('hidden');
                errorEl.classList.add('hidden');
                input.classList.remove('border-red-500', 'border-green-500');
                return;
            }
            
            if (value) {
                const result = validator(value);
                
                if (result.valid) {
                    // Valid
                    statusEl.textContent = '✅';
                    statusEl.classList.remove('hidden');
                    errorEl.classList.add('hidden');
                    input.classList.remove('border-red-500', 'shake');
                    input.classList.add('border-green-500');
                    emojiEl.style.opacity = '1';
                } else {
                    // Invalid
                    statusEl.textContent = '❌';
                    statusEl.classList.remove('hidden');
                    errorEl.textContent = result.message;
                    errorEl.classList.remove('hidden');
                    input.classList.remove('border-green-500');
                    input.classList.add('border-red-500', 'shake');
                    emojiEl.style.opacity = '0.5';
                }
            } else {
                // Empty
                statusEl.classList.add('hidden');
                errorEl.classList.add('hidden');
                input.classList.remove('border-red-500', 'border-green-500');
                emojiEl.style.opacity = '1';
            }
        });
        
        input.addEventListener('blur', function() {
            if (!this.value.trim() && fieldName !== 'phone') {
                input.classList.add('shake');
            }
        });
    });
    
    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="mr-2">⏳</span>Mengirim...';
        
        // Get form data
        const formData = new FormData(form);
        
        try {
            const response = await fetch('{{ route("contact.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Show success message
                form.classList.add('hidden');
                successMessage.classList.remove('hidden');
                
                // Confetti animation
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 }
                });
                
                // Additional confetti bursts
                setTimeout(() => {
                    confetti({
                        particleCount: 50,
                        angle: 60,
                        spread: 55,
                        origin: { x: 0 }
                    });
                    confetti({
                        particleCount: 50,
                        angle: 120,
                        spread: 55,
                        origin: { x: 1 }
                    });
                }, 300);
            } else {
                alert('Terjadi kesalahan. Silakan coba lagi.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span class="mr-3 text-2xl">🚀</span>Kirim Pesan Sekarang<svg class="ml-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span class="mr-3 text-2xl">🚀</span>Kirim Pesan Sekarang<svg class="ml-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>';
        }
    });
    
    // Instagram feed (placeholder - would need actual API integration)
    // This is a placeholder implementation
    function loadInstagramFeed() {
        // In a real implementation, you would fetch from Instagram API
        // For now, we'll just animate the placeholder items
        const feedItems = document.querySelectorAll('#instagramFeed > div');
        feedItems.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add('animate-fadeInUp');
            }, index * 100);
        });
    }
    
    loadInstagramFeed();
});
</script>
@endpush

