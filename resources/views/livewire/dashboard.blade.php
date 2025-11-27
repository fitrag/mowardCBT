<div>
    <!-- Header Section -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold tracking-tight text-slate-900">Dashboard</h2>
            <p class="mt-2 text-sm text-slate-500">Welcome back, here's what's happening today.</p>
        </div>
        <div class="flex items-center gap-x-3">
            <span class="inline-flex items-center rounded-lg bg-white px-3 py-1 text-sm font-medium text-slate-600 shadow-sm ring-1 ring-slate-900/5">
                <span class="mr-2 flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                System Online
            </span>
            <button type="button" class="inline-flex items-center gap-x-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-200">
                <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                New Exam
            </button>
        </div>
    </div>
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Users -->
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
            <dt>
                <div class="absolute rounded-xl bg-indigo-50 p-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">Total Users</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-semibold text-slate-900">1,240</p>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-emerald-600">
                    <svg class="h-4 w-4 flex-shrink-0 self-center text-emerald-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Increased by</span>
                    12%
                </p>
            </dd>
        </div>

        <!-- Active Exams -->
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
            <dt>
                <div class="absolute rounded-xl bg-violet-50 p-3">
                    <svg class="h-6 w-6 text-violet-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">Active Exams</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-semibold text-slate-900">24</p>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-emerald-600">
                    <svg class="h-4 w-4 flex-shrink-0 self-center text-emerald-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Increased by</span>
                    4%
                </p>
            </dd>
        </div>

        <!-- Completion Rate -->
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
            <dt>
                <div class="absolute rounded-xl bg-blue-50 p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">Completion Rate</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-semibold text-slate-900">94.2%</p>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-emerald-600">
                    <svg class="h-4 w-4 flex-shrink-0 self-center text-emerald-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Increased by</span>
                    1.2%
                </p>
            </dd>
        </div>

        <!-- Avg Score -->
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
            <dt>
                <div class="absolute rounded-xl bg-amber-50 p-3">
                    <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-slate-500">Avg. Score</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-semibold text-slate-900">86.5</p>
                <p class="ml-2 flex items-baseline text-sm font-semibold text-rose-600">
                    <svg class="h-4 w-4 flex-shrink-0 self-center text-rose-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Decreased by</span>
                    0.5%
                </p>
            </dd>
        </div>
    </div>

    <!-- Recent Activity & Charts Section -->
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Main Chart Area -->
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-semibold leading-6 text-slate-900">Exam Participation</h3>
                        <div class="flex items-center gap-2">
                            <button type="button" class="rounded-md bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50">Weekly</button>
                            <button type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500">Monthly</button>
                        </div>
                    </div>
                    <!-- Placeholder for Chart -->
                    <div class="mt-6 h-64 w-full rounded-xl bg-slate-50 flex items-center justify-center border border-dashed border-slate-200">
                        <p class="text-sm text-slate-400">Chart Visualization Placeholder</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Feed -->
        <div class="lg:col-span-1">
            <div class="overflow-hidden rounded-2xl bg-white shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 h-full">
                <div class="p-6">
                    <h3 class="text-base font-semibold leading-6 text-slate-900">Recent Activity</h3>
                    <div class="mt-6 flow-root">
                        <ul role="list" class="-my-5 divide-y divide-slate-100">
                            <li class="py-5">
                                <div class="relative flex gap-x-4">
                                    <div class="flex-auto">
                                        <div class="flex items-baseline justify-between gap-x-4">
                                            <p class="text-sm font-semibold leading-6 text-slate-900">New User Registered</p>
                                            <p class="flex-none text-xs text-slate-500">1h ago</p>
                                        </div>
                                        <p class="mt-1 text-sm leading-6 text-slate-500">Sarah Smith joined as a participant.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="py-5">
                                <div class="relative flex gap-x-4">
                                    <div class="flex-auto">
                                        <div class="flex items-baseline justify-between gap-x-4">
                                            <p class="text-sm font-semibold leading-6 text-slate-900">Exam Completed</p>
                                            <p class="flex-none text-xs text-slate-500">2h ago</p>
                                        </div>
                                        <p class="mt-1 text-sm leading-6 text-slate-500">Mathematics Final completed by 15 students.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="py-5">
                                <div class="relative flex gap-x-4">
                                    <div class="flex-auto">
                                        <div class="flex items-baseline justify-between gap-x-4">
                                            <p class="text-sm font-semibold leading-6 text-slate-900">System Update</p>
                                            <p class="flex-none text-xs text-slate-500">1d ago</p>
                                        </div>
                                        <p class="mt-1 text-sm leading-6 text-slate-500">Version 2.0.1 successfully deployed.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-6 border-t border-slate-100 pt-4">
                        <a href="#" class="text-sm font-semibold leading-6 text-indigo-600 hover:text-indigo-500">View all activity <span aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
