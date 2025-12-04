{{-- General Settings Display --}}
<div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-base font-semibold leading-6 text-slate-900 mb-5">General Settings</h3>
        
        <dl class="divide-y divide-slate-100">
            {{-- App Logo --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Application Logo</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    @if ($current_logo)
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-md shadow-indigo-500/20 overflow-hidden">
                                <img src="{{ asset('storage/' . $current_logo) }}" alt="Logo" class="h-full w-full object-cover">
                            </div>
                            <span class="text-sm text-slate-500">{{ basename($current_logo) }}</span>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-md shadow-indigo-500/20">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                </svg>
                            </div>
                            <span class="text-sm text-slate-500">Default Logo</span>
                        </div>
                    @endif
                </dd>
            </div>

            {{-- App Name --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Application Name</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="font-semibold">{{ $app_name }}</span>
                </dd>
            </div>

            {{-- App Description --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Description</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">{{ $app_description }}</dd>
            </div>

            {{-- Contact Email --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Contact Email</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">{{ $contact_email }}</dd>
            </div>

            {{-- Timezone --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Timezone</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">
                        {{ $timezone }}
                    </span>
                </dd>
            </div>

            {{-- Language --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Language</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-600/20">
                        {{ $language === 'id' ? 'Indonesian' : 'English' }}
                    </span>
                </dd>
            </div>

            {{-- Login Method --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Login Method</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $login_method === 'email' ? 'bg-blue-50 text-blue-700 ring-blue-600/20' : 'bg-purple-50 text-purple-700 ring-purple-600/20' }}">
                        {{ ucfirst($login_method) }}
                    </span>
                </dd>
            </div>
        </dl>
    </div>
</div>
