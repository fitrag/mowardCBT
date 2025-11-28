<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'MowardCBT' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(148, 163, 184, 0.2);
            border-radius: 20px;
        }
    </style>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="h-full font-sans antialiased text-slate-900" x-data="{ sidebarOpen: false }">
    
    <!-- Mobile sidebar backdrop -->
    <div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true" x-cloak>
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" 
             @click="sidebarOpen = false"></div>

        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative mr-16 flex w-full max-w-xs flex-1">
                
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Sidebar Content -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4 shadow-2xl">
                    <div class="flex h-20 shrink-0 items-center">
                        <div class="flex items-center gap-x-3">
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-lg font-bold text-slate-900 tracking-tight leading-none">MowardCBT</span>
                                <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider mt-1">Exam System</span>
                                <span class="text-[9px] font-medium text-slate-400 mt-0.5">by MowardStudio</span>
                            </div>
                        </div>
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <div class="text-xs font-bold leading-6 text-slate-400 uppercase tracking-wider mb-3 px-2">Main Menu</div>
                                <ul role="list" class="-mx-2 space-y-2">
                                    @if(auth()->user()->role->value === 'admin')
                                        <!-- Admin Menu -->
                                        <li>
                                            <a href="{{ route('dashboard') }}" wire:navigate @click="sidebarOpen = false" class="{{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200">
                                                <svg class="{{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                                </svg>
                                                Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('groups.index') }}" wire:navigate @click="sidebarOpen = false" class="{{ request()->routeIs('groups.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200">
                                                <svg class="{{ request()->routeIs('groups.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                                </svg>
                                                Groups
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('students.index') }}" wire:navigate @click="sidebarOpen = false" class="{{ request()->routeIs('students.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200">
                                                <svg class="{{ request()->routeIs('students.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                </svg>
                                                Students
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('modules.index') }}" wire:navigate @click="sidebarOpen = false" class="{{ request()->routeIs('modules.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200">
                                                <svg class="{{ request()->routeIs('modules.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                                </svg>
                                                Modules
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('subjects.index') }}" wire:navigate @click="sidebarOpen = false" class="{{ request()->routeIs('subjects.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200">
                                                <svg class="{{ request()->routeIs('subjects.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                                </svg>
                                                Subjects
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('tests.index') }}" wire:navigate @click="sidebarOpen = false" class="{{ request()->routeIs('tests.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200">
                                                <svg class="{{ request()->routeIs('tests.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                                </svg>
                                                Tests
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('tokens.index') }}" wire:navigate @click="sidebarOpen = false" class="{{ request()->routeIs('tokens.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200">
                                                <svg class="{{ request()->routeIs('tokens.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                                </svg>
                                                Tokens
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('questions.index') }}" wire:navigate @click="sidebarOpen = false" class="{{ request()->routeIs('questions.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200">
                                                <svg class="{{ request()->routeIs('questions.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                                </svg>
                                                Questions
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('reports.test-results') }}" wire:navigate @click="sidebarOpen = false" class="{{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200">
                                                <svg class="{{ request()->routeIs('reports.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                                </svg>
                                                Reports
                                            </a>
                                        </li>
                                    @else
                                        <!-- Student Menu -->
                                        <li>
                                            <a href="{{ route('student.dashboard') }}" wire:navigate @click="sidebarOpen = false" class="{{ request()->routeIs('student.dashboard') ? 'bg-indigo-50 text-indigo-600 shadow-sm ring-1 ring-indigo-500/10' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} group flex gap-x-3 rounded-xl p-3 text-sm leading-6 font-semibold transition-all duration-200">
                                                <svg class="{{ request()->routeIs('student.dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} h-6 w-6 shrink-0 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                                </svg>
                                                Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <div class="px-2 py-1.5 text-xs font-medium text-slate-400">My Tests</div>
                                        </li>
                                    @endif
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
        </div>
    </div>


    <!-- Desktop Sidebar (Floating Style) -->
    <x-sidebar />

    <div class="lg:pl-72">
        <!-- Mobile Header -->
        <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white/80 backdrop-blur-md px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:hidden">
            <button type="button" class="-m-2.5 p-2.5 text-slate-700" @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                <div class="flex flex-1 items-center">
                    <span class="text-lg font-bold text-slate-900">MowardCBT</span>
                </div>
            </div>
        </div>

        <main class="py-4 sm:py-10">
            <div class="px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>
