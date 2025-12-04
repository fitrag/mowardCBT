<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('tests.index') }}" wire:navigate class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold leading-6 text-slate-900">Test Results: {{ $test->name }}</h1>
                <p class="mt-1 text-sm text-slate-500">View all student attempts and scores for this test</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Total Participants</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $this->stats['total_participants'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Completed</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $this->stats['completed'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center">
                    <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Average Score</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($this->stats['average_score'], 1) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-amber-100 flex items-center justify-center">
                    <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500">Highest Score</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($this->stats['highest_score'], 1) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg wire:loading.remove wire:target="search" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                    <div wire:loading wire:target="search">
                        <x-loading-spinner class="h-5 w-5 text-indigo-600 ml-0 mr-0" />
                    </div>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full rounded-lg border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm" placeholder="Search by student name or email...">
            </div>

            <div>
                <x-select wire:model.live="statusFilter" class="w-full">
                    <option value="">All Status</option>
                    <option value="in_progress">In Progress</option>
                    <option value="submitted">Submitted</option>
                    <option value="graded">Graded</option>
                    <option value="paused">Paused</option>
                    <option value="cheating_detected">Cheating Detected</option>
                </x-select>
            </div>
            
            <!-- View Mode Toggle -->
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-slate-700">View:</span>
                <div class="inline-flex rounded-lg border border-slate-200 p-1 bg-slate-50">
                    <button 
                        wire:click="$set('viewMode', 'modern')"
                        class="px-3 py-1.5 text-sm font-medium rounded-md transition-all {{ $viewMode === 'modern' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
                    >
                        Modern
                    </button>
                    <button 
                        wire:click="$set('viewMode', 'classic')"
                        class="px-3 py-1.5 text-sm font-medium rounded-md transition-all {{ $viewMode === 'classic' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
                    >
                        Classic
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 overflow-hidden">
        @if($viewMode === 'classic')
            <!-- Classic Document-Style View -->
            <div class="divide-y divide-slate-200">
                @forelse ($attempts as $attempt)
                    <div class="p-6 hover:bg-slate-50 transition-colors cursor-pointer" 
                        wire:dblclick="viewAttemptDetail({{ $attempt->id }})"
                        title="Double-click to view details"
                    >
                        <div class="grid grid-cols-12 gap-4 items-start">
                            <!-- Number -->
                            <div class="col-span-1">
                                <span class="text-sm font-medium text-slate-900">{{ $loop->iteration }}.</span>
                            </div>
                            
                            <!-- Student Info -->
                            <div class="col-span-3">
                                <p class="text-sm font-medium text-slate-900">{{ $attempt->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $attempt->user->email }}</p>
                            </div>
                            
                            <!-- Score -->
                            <div class="col-span-2">
                                @if($attempt->score !== null)
                                    <div>
                                        <div class="flex items-baseline gap-1 mb-1">
                                            <span class="text-sm font-bold text-slate-900">{{ number_format($attempt->score, 1) }}</span>
                                            <span class="text-xs text-slate-500">({{ number_format(($attempt->score / $test->max_score) * 100, 1) }}%)</span>
                                        </div>
                                        @if($attempt->correct_answers !== null)
                                            <div class="text-xs text-slate-600">
                                                <span class="text-green-600 font-medium">✓ {{ $attempt->correct_answers }}</span>
                                                <span class="text-slate-400 mx-1">|</span>
                                                <span class="text-red-600 font-medium">✗ {{ $attempt->wrong_answers }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-sm text-slate-400">-</span>
                                @endif
                            </div>
                            
                            <!-- Status -->
                            <div class="col-span-2">
                                @if($attempt->status === 'in_progress')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">In Progress</span>
                                @elseif($attempt->status === 'submitted')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Submitted</span>
                                @elseif($attempt->status === 'graded')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">Graded</span>
                                @elseif($attempt->status === 'paused')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                        </svg>
                                        Paused
                                    </span>
                                @elseif($attempt->status === 'cheating_detected')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        Cheating Detected
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Dates & Duration -->
                            <div class="col-span-3">
                                <div class="text-xs text-slate-600 space-y-0.5">
                                    <div><span class="font-medium">Started:</span> {{ $attempt->started_at->format('d M Y, H:i') }}</div>
                                    <div><span class="font-medium">Submitted:</span> {{ $attempt->submitted_at ? $attempt->submitted_at->format('d M Y, H:i') : '-' }}</div>
                                    <div>
                                        <span class="font-medium">Duration:</span> 
                                        @if($attempt->status === 'in_progress')
                                            <span 
                                                x-data="{ 
                                                    startedAt: '{{ $attempt->started_at->toIso8601String() }}',
                                                    duration: 0,
                                                    updateDuration() {
                                                        const now = new Date();
                                                        const started = new Date(this.startedAt);
                                                        const diffMs = now - started;
                                                        this.duration = Math.floor(diffMs / 1000 / 60);
                                                    }
                                                }"
                                                x-init="updateDuration(); setInterval(() => updateDuration(), 1000)"
                                                class="text-blue-700 font-medium"
                                            >
                                                <span x-text="duration + ' min'"></span>
                                                <span class="text-slate-500">(ongoing)</span>
                                            </span>
                                        @elseif($attempt->duration_minutes)
                                            {{ $attempt->duration_minutes }} min
                                        @elseif($attempt->submitted_at)
                                            {{ $attempt->started_at->diffInMinutes($attempt->submitted_at) }} min
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="col-span-1 text-right space-y-1">
                                @if($attempt->status === 'in_progress')
                                    <button 
                                        wire:click="pauseTest({{ $attempt->id }})"
                                        wire:loading.class="opacity-50" 
                                        wire:target="pauseTest({{ $attempt->id }})"
                                        class="text-xs text-amber-600 hover:text-amber-900 transition-colors underline block"
                                    >
                                        Pause
                                    </button>
                                @elseif($attempt->status === 'paused')
                                    <button 
                                        wire:click="resumeTest({{ $attempt->id }})"
                                        wire:loading.class="opacity-50" 
                                        wire:target="resumeTest({{ $attempt->id }})"
                                        class="text-xs text-green-600 hover:text-green-900 transition-colors underline block"
                                    >
                                        Resume
                                    </button>
                                @endif
                                <button 
                                    @click="confirmAction('Delete Attempt?', 'This will delete {{ $attempt->user->name }}\\'s attempt. They will be able to retake the test.', 'Yes, delete it!', () => $wire.deleteAttempt({{ $attempt->id }}))"
                                    wire:loading.class="opacity-50" 
                                    wire:target="deleteAttempt({{ $attempt->id }})"
                                    class="text-xs text-red-600 hover:text-red-900 transition-colors underline block"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <svg class="h-12 w-12 text-slate-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                        <p class="text-sm font-medium text-slate-900 mb-1">No results found</p>
                        <p class="text-sm text-slate-500">No students have attempted this test yet.</p>
                    </div>
                @endforelse
            </div>
        @else
            <!-- Modern Table View -->
        <x-table>
            <x-slot name="header">
                <x-table-th>Student</x-table-th>
                <x-table-th>Score</x-table-th>
                <x-table-th>Status</x-table-th>
                <x-table-th>Started At</x-table-th>
                <x-table-th>Submitted At</x-table-th>
                <x-table-th>Duration</x-table-th>
                <x-table-th class="text-right">Actions</x-table-th>
            </x-slot>

            @forelse ($attempts as $attempt)
                <x-table-row wire:dblclick="viewAttemptDetail({{ $attempt->id }})" class="cursor-pointer" title="Double-click to view details">
                    <x-table-td>
                        <div>
                            <p class="font-medium text-slate-900">{{ $attempt->user->name }}</p>
                            <p class="text-sm text-slate-500">{{ $attempt->user->email }}</p>
                        </div>
                    </x-table-td>
                    <x-table-td>
                        @if($attempt->score !== null)
                            <div>
                                <p class="font-bold text-slate-900">{{ number_format($attempt->score, 1) }}</p>
                                <p class="text-xs text-slate-500">{{ number_format(($attempt->score / $test->max_score) * 100, 1) }}%</p>
                                @if($attempt->correct_answers !== null)
                                    <div class="text-xs text-slate-600 mt-1">
                                        <span class="text-green-600 font-medium">✓ {{ $attempt->correct_answers }}</span>
                                        <span class="text-slate-400 mx-1">|</span>
                                        <span class="text-red-600 font-medium">✗ {{ $attempt->wrong_answers }}</span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </x-table-td>
                    <x-table-td>
                        @if($attempt->status === 'in_progress')
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                In Progress
                            </span>
                        @elseif($attempt->status === 'submitted')
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10">
                                Submitted
                            </span>
                        @elseif($attempt->status === 'graded')
                            <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">
                                Graded
                            </span>
                        @elseif($attempt->status === 'paused')
                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                </svg>
                                Paused
                            </span>
                        @elseif($attempt->status === 'cheating_detected')
                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-700/10">
                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                                Cheating Detected
                            </span>
                        @endif
                    </x-table-td>
                    <x-table-td>
                        <div class="text-sm">
                            <p class="text-slate-900">{{ $attempt->started_at->format('d M Y') }}</p>
                            <p class="text-slate-500">{{ $attempt->started_at->format('H:i') }}</p>
                        </div>
                    </x-table-td>
                    <x-table-td>
                        @if($attempt->submitted_at)
                            <div class="text-sm">
                                <p class="text-slate-900">{{ $attempt->submitted_at->format('d M Y') }}</p>
                                <p class="text-slate-500">{{ $attempt->submitted_at->format('H:i') }}</p>
                            </div>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </x-table-td>
                    <x-table-td>
                        @if($attempt->status === 'in_progress')
                            {{-- Real-time duration for in-progress attempts --}}
                            <div 
                                x-data="{ 
                                    startedAt: '{{ $attempt->started_at->toIso8601String() }}',
                                    duration: 0,
                                    updateDuration() {
                                        const now = new Date();
                                        const started = new Date(this.startedAt);
                                        const diffMs = now - started;
                                        this.duration = Math.floor(diffMs / 1000 / 60);
                                    }
                                }"
                                x-init="updateDuration(); setInterval(() => updateDuration(), 1000)"
                                class="inline-flex items-center gap-1 text-sm text-blue-700 font-medium"
                            >
                                <svg class="h-4 w-4 animate-pulse" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span x-text="duration + ' min'"></span>
                                <span class="text-xs text-slate-500">(ongoing)</span>
                            </div>
                        @elseif($attempt->duration_minutes)
                            {{-- Saved duration for completed attempts --}}
                            <span class="inline-flex items-center gap-1 text-sm text-slate-700">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $attempt->duration_minutes }} min
                            </span>
                        @elseif($attempt->submitted_at)
                            {{-- Calculated duration for old data --}}
                            @php
                                $duration = $attempt->started_at->diffInMinutes($attempt->submitted_at);
                            @endphp
                            <span class="inline-flex items-center gap-1 text-sm text-slate-700">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $duration }} min
                            </span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </x-table-td>
                    <x-table-td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($attempt->status === 'in_progress')
                                <x-table-button 
                                    wire:click="pauseTest({{ $attempt->id }})" 
                                    wire:loading.class="opacity-50" 
                                    wire:target="pauseTest({{ $attempt->id }})"
                                    color="amber"
                                >
                                    <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                    </svg>
                                    Pause
                                </x-table-button>
                                <x-table-button 
                                    @click="$dispatch('open-add-time-modal', { attemptId: {{ $attempt->id }} })"
                                    color="blue"
                                >
                                    <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Add Time
                                </x-table-button>
                            @elseif($attempt->status === 'paused')
                                <x-table-button 
                                    wire:click="resumeTest({{ $attempt->id }})" 
                                    wire:loading.class="opacity-50" 
                                    wire:target="resumeTest({{ $attempt->id }})"
                                    color="green"
                                >
                                    <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                    </svg>
                                    Resume
                                </x-table-button>
                            @endif
                            <x-table-button 
                                @click="confirmAction('Delete Attempt?', 'This will delete {{ $attempt->user->name }}\\'s attempt. They will be able to retake the test.', 'Yes, delete it!', () => $wire.deleteAttempt({{ $attempt->id }}))"
                                wire:loading.class="opacity-50" 
                                wire:target="deleteAttempt({{ $attempt->id }})"
                                color="red"
                            >
                                Delete
                            </x-table-button>
                        </div>
                    </x-table-td>
                </x-table-row>
            @empty
                <x-table-empty title="No results found" description="No students have attempted this test yet." />
            @endforelse
        </x-table>
        @endif

        @if ($attempts->hasMorePages())
            <div class="p-4 border-t border-slate-200 text-center">
                <x-secondary-button wire:click="loadMore" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="loadMore">Load More</span>
                    <span wire:loading.flex wire:target="loadMore" class="items-center">
                        <x-loading-spinner class="text-slate-600" />
                        Loading...
                    </span>
                </x-secondary-button>
            </div>
        @endif

        <div class="p-4 border-t border-slate-200 text-xs text-slate-400 text-center">
            Showing {{ $attempts->count() }} of {{ $attempts->total() }} results
        </div>
    </div>
    
    <!-- Answer Detail Modal -->
    @if($selectedAttempt)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-transition>
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeModal"></div>
            
            <!-- Modal Content -->
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                    <!-- Header -->
                    <div class="sticky top-0 bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">{{ $selectedAttempt->user->name }}'s Answers</h2>
                            <p class="text-sm text-slate-500">{{ $test->name }}</p>
                        </div>
                        <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Score Summary -->
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-slate-200">
                        <div class="grid grid-cols-4 gap-4">
                            <div class="text-center">
                                <p class="text-xs font-medium text-slate-600 mb-1">Score</p>
                                <p class="text-2xl font-bold text-indigo-600">{{ number_format($selectedAttempt->score, 1) }}</p>
                                <p class="text-xs text-slate-500">{{ number_format(($selectedAttempt->score / $test->max_score) * 100, 1) }}%</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs font-medium text-slate-600 mb-1">Correct</p>
                                <p class="text-2xl font-bold text-green-600">{{ $selectedAttempt->correct_answers ?? '-' }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs font-medium text-slate-600 mb-1">Wrong</p>
                                <p class="text-2xl font-bold text-red-600">{{ $selectedAttempt->wrong_answers ?? '-' }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs font-medium text-slate-600 mb-1">Duration</p>
                                <p class="text-2xl font-bold text-slate-900">
                                    @if($selectedAttempt->duration_seconds)
                                        {{ floor($selectedAttempt->duration_seconds / 60) }}:{{ str_pad($selectedAttempt->duration_seconds % 60, 2, '0', STR_PAD_LEFT) }}
                                    @elseif($selectedAttempt->duration_minutes)
                                        {{ $selectedAttempt->duration_minutes }}
                                    @elseif($selectedAttempt->submitted_at)
                                        {{ $selectedAttempt->started_at->diffInMinutes($selectedAttempt->submitted_at) }}
                                    @else
                                        -
                                    @endif
                                </p>
                                <p class="text-xs text-slate-500">
                                    @if($selectedAttempt->duration_seconds)
                                        min:sec
                                    @else
                                        minutes
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Questions List -->
                    <div class="overflow-y-auto max-h-[calc(90vh-240px)] px-6 py-4">
                        @if($test->show_result_details && $selectedAttempt->questions)
                            <div class="space-y-4">
                                @foreach($selectedAttempt->questions as $index => $question)
                                    @php
                                        $userAnswer = $selectedAttempt->answers[$question['id']] ?? null;
                                        $isCorrect = $userAnswer == $question['correct_answer'];
                                    @endphp
                                    
                                    <div class="bg-slate-50 rounded-lg p-4 {{ $isCorrect ? 'ring-2 ring-green-200' : ($userAnswer ? 'ring-2 ring-red-200' : 'ring-1 ring-slate-200') }}">
                                        <!-- Question Header -->
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full flex items-center justify-center {{ $isCorrect ? 'bg-green-100 text-green-700' : ($userAnswer ? 'bg-red-100 text-red-700' : 'bg-slate-200 text-slate-600') }} font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-slate-900">{!! nl2br(e($question['question'])) !!}</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                @if($isCorrect)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        ✓ Correct
                                                    </span>
                                                @elseif($userAnswer)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        ✗ Wrong
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                                        - Unanswered
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Options -->
                                        @if($question['question_type'] == 1)
                                            <div class="space-y-2 ml-11">
                                                @php
                                                    $options = $question['shuffled_options'] ?? $question['limited_options'] ?? $question['options'] ?? [];
                                                @endphp
                                                @foreach($options as $option)
                                                    @php
                                                        $isUserAnswer = $userAnswer == $option['option_text'];
                                                        $isCorrectOption = $option['is_correct'];
                                                    @endphp
                                                    <div class="flex items-start gap-2 p-2 rounded {{ $isCorrectOption ? 'bg-green-50 border border-green-200' : ($isUserAnswer ? 'bg-red-50 border border-red-200' : 'bg-white border border-slate-200') }}">
                                                        <div class="flex-shrink-0 mt-0.5">
                                                            @if($isCorrectOption)
                                                                <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            @elseif($isUserAnswer)
                                                                <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                                </svg>
                                                            @else
                                                                <div class="h-5 w-5 rounded-full border-2 border-slate-300"></div>
                                                            @endif
                                                        </div>
                                                        <p class="text-sm {{ $isCorrectOption ? 'text-green-900 font-medium' : ($isUserAnswer ? 'text-red-900' : 'text-slate-700') }}">
                                                            {{ $option['option_text'] }}
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <!-- Essay Answer -->
                                            <div class="ml-11 space-y-2">
                                                <div class="bg-white border border-slate-200 rounded p-3">
                                                    <p class="text-xs font-medium text-slate-600 mb-1">Student's Answer:</p>
                                                    <p class="text-sm text-slate-900">{{ $userAnswer ?? '-' }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="h-16 w-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                <p class="text-slate-600 font-medium mb-1">Detailed results are hidden</p>
                                <p class="text-sm text-slate-500">The test administrator has disabled detailed result viewing.</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Footer -->
                    <div class="sticky bottom-0 bg-white border-t border-slate-200 px-6 py-4">
                        <button wire:click="closeModal" class="w-full px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Add Time Modal -->
    <div x-data="{ 
        showAddTimeModal: false,
        selectedAttemptId: null,
        extraMinutes: 5,
        init() {
            window.addEventListener('open-add-time-modal', (e) => {
                this.selectedAttemptId = e.detail.attemptId;
                this.showAddTimeModal = true;
            });
        }
    }">
        <div 
            x-show="showAddTimeModal" 
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto"
            @keydown.escape.window="showAddTimeModal = false"
        >
            <!-- Background overlay -->
            <div 
                x-show="showAddTimeModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-500 bg-opacity-75 transition-opacity"
                @click="showAddTimeModal = false"
            ></div>

            <!-- Modal panel -->
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div 
                    x-show="showAddTimeModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl z-50"
                >
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900">Add Extra Time</h3>
                        <button @click="showAddTimeModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Extra Minutes</label>
                            <input 
                                type="number" 
                                x-model="extraMinutes"
                                min="1"
                                max="60"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter minutes"
                            >
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button 
                                @click="showAddTimeModal = false"
                                class="flex-1 px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors"
                            >
                                Cancel
                            </button>
                            <button 
                                @click="$wire.addExtraTime(selectedAttemptId, extraMinutes); showAddTimeModal = false"
                                class="flex-1 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors"
                            >
                                Add Time
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
