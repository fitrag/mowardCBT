@props(['label', 'activePattern' => null])

@php
    $isActive = false;
    if ($activePattern) {
        // Support multiple patterns separated by |
        $patterns = explode('|', $activePattern);
        foreach ($patterns as $pattern) {
            if (request()->routeIs(trim($pattern))) {
                $isActive = true;
                break;
            }
        }
    }
@endphp

<li x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">
    <button @click="open = !open" class="group flex w-full items-center justify-between gap-x-3 rounded-lg px-3 py-2 text-sm font-semibold leading-6 {{ $isActive ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' }} transition-all duration-200">
        <div class="flex items-center gap-x-3">
            <svg class="h-5 w-5 shrink-0 {{ $isActive ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                {{ $icon }}
            </svg>
            <span>{{ $label }}</span>
        </div>
        <svg class="h-4 w-4 transition-transform duration-200 {{ $isActive ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600' }}" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </button>
    
    <ul x-show="open" x-collapse class="mt-1 space-y-1 pl-9">
        {{ $slot }}
    </ul>
</li>
