@php
    $styles = [
        'desa' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'path' => 'M3 12l2-2 7-7 7 7 2 2M5 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0h6'],
        'umkm' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'path' => 'M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6'],
        'transaction' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'path' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        'content' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'path' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.59a1 1 0 01.7.29l5.41 5.42a1 1 0 01.29.7V19a2 2 0 01-2 2z'],
        'umkm_activity' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'path' => 'M4 6h16M16 10h4M4 10h8m4 4h4M4 14h8m4 4h4M4 18h8'],
        'product_update' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'path' => 'M4 9l1 9a2 2 0 002 2h10a2 2 0 002-2l1-9M5 9h14l-1.5-4.5A1 1 0 0016.57 4H7.43a1 1 0 00-.93.6L5 9zm4 4h6'],
        'default' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'path' => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z'],
    ];

    $style = $styles[$type] ?? $styles['default'];
@endphp

<div class="w-8 h-8 {{ $style['bg'] }} rounded-lg flex items-center justify-center">
    <svg class="w-4 h-4 {{ $style['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $style['path'] }}"></path>
    </svg>
</div>
