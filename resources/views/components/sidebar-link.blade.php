@props(['route', 'label', 'activePattern' => null])

@php
    $pattern = $activePattern ?? $route;
    $isActive = request()->routeIs($pattern);
    $classes = $isActive 
        ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' 
        : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50';
    $iconClasses = $isActive 
        ? 'text-indigo-600' 
        : 'text-slate-400 group-hover:text-slate-600';
@endphp

<a href="{{ route($route) }}" wire:navigate {{ $attributes->merge(['class' => "$classes group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200 items-center"]) }}>
    <svg class="{{ $iconClasses }} h-5 w-5 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        {!! $icon !!}
    </svg>
    {{ $label }}
</a>
