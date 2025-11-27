<div>
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-slate-900">Students</h1>
            <p class="mt-2 text-sm text-slate-500">Manage student accounts, including their login credentials and group assignment.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex items-center gap-4">
            @if(count($selected) > 0)
                <x-danger-button 
                    @click="confirmAction('Delete Selected?', 'This will delete {{ count($selected) }} student(s). This action cannot be undone!', 'Yes, delete them!', () => $wire.deleteSelected())"
                    wire:loading.attr="disabled"
                >
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Delete ({{ count($selected) }})
                </x-danger-button>
            @endif
            
            <!-- Group Filter -->
            <div class="w-48">
                <x-select wire:model.live="filterGroup">
                    <option value="">All Groups</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </x-select>
            </div>
            
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg wire:loading.remove wire:target="search" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                    <div wire:loading wire:target="search">
                        <x-loading-spinner class="h-5 w-5 text-indigo-600 ml-0 mr-0" />
                    </div>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full rounded-xl border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 shadow-sm" placeholder="Search students...">
            </div>
            <x-secondary-button x-on:click="$dispatch('open-modal', 'import-modal')">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>
                Import
            </x-secondary-button>
            <x-primary-button wire:click="create" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="create">Add Student</span>
                <span wire:loading.flex wire:target="create" class="items-center">
                    <x-loading-spinner />
                    Loading...
                </span>
            </x-primary-button>
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <x-table>
                    <x-slot name="header">
                        <x-table-th class="w-12">
                            <x-checkbox 
                                wire:click="toggleSelectAll"
                                x-bind:checked="$wire.selected.length > 0"
                            />
                        </x-table-th>
                        <x-table-th>Name</x-table-th>
                        <x-table-th>Username</x-table-th>
                        <x-table-th>Group</x-table-th>
                        <x-table-th>Description</x-table-th>
                        <x-table-th class="text-right">Actions</x-table-th>
                    </x-slot>

                    @forelse ($students as $student)
                        <x-table-row>
                            <x-table-td>
                                <x-checkbox 
                                    wire:model.live="selected" 
                                    value="{{ $student->id }}"
                                />
                            </x-table-td>
                            <x-table-td>
                                <div class="font-semibold text-slate-900">{{ $student->name }}</div>
                                <div class="text-xs text-slate-500">{{ $student->email }}</div>
                            </x-table-td>
                            <x-table-td class="font-mono text-xs">{{ $student->username }}</x-table-td>
                            <x-table-td>
                                @if($student->group)
                                    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">{{ $student->group->name }}</span>
                                @else
                                    <span class="text-slate-400 italic">No Group</span>
                                @endif
                            </x-table-td>
                            <x-table-td>{{ $student->description ?? '-' }}</x-table-td>
                            <x-table-td class="text-right">
                                <x-table-button wire:click="edit({{ $student->id }})" wire:loading.class="opacity-50" wire:target="edit({{ $student->id }})" color="indigo" class="mr-4">
                                    Edit
                                </x-table-button>
                                <x-table-button 
                                    @click="confirmAction('Are you sure?', 'This action cannot be undone!', 'Yes, delete it!', () => $wire.delete({{ $student->id }}))"
                                    wire:loading.class="opacity-50" wire:target="delete({{ $student->id }})"
                                    color="red"
                                >
                                    Delete
                                </x-table-button>
                            </x-table-td>
                        </x-table-row>
                    @empty
                        <x-table-empty title="No students found" description="Get started by adding a new student." />
                    @endforelse
                </x-table>

                @if ($students->hasMorePages())
                    <div class="mt-8 text-center">
                        <x-secondary-button wire:click="loadMore" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="loadMore">Load More</span>
                            <span wire:loading.flex wire:target="loadMore" class="items-center">
                                <x-loading-spinner class="text-slate-600" />
                                Loading...
                            </span>
                        </x-secondary-button>
                    </div>
                @endif
                <div class="mt-4 text-xs text-slate-400 text-center">
                    Showing {{ $students->count() }} of {{ $students->total() }} students
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="student-modal" focusable>
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-900">
                    {{ $isEdit ? 'Edit Student' : 'Add New Student' }}
                </h2>
                <button x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="name" value="Name" />
                        <div class="mt-1.5">
                            <x-text-input wire:model="name" id="name" type="text" placeholder="Full Name" />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="email" value="Email" />
                        <div class="mt-1.5">
                            <x-text-input wire:model="email" id="email" type="email" placeholder="email@example.com" />
                            <x-input-error :messages="$errors->get('email')" />
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="username" value="Username" />
                        <div class="mt-1.5">
                            <x-text-input wire:model="username" id="username" type="text" placeholder="Username" />
                            <x-input-error :messages="$errors->get('username')" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="password" value="Password" />
                        <div class="mt-1.5">
                            <x-text-input wire:model="password" id="password" type="password" placeholder="{{ $isEdit ? 'Leave blank to keep current' : 'Password' }}" />
                            <x-input-error :messages="$errors->get('password')" />
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="group_id" value="Group" />
                    <div class="mt-1.5">
                        <x-select wire:model="group_id" id="group_id">
                            <option value="">Select a Group</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error :messages="$errors->get('group_id')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="description" value="Description (Optional)" />
                    <div class="mt-1.5">
                        <x-textarea wire:model="description" id="description" rows="3" placeholder="Additional notes..." />
                        <x-input-error :messages="$errors->get('description')" />
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>
                <x-primary-button wire:click="store" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="store">Save Changes</span>
                    <span wire:loading.flex wire:target="store" class="items-center">
                        <x-loading-spinner />
                        Saving...
                    </span>
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <!-- Import Modal -->
    <x-modal name="import-modal" focusable>
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-900">
                    Import Students
                </h2>
                <button x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <div class="rounded-lg bg-slate-50 p-4 border border-slate-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1 md:flex md:justify-between">
                            <p class="text-sm text-indigo-700">
                                Download the template file to ensure correct formatting.
                            </p>
                            <p class="mt-3 text-sm md:ml-6 md:mt-0">
                                <button wire:click="downloadTemplate" class="whitespace-nowrap font-medium text-indigo-700 hover:text-indigo-600">
                                    Download Template <span aria-hidden="true">&rarr;</span>
                                </button>
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="importFile" value="Select Excel/CSV File" />
                    <div class="mt-2">
                        <input wire:model="importFile" id="importFile" type="file" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        <x-input-error :messages="$errors->get('importFile')" />
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>
                <x-primary-button wire:click="import" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="import">Import Students</span>
                    <span wire:loading.flex wire:target="import" class="items-center">
                        <x-loading-spinner />
                        Importing...
                    </span>
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>
