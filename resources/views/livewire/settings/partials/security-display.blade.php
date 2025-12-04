{{-- Security Settings Display --}}
<div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-base font-semibold leading-6 text-slate-900 mb-5">Security Settings</h3>
        
        <dl class="divide-y divide-slate-100">
            {{-- Safe Browser --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Safe Browser Requirement</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    @if ($enable_safe_browser)
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Required
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20">
                            Not Required
                        </span>
                    @endif
                </dd>
            </div>

            {{-- Cheating Detection --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Cheating Detection</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    @if ($enable_cheating_detection)
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Enabled
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                            Disabled
                        </span>
                    @endif
                </dd>
            </div>

            {{-- Max Login Attempts --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Max Login Attempts</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="font-semibold">{{ $max_login_attempts }} attempts</span>
                    <span class="text-xs text-slate-500 ml-2">before lockout</span>
                </dd>
            </div>

            {{-- Session Timeout --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Session Timeout</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="font-semibold">{{ $session_timeout }} minutes</span>
                </dd>
            </div>
        </dl>
    </div>
</div>
