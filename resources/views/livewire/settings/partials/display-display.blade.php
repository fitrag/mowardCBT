{{-- Display Settings Display --}}
<div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-base font-semibold leading-6 text-slate-900 mb-5">Display Settings</h3>
        
        <dl class="divide-y divide-slate-100">
            {{-- Date Format --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Date Format</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                        {{ $date_format }}
                    </span>
                    <span class="text-xs text-slate-500 ml-2">Example: {{ now()->format($date_format) }}</span>
                </dd>
            </div>

            {{-- Items Per Page --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Items Per Page</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="font-semibold">{{ $items_per_page }} items</span>
                    <span class="text-xs text-slate-500 ml-2">per page in tables</span>
                </dd>
            </div>
        </dl>
    </div>
</div>
