@php
// Desktop
$baseDesktop = 'block py-2 px-3 md:p-0 rounded md:bg-transparent liquid-underline font-medium';
$activeDesktop = 'text-emerald-600 transition-colors liquid-underline-active';
$inactiveDesktop = 'text-charcoal-grey hover:text-primary md:hover:text-primary';

// Mobile
$baseMobile = 'block py-2 px-3 rounded font-medium';
$activeMobile = 'text-emerald-600 transition-colors bg-gray-100';
$inactiveMobile = 'text-charcoal-grey hover:bg-gray-100';
@endphp


<nav x-data="{ open: false }" class="bg-white fixed w-full z-20 top-0 left-0 border-b border-gray-100 shadow-md">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

    {{-- Logo --}}
    <div class="flex items-center space-x-3">
      <img src="{{ asset('images/Logo-Begawi.png') }}" alt="Begawi.id" class="w-10 h-10 object-contain">
      <div class="font-manrope font-extrabold text-xl text-gradient">
        Begawi.id
      </div>
    </div>

    {{-- Tombol CTA & Hamburger --}}
    <div class="flex md:order-2 items-center space-x-3 md:space-x-0">

      <div class="flex items-center gap-2">
        {{-- Dashboard Admin UMKM (Desktop) --}}
        @auth
        @if(auth()->user()->role === \App\Models\User::ROLE_ADMIN_UMKM)
        <a href="{{ route('admin.dashboard.index') }}"
          class="hidden md:inline-flex items-center gap-2 text-white bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition-all shadow-md hover:shadow-lg">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
            </path>
          </svg>
          Dashboard
        </a>
        @endif
        @endauth

        {{-- Hubungi Kami (Desktop) --}}
        <a href="{{ $linkWA ?? '#' }}" target="_blank" rel="noopener noreferrer"
          class="hidden md:inline-block bg-gradient-accent text-white hover:brightness-90 focus:ring-4 h-fit focus:outline-none focus:ring-accent font-medium rounded-lg text-sm px-4 py-2 text-center">
          Hubungi Kami
        </a>

        {{-- Icon Keranjang --}}
        <a href="{{ route('umkm.cart') }}"
          class="relative inline-flex items-center justify-center p-1 w-10 h-10 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
          <img src="/images/Icon-Keranjang.png" alt="icon keranjang" srcset="" class="w-7">
          <span x-show="$store.cart.totalCount()> 0" x-text="$store.cart.totalCount()"
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-medium leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-primary-darker rounded-full"></span>
        </a>
      </div>

      {{-- Hamburger (Mobile) --}}
      <button @click="open = !open" type="button"
        class="inline-flex items-center p-2 w-10 h-10 text-sm text-primary rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
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
      <ul
        class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-white">
        <li>
          <a href="{{ route('umkm.home') }}"
            class="{{ $baseDesktop }} {{ request()->routeIs('umkm.home') ? $activeDesktop : $inactiveDesktop }}">
            Beranda
          </a>
        </li>
        <li>
          <a href="{{ route('umkm.product') }}"
            class="{{ $baseDesktop }} {{ request()->routeIs('umkm.product*') ? $activeDesktop : $inactiveDesktop }}">
            Produk
          </a>
        </li>
        <li>
          <a href="{{ route('umkm.about') }}"
            class="{{ $baseDesktop }} {{ request()->routeIs('umkm.about') ? $activeDesktop : $inactiveDesktop }}">
            Tentang Kami
          </a>
        </li>
      </ul>
    </div>

  </div>

  {{-- Menu Mobile --}}
  <div x-show="open" x-transition class="md:hidden" id="navbar-menu-mobile">
    <ul class="flex flex-col p-4 font-medium bg-white border-t border-gray-200">
      <li>
        <a href="{{ route('umkm.home') }}"
          class="{{ $baseMobile }} {{ request()->routeIs('umkm.home') ? $activeMobile : $inactiveMobile }}">
          Beranda
        </a>
      </li>
      <li>
        <a href="{{ route('umkm.product') }}"
          class="{{ $baseMobile }} {{ request()->routeIs('umkm.product*') ? $activeMobile : $inactiveMobile }}">
          Produk
        </a>
      </li>
      <li>
        <a href="{{ route('umkm.about') }}"
          class="{{ $baseMobile }} {{ request()->routeIs('umkm.about') ? $activeMobile : $inactiveMobile }}">
          Tentang Kami
        </a>
      </li>
      {{-- Dashboard Admin UMKM (Mobile) --}}
      @auth
      @if(auth()->user()->role === \App\Models\User::ROLE_ADMIN_UMKM)
      <li>
        <a href="{{ route('admin.dashboard.index') }}"
          class="flex items-center gap-2 w-full mt-2 text-white justify-center bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition-all shadow-md hover:shadow-lg">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
            </path>
          </svg>
          Dashboard Admin
        </a>
      </li>
      @endif
      @endauth

      <li><a href="{{ $linkWA ?? '#' }}" target="_blank"
          class="block w-full mt-2 text-white bg-gradient-accent hover:brightness-90 focus:ring-4 focus:outline-none focus:ring-accent font-medium rounded-lg text-sm px-4 py-2 text-center">Hubungi
          Kami</a></li>
    </ul>
  </div>
</nav>