@props(['checked' => false])

<div class="relative inline-flex items-center">
    <input 
        type="checkbox" 
        {{ $attributes->merge(['class' => 'peer h-5 w-5 shrink-0 appearance-none rounded-md border-2 border-slate-300 bg-white transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 hover:border-indigo-400 checked:border-indigo-600 checked:bg-indigo-600 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50 shadow-sm hover:shadow-md']) }}
        @if($checked) checked @endif
    >
    <svg class="absolute left-0.5 top-0.5 h-4 w-4 text-white pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
</div>
