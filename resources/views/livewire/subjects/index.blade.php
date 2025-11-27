<div>
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-slate-900">Subjects</h1>
            <p class="mt-2 text-sm text-slate-500">Manage subjects/topics within modules (e.g., Bahasa Indonesia, Matematika).</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex items-center gap-4">
            @if(count($selected) > 0)
                <x-danger-button 
                    @click="confirmAction('Delete Selected?', 'This will delete {{ count($selected) }} subject(s). This action cannot be undone!', 'Yes, delete them!', () => $wire.deleteSelected())"
                    wire:loading.attr="disabled"
                >
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Delete ({{ count($selected) }})
                </x-danger-button>
            @endif
            
            <!-- Module Filter -->
            <div class="relative">
                <select wire:model.live="filterModule" class="block w-48 rounded-xl border-0 py-2.5 pl-4 pr-10 text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 shadow-sm bg-white appearance-none cursor-pointer">
                    <option value="">All Modules</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
                    </svg>
                </div>
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
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full rounded-xl border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 shadow-sm" placeholder="Search subjects...">
            </div>
            <x-primary-button wire:click="create" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="create">Add Subject</span>
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
                        <x-table-th>Module</x-table-th>
                        <x-table-th>Description</x-table-th>
                        <x-table-th class="text-right">Actions</x-table-th>
                    </x-slot>

                    @forelse ($subjects as $subject)
                        <x-table-row>
                            <x-table-td>
                                <x-checkbox 
                                    wire:model.live="selected" 
                                    value="{{ $subject->id }}"
                                />
                            </x-table-td>
                            <x-table-td class="font-semibold text-slate-900">{{ $subject->name }}</x-table-td>
                            <x-table-td>
                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-700/10">
                                    {{ $subject->module->name }}
                                </span>
                            </x-table-td>
                            <x-table-td>{{ $subject->description ?? '-' }}</x-table-td>
                            <x-table-td class="text-right">
                                <x-table-button wire:click="edit({{ $subject->id }})" wire:loading.class="opacity-50" wire:target="edit({{ $subject->id }})" color="indigo" class="mr-4">
                                    Edit
                                </x-table-button>
                                <x-table-button 
                                    @click="confirmAction('Are you sure?', 'This action cannot be undone!', 'Yes, delete it!', () => $wire.delete({{ $subject->id }}))"
                                    wire:loading.class="opacity-50" wire:target="delete({{ $subject->id }})"
                                    color="red"
                                >
                                    Delete
                                </x-table-button>
                            </x-table-td>
                        </x-table-row>
                    @empty
                        <x-table-empty title="No subjects found" description="Get started by creating a new subject." />
                    @endforelse
                </x-table>
                @if ($subjects->hasMorePages())
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
                    Showing {{ $subjects->count() }} of {{ $subjects->total() }} subjects
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="subject-modal" focusable>
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-900">
                    {{ $isEdit ? 'Edit Subject' : 'Add New Subject' }}
                </h2>
                <button x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-5">
                <div>
                    <x-input-label for="name" value="Subject Name" />
                    <div class="mt-1.5">
                        <x-text-input wire:model="name" id="name" type="text" placeholder="e.g., Bahasa Indonesia, Matematika" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="module_id" value="Module" />
                    <div class="mt-1.5">
                        <select wire:model="module_id" id="module_id" class="block w-full rounded-xl border-0 py-3 px-4 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-slate-50 focus:bg-white transition-colors">
                            <option value="">Select a module</option>
                            @foreach($modules as $module)
                                <option value="{{ $module->id }}">{{ $module->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('module_id')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="description" value="Description (Optional)" />
                    <div class="mt-1.5">
                        <x-textarea wire:model="description" id="description" rows="3" placeholder="Brief description of this subject..." />
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
</div>
