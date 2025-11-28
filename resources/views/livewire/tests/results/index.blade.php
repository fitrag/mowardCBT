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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                </x-select>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 overflow-hidden">
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
                <x-table-row>
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
                        <x-table-button 
                            @click="confirmAction('Delete Attempt?', 'This will delete {{ $attempt->user->name }}\\'s attempt. They will be able to retake the test.', 'Yes, delete it!', () => $wire.deleteAttempt({{ $attempt->id }}))"
                            wire:loading.class="opacity-50" 
                            wire:target="deleteAttempt({{ $attempt->id }})"
                            color="red"
                        >
                            Delete
                        </x-table-button>
                    </x-table-td>
                </x-table-row>
            @empty
                <x-table-empty title="No results found" description="No students have attempted this test yet." />
            @endforelse
        </x-table>

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
</div>
