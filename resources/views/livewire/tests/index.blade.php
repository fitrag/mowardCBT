<div>
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-slate-900">Tests</h1>
            <p class="mt-2 text-sm text-slate-500">Manage exams with dynamic group assignment and subject selection.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('tests.create') }}" wire:navigate>
                <x-primary-button>
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Create Test
                </x-primary-button>
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="mt-6">
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full rounded-xl border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm shadow-sm" placeholder="Search tests...">
        </div>
    </div>

    <!-- Table -->
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <x-table>
                    <x-slot name="header">
                        <x-table-th>Test Name</x-table-th>
                        <x-table-th>Schedule</x-table-th>
                        <x-table-th>Duration</x-table-th>
                        <x-table-th>Groups</x-table-th>
                        <x-table-th>Subjects</x-table-th>
                        <x-table-th>Status</x-table-th>
                        <x-table-th class="text-right">Actions</x-table-th>
                    </x-slot>

                    @forelse ($tests as $test)
                        <x-table-row>
                            <x-table-td>
                                <div>
                                    <p class="font-medium text-slate-900">{{ $test->name }}</p>
                                    @if($test->description)
                                        <p class="text-sm text-slate-500 line-clamp-1">{{ $test->description }}</p>
                                    @endif
                                </div>
                            </x-table-td>
                            <x-table-td>
                                <div class="text-sm">
                                    <p class="text-slate-900">{{ $test->start_date->format('d M Y, H:i') }}</p>
                                    <p class="text-slate-500">to {{ $test->end_date->format('d M Y, H:i') }}</p>
                                </div>
                            </x-table-td>
                            <x-table-td>
                                <span class="inline-flex items-center gap-1 text-sm text-slate-700">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $test->duration }} min
                                </span>
                            </x-table-td>
                            <x-table-td>
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                    {{ $test->groups->count() }} group(s)
                                </span>
                            </x-table-td>
                            <x-table-td>
                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-700/10">
                                    {{ $test->subjects->count() }} subject(s)
                                </span>
                            </x-table-td>
                            <x-table-td>
                                @php
                                    $now = now();
                                    $status = 'upcoming';
                                    $statusColor = 'blue';
                                    $statusText = 'Upcoming';
                                    
                                    if ($now->greaterThan($test->end_date)) {
                                        $status = 'expired';
                                        $statusColor = 'gray';
                                        $statusText = 'Expired';
                                    } elseif ($now->between($test->start_date, $test->end_date)) {
                                        $status = 'active';
                                        $statusColor = 'green';
                                        $statusText = 'Active';
                                    }
                                @endphp
                                <span class="inline-flex items-center rounded-md bg-{{ $statusColor }}-50 px-2 py-1 text-xs font-medium text-{{ $statusColor }}-700 ring-1 ring-inset ring-{{ $statusColor }}-700/10">
                                    {{ $statusText }}
                                </span>
                            </x-table-td>
                            <x-table-td class="text-right">
                                <a href="{{ route('tests.results', $test) }}" wire:navigate>
                                    <x-table-button color="purple" class="mr-2">
                                        <svg class="-ml-0.5 mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Results
                                    </x-table-button>
                                </a>
                                <a href="{{ route('tests.edit', $test) }}" wire:navigate>
                                    <x-table-button color="indigo" class="mr-2">Edit</x-table-button>
                                </a>
                                <x-table-button @click="confirmAction('Delete Test?', 'This action cannot be undone!', 'Yes, delete it!', () => $wire.delete({{ $test->id }}))" color="red">Delete</x-table-button>
                            </x-table-td>
                        </x-table-row>
                    @empty
                        <x-table-empty title="No tests found" description="Get started by creating a new test." />
                    @endforelse
                </x-table>

                <div class="mt-4">
                    {{ $tests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
