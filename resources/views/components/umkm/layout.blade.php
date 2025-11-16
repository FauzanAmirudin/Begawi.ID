<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  {{-- Judul halaman dinamis --}}
  <title>{{ $title ?? 'Selamat Datang' }}</title>
  <link rel="shortcut icon" href="/images/Logo-Begawi.png" type="image/x-icon">

  {{-- Memuat CSS/JS (Tailwind + Alpine.js) --}}
  @vite(['resources/css/umkm.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body class="bg-warm-ivory font-sans antialiased">

  {{-- Navbar persisten --}}
  <x-umkm.navbar :linkWA="$linkWA"/>

  {{-- Konten utama --}}
  <main class="pt-16"> {{-- padding-top untuk menghindari tumpang tindih dengan navbar --}}
    {{ $slot }}
  </main>

  {{-- Footer (opsional) --}}
  <x-umkm.footer :socials="$socials"/>

</body>

</html>

