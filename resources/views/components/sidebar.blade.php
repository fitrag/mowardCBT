<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col lg:p-4">
    <div class="flex grow flex-col gap-y-5 overflow-y-auto rounded-2xl bg-white px-6 pb-4 shadow-[0_0_40px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/5 custom-scrollbar">
        <!-- Logo -->
        <div class="flex h-24 shrink-0 items-center">
            <div class="flex items-center gap-x-3">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-slate-900 tracking-tight leading-none">MowardCBT</span>
                    <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider mt-1">Exam System</span>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <div class="text-xs font-bold leading-6 text-slate-400 uppercase tracking-wider mb-3 px-2">Main Menu</div>
                    <ul role="list" class="-mx-2 space-y-2">
                        <li>
                            <x-sidebar-link route="dashboard" label="Dashboard">
                                <x-slot name="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                </x-slot>
                            </x-sidebar-link>
                        </li>
                        <li>
                            <x-sidebar-link route="groups.index" activePattern="groups.*" label="Groups">
                                <x-slot name="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </x-slot>
                            </x-sidebar-link>
                        </li>
                        <li>
                            <x-sidebar-link route="students.index" activePattern="students.*" label="Students">
                                <x-slot name="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </x-slot>
                            </x-sidebar-link>
                        </li>
                        <li>
                            <x-sidebar-link route="modules.index" activePattern="modules.*" label="Modules">
                                <x-slot name="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                </x-slot>
                            </x-sidebar-link>
                        </li>
                        <li>
                            <x-sidebar-link route="subjects.index" activePattern="subjects.*" label="Subjects">
                                <x-slot name="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </x-slot>
                            </x-sidebar-link>
                        </li>
                        <li>
                            <x-sidebar-link route="questions.index" activePattern="questions.*" label="Questions">
                                <x-slot name="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </x-slot>
                            </x-sidebar-link>
                        </li>
                    </ul>
                </li>
                
                <!-- User Profile -->
                <li class="mt-auto">
                    <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-900/5">
                        <div class="flex items-center gap-x-3">
                            <img class="h-8 w-8 rounded-lg bg-white ring-1 ring-slate-900/10" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=6366f1&color=fff" alt="">
                            <div class="flex flex-col overflow-hidden">
                                <span class="truncate text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="flex w-full items-center justify-center gap-x-2 rounded-lg bg-white px-3 py-2 text-xs font-semibold text-slate-900 shadow-sm ring-1 ring-slate-900/5 hover:bg-slate-50 transition-colors">
                                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
