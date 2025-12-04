{{-- AI Generator Settings Display --}}
<div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-base font-semibold leading-6 text-slate-900 mb-5">AI Generator Settings</h3>
        
        <dl class="divide-y divide-slate-100">
            {{-- AI Generator Status --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">AI Generator</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    @if ($enable_ai_generator)
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Enabled
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20">
                            Disabled
                        </span>
                    @endif
                </dd>
            </div>

            {{-- AI Model --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">AI Model</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                        {{ $ai_model }}
                    </span>
                </dd>
            </div>

            {{-- Temperature --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Temperature</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="font-semibold">{{ $ai_temperature }}</span>
                    <span class="text-xs text-slate-500 ml-2">(Randomness level)</span>
                </dd>
            </div>

            {{-- Max Tokens --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Maximum Tokens</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="font-semibold">{{ number_format($ai_max_tokens) }} tokens</span>
                </dd>
            </div>
        </dl>
    </div>
</div>
