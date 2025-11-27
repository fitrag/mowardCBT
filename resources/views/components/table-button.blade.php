@props(['type' => 'button', 'color' => 'indigo'])

@php
    $colors = [
        'indigo' => 'text-indigo-700 bg-indigo-50 hover:bg-indigo-100 focus:ring-indigo-500',
        'red' => 'text-red-700 bg-red-50 hover:bg-red-100 focus:ring-red-500',
        'slate' => 'text-slate-700 bg-slate-50 hover:bg-slate-100 focus:ring-slate-500',
        'emerald' => 'text-emerald-700 bg-emerald-50 hover:bg-emerald-100 focus:ring-emerald-500',
    ];
    $classes = $colors[$color] ?? $colors['indigo'];
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => "inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 $classes"]) }}>
    {{ $slot }}
</button>
