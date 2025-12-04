<div>
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-slate-900">Test Results Report</h1>
            <p class="mt-2 text-sm text-slate-500">View and analyze all student test results with advanced filtering options.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex gap-2">
            <x-secondary-button wire:click="export" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed">
                <svg wire:loading.remove wire:target="export" class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                <x-loading-spinner wire:loading wire:target="export" class="h-5 w-5 -ml-0.5 mr-1.5" />
                <span wire:loading.remove wire:target="export">Export to Excel</span>
                <span wire:loading wire:target="export">Exporting...</span>
            </x-secondary-button>
            <x-secondary-button wire:click="resetFilters" wire:loading.attr="disabled">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                Reset Filters
            </x-secondary-button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
        <div class="overflow-hidden rounded-xl bg-white px-4 py-5 shadow-sm ring-1 ring-slate-900/5 sm:p-6">
            <dt class="truncate text-xs font-medium text-slate-500">Total Attempts</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">{{ number_format($stats['total']) }}</dd>
        </div>
        <div class="overflow-hidden rounded-xl bg-white px-4 py-5 shadow-sm ring-1 ring-slate-900/5 sm:p-6">
            <dt class="truncate text-xs font-medium text-slate-500">Avg Score</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">{{ $stats['avgScore'] }}</dd>
        </div>
        <div class="overflow-hidden rounded-xl bg-white px-4 py-5 shadow-sm ring-1 ring-slate-900/5 sm:p-6">
            <dt class="truncate text-xs font-medium text-slate-500">Avg %</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">{{ $stats['avgPercentage'] }}%</dd>
        </div>
        <div class="overflow-hidden rounded-xl bg-white px-4 py-5 shadow-sm ring-1 ring-slate-900/5 sm:p-6">
            <dt class="truncate text-xs font-medium text-slate-500">Pass Rate</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-emerald-600">{{ $stats['passRate'] }}%</dd>
        </div>
        <div class="overflow-hidden rounded-xl bg-white px-4 py-5 shadow-sm ring-1 ring-slate-900/5 sm:p-6">
            <dt class="truncate text-xs font-medium text-slate-500">Highest</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-indigo-600">{{ $stats['highestScore'] }}</dd>
        </div>
        <div class="overflow-hidden rounded-xl bg-white px-4 py-5 shadow-sm ring-1 ring-slate-900/5 sm:p-6">
            <dt class="truncate text-xs font-medium text-slate-500">Lowest</dt>
            <dd class="mt-1 text-2xl font-semibold tracking-tight text-rose-600">{{ $stats['lowestScore'] }}</dd>
        </div>
    </div>

    <!-- Filters -->
    <div class="mt-6 flex flex-wrap items-center gap-4">
        <div class="w-48">
            <x-select wire:model.live="filterSubject">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </x-select>
        </div>

        <div class="w-48">
            <x-select wire:model.live="filterTest">
                <option value="">All Tests</option>
                @foreach($tests as $test)
                    <option value="{{ $test->id }}">{{ $test->name }}</option>
                @endforeach
            </x-select>
        </div>

        <div class="w-48">
            <x-select wire:model.live="filterGroup">
                <option value="">All Groups</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </x-select>
        </div>

        <div class="w-40">
            <x-date-input wire:model.live="filterDateFrom" placeholder="From Date" />
        </div>

        <div class="w-40">
            <x-date-input wire:model.live="filterDateTo" placeholder="To Date" />
        </div>

        <div class="relative flex-1 min-w-[200px]">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg wire:loading.remove wire:target="search" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
                <div wire:loading wire:target="search">
                    <x-loading-spinner class="h-5 w-5 text-indigo-600 ml-0 mr-0" />
                </div>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full rounded-xl border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm shadow-sm" placeholder="Search student name or email...">
        </div>
    </div>

    <!-- Table -->
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <x-table>
                    <x-slot name="header">
                        <x-table-th>Student</x-table-th>
                        <x-table-th>Group</x-table-th>
                        <x-table-th>Test</x-table-th>
                        <x-table-th>Subject</x-table-th>
                        <x-table-th>Status</x-table-th>
                        <x-table-th>Score</x-table-th>
                        <x-table-th>Percentage</x-table-th>
                        <x-table-th>Duration</x-table-th>
                        <x-table-th>Submitted</x-table-th>
                        <x-table-th class="text-right">Actions</x-table-th>
                    </x-slot>

                    @forelse($results as $result)
                        @php
                            $percentage = $result->score && $result->test->max_score ? ($result->score / $result->test->max_score) * 100 : 0;
                            $percentageClass = $percentage >= 80 ? 'bg-emerald-100 text-emerald-800' : ($percentage >= 60 ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800');
                        @endphp
                        <x-table-row>
                            <x-table-td>
                                <div class="font-medium text-slate-900">{{ $result->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $result->user->email }}</div>
                            </x-table-td>
                            <x-table-td>
                                <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                    {{ $result->user->group?->name ?? 'No Group' }}
                                </span>
                            </x-table-td>
                            <x-table-td>
                                <div class="font-medium text-slate-900">{{ $result->test->name }}</div>
                            </x-table-td>
                            <x-table-td>
                                <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                                    {{ $result->test->subjects->first()->name ?? 'N/A' }}
                                </span>
                            </x-table-td>
                            <x-table-td>
                                @if($result->status === 'in_progress')
                                    <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                        In Progress
                                    </span>
                                @elseif($result->status === 'paused')
                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                        Paused
                                    </span>
                                @elseif($result->status === 'graded')
                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                        Completed
                                    </span>
                                @elseif($result->status === 'cheating_detected')
                                    <span class="inline-flex items-center rounded-md bg-orange-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/20">
                                        Cheating Detected
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20">
                                        {{ ucfirst($result->status) }}
                                    </span>
                                @endif
                            </x-table-td>
                            <x-table-td>
                                @if($result->score !== null)
                                    <span class="font-semibold text-slate-900">{{ number_format($result->score, 1) }}</span>
                                    <span class="text-slate-500">/ {{ $result->test->max_score }}</span>
                                @else
                                    <span class="text-sm text-slate-400">-</span>
                                @endif
                            </x-table-td>
                            <x-table-td>
                                @if($percentage > 0)
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $percentageClass }}">
                                        {{ number_format($percentage, 1) }}%
                                    </span>
                                @else
                                    <span class="text-sm text-slate-400">-</span>
                                @endif
                            </x-table-td>
                            <x-table-td>
                                @if($result->duration_seconds)
                                    <span class="text-sm text-slate-600">
                                        {{ floor($result->duration_seconds / 60) }}m {{ $result->duration_seconds % 60 }}s
                                    </span>
                                @else
                                    <span class="text-sm text-slate-400">-</span>
                                @endif
                            </x-table-td>
                            <x-table-td>
                                @if($result->submitted_at)
                                    <div class="text-sm text-slate-900">{{ $result->submitted_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-slate-500">{{ $result->submitted_at->format('H:i') }}</div>
                                @else
                                    <span class="text-sm text-slate-400">-</span>
                                @endif
                            </x-table-td>
                            <x-table-td class="text-right">
                                @if($result->status === 'in_progress')
                                    <x-table-button 
                                        wire:click="pauseTest({{ $result->id }})" 
                                        wire:loading.class="opacity-50" 
                                        wire:target="pauseTest({{ $result->id }})"
                                        color="amber"
                                    >
                                        <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                        </svg>
                                        Pause
                                    </x-table-button>
                                @elseif($result->status === 'paused')
                                    <x-table-button 
                                        wire:click="resumeTest({{ $result->id }})" 
                                        wire:loading.class="opacity-50" 
                                        wire:target="resumeTest({{ $result->id }})"
                                        color="green"
                                    >
                                        <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                        </svg>
                                        Resume
                                    </x-table-button>
                                @else
                                    <span class="text-sm text-slate-400">-</span>
                                @endif
                            </x-table-td>
                        </x-table-row>
                    @empty
                        <x-table-row>
                            <x-table-td colspan="8" class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0118 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0118 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 016 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h1.5m14.25 0h1.5" />
                                </svg>
                                <p class="mt-4 text-sm font-semibold text-slate-900">No results found</p>
                                <p class="mt-2 text-sm text-slate-500">Try adjusting your filters or search query</p>
                            </x-table-td>
                        </x-table-row>
                    @endforelse
                </x-table>

                @if($results->hasPages())
                    <div class="mt-6">
                        {{ $results->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

