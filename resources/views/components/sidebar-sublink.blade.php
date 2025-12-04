@props(['route', 'label', 'activePattern' => null])

@php
    $isActive = request()->routeIs($activePattern ?? $route);
@endphp

<li>
    <a href="{{ route($route) }}" wire:navigate class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm leading-6 {{ $isActive ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }} transition-all duration-200">
        <span class="h-1.5 w-1.5 rounded-full {{ $isActive ? 'bg-indigo-600' : 'bg-slate-300 group-hover:bg-indigo-600' }}"></span>
        {{ $label }}
    </a>
</li>
