@php
  // Desktop
  $baseDesktop = 'block py-2 px-3 md:p-0 rounded md:bg-transparent';
  $activeDesktop = 'text-primary md:dark:text-primary-light';
  $inactiveDesktop = 'text-gray-700 hover:text-primary md:hover:text-primary dark:text-light dark:hover:text-primary-light md:dark:hover:bg-transparent';

  // Mobile
  $baseMobile = 'block py-2 px-3 rounded';
  $activeMobile = 'text-primary bg-gray-100 dark:text-primary-light dark:bg-dark';
  $inactiveMobile = 'text-gray-700 hover:bg-gray-100 dark:text-light dark:hover:text-primary-dark/50';
@endphp

<nav x-data="{ open: false }" class="bg-white dark:bg-dark fixed w-full z-20 top-0 left-0 border-b border-gray-100 dark:border-gray-600 shadow-md">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

    {{-- Logo --}}
    <a href="{{ route('umkm.home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
      <span class="self-center text-2xl font-semibold whitespace-nowrap text-primary dark:text-light">Sneaky</span>
    </a>

    {{-- Tombol CTA & Hamburger --}}
    <div class="flex md:order-2 items-center space-x-3 md:space-x-0 rtl:space-x-reverse">

      <div class="flex items-center gap-2">
        {{-- Hubungi Kami (Desktop) --}}
      <a href="{{ $linkWA ?? '#' }}" target="_blank" rel="noopener noreferrer"
        class="hidden md:inline-block text-dark bg-accent hover:brightness-90 focus:ring-4 h-fit focus:outline-none focus:ring-accent font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-accent dark:hover:brightness-90 dark:focus:ring-accent">
        Hubungi Kami
      </a>

      {{-- Icon Keranjang --}}
      <a href="{{ route('umkm.cart') }}" class="relative inline-flex items-center justify-center p-2 w-10 h-10 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-light dark:hover:bg-dark-light">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0h8m-8 0-1-4m9 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-9-4h10l2-7H3m2 7L3 4m0 0-.792-3H1"/>
        </svg>
        <span x-show="$store.cart.totalCount() > 0" x-text="$store.cart.totalCount()"
          class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-accent rounded-full"></span>
      </a>
      </div>

      {{-- Hamburger (Mobile) --}}
      <button @click="open = !open" type="button"
        class="inline-flex items-center p-2 w-10 h-10 text-sm text-primary rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-light dark:hover:bg-dark-light"
        :aria-expanded="open">
        <span class="sr-only">Open main menu</span>
        {{-- Icon Open/Close --}}
        <svg x-show="!open" class="w-5 h-5" fill="none" viewBox="0 0 17 14" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
        </svg>
        <svg x-show="open" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    {{-- Menu Desktop --}}
    <div class="hidden md:flex md:order-1 md:w-auto" id="navbar-menu-desktop">
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
        <li><a href="{{ route('umkm.home') }}" class="{{ $baseDesktop }} {{ request()->routeIs('umkm.home') ? $activeDesktop : $inactiveDesktop }}">Beranda</a></li>
        <li><a href="{{ route('umkm.product') }}" class="{{ $baseDesktop }} {{ request()->routeIs('umkm.product*') ? $activeDesktop : $inactiveDesktop }}">Produk</a></li>
        <li><a href="{{ route('umkm.about') }}" class="{{ $baseDesktop }} {{ request()->routeIs('umkm.about') ? $activeDesktop : $inactiveDesktop }}">Tentang Kami</a></li>
      </ul>
    </div>

  </div>

  {{-- Menu Mobile --}}
  <div x-show="open" x-transition class="md:hidden" id="navbar-menu-mobile">
    <ul class="flex flex-col p-4 font-medium bg-white dark:bg-dark border-t border-gray-200 dark:border-gray-600">
      <li><a href="{{ route('umkm.home') }}" class="{{ $baseMobile }} {{ request()->routeIs('umkm.home') ? $activeMobile : $inactiveMobile }}">Beranda</a></li>
      <li><a href="{{ route('umkm.product') }}" class="{{ $baseMobile }} {{ request()->routeIs('umkm.product*') ? $activeMobile : $inactiveMobile }}">Produk</a></li>
      <li><a href="{{ route('umkm.about') }}" class="{{ $baseMobile }} {{ request()->routeIs('umkm.about') ? $activeMobile : $inactiveMobile }}">Tentang Kami</a></li>
      <li><a href="{{ $linkWA ?? '#' }}" target="_blank" class="block w-full mt-2 text-dark bg-accent hover:brightness-90 focus:ring-4 focus:outline-none focus:ring-accent font-medium rounded-lg text-sm px-4 py-2 text-center">Hubungi Kami</a></li>
    </ul>
  </div>
</nav>

