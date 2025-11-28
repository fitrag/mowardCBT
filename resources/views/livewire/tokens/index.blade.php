<div>
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-slate-900">Token Management</h1>
            <p class="mt-2 text-sm text-slate-500">Manage access tokens for all tests in your system.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex items-center gap-4">
            @if(count($selected) > 0)
                <x-danger-button 
                    @click="confirmAction('Clear Selected Tokens?', 'This will disable tokens for {{ count($selected) }} test(s). This action cannot be undone!', 'Yes, clear them!', () => $wire.clearSelectedTokens())"
                    wire:loading.attr="disabled"
                >
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Clear ({{ count($selected) }})
                </x-danger-button>
            @endif
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg wire:loading.remove wire:target="search" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                    <div wire:loading wire:target="search">
                        <x-loading-spinner class="h-5 w-5 text-indigo-600 ml-0 mr-0" />
                    </div>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full rounded-xl border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 shadow-sm" placeholder="Search tests...">
            </div>
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
                        <x-table-th>Test Name</x-table-th>
                        <x-table-th>Status</x-table-th>
                        <x-table-th>Token</x-table-th>
                        <x-table-th>Expires At</x-table-th>
                        <x-table-th class="text-right">Actions</x-table-th>
                    </x-slot>

                    @forelse ($tests as $test)
                        <x-table-row>
                            <x-table-td>
                                <x-checkbox 
                                    wire:model.live="selected" 
                                    value="{{ $test->id }}"
                                />
                            </x-table-td>
                            <x-table-td class="font-semibold text-slate-900">
                                {{ $test->name }}
                                <div class="text-xs text-slate-500 font-normal">{{ $test->start_date->format('M d, H:i') }} - {{ $test->end_date->format('M d, H:i') }}</div>
                            </x-table-td>
                            <x-table-td>
                                @if($test->isActive())
                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                                @elseif($test->isUpcoming())
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Upcoming</span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">Expired</span>
                                @endif
                            </x-table-td>
                            <x-table-td>
                                @if($test->use_token && $test->token)
                                    <span class="font-mono font-bold text-slate-900 bg-slate-100 px-2 py-1 rounded">{{ $test->token }}</span>
                                @else
                                    <span class="text-slate-400 italic">No Token</span>
                                @endif
                            </x-table-td>
                            <x-table-td>
                                @if($test->use_token && $test->token_expires_at)
                                    @if($test->token_expires_at->isPast())
                                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                            Expired
                                        </span>
                                    @else
                                        <div 
                                            x-data="{ 
                                                expiresAt: '{{ $test->token_expires_at->toIso8601String() }}',
                                                countdown: '',
                                                updateCountdown() {
                                                    const now = new Date();
                                                    const expiry = new Date(this.expiresAt);
                                                    const diff = expiry - now;
                                                    
                                                    if (diff <= 0) {
                                                        this.countdown = 'Expired';
                                                        return;
                                                    }
                                                    
                                                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                                                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                                                    
                                                    let parts = [];
                                                    if (days > 0) parts.push(days + 'd');
                                                    if (hours > 0) parts.push(hours + 'h');
                                                    if (minutes > 0) parts.push(minutes + 'm');
                                                    parts.push(seconds + 's');
                                                    
                                                    this.countdown = parts.join(' ');
                                                }
                                            }"
                                            x-init="updateCountdown(); setInterval(() => updateCountdown(), 1000)"
                                            class="text-green-600 font-medium"
                                        >
                                            <div class="flex items-center gap-1">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span x-text="countdown"></span>
                                            </div>
                                            <div class="text-xs text-slate-400 mt-0.5">{{ $test->token_expires_at->format('M d, H:i') }}</div>
                                        </div>
                                    @endif
                                @else
                                    -
                                @endif
                            </x-table-td>
                            <x-table-td 
                                class="text-right"
                                x-data="{ 
                                    isExpired: {{ $test->use_token && $test->token_expires_at && $test->token_expires_at->isPast() ? 'true' : 'false' }},
                                    expiresAt: '{{ $test->token_expires_at ? $test->token_expires_at->toIso8601String() : '' }}',
                                    checkExpiry() {
                                        if (!this.expiresAt) return;
                                        const now = new Date();
                                        const expiry = new Date(this.expiresAt);
                                        this.isExpired = expiry <= now;
                                    }
                                }"
                                x-init="if (expiresAt) { checkExpiry(); setInterval(() => checkExpiry(), 1000) }"
                            >
                                <!-- Always show Manage button -->
                                <x-table-button 
                                    wire:click="openTokenModal({{ $test->id }})" 
                                    wire:loading.class="opacity-50" 
                                    wire:target="openTokenModal({{ $test->id }})" 
                                    color="indigo" 
                                    class="mr-2"
                                >
                                    Manage
                                </x-table-button>
                                
                                <!-- Show Regenerate button only when token is expired -->
                                <template x-if="isExpired && {{ $test->use_token ? 'true' : 'false' }}">
                                    <x-table-button 
                                        wire:click="regenerateToken({{ $test->id }})" 
                                        wire:loading.class="opacity-50" 
                                        wire:target="regenerateToken({{ $test->id }})"
                                        color="green" 
                                        class="mr-2"
                                    >
                                        <svg class="-ml-0.5 mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>
                                        Regenerate
                                    </x-table-button>
                                </template>
                                
                                <!-- Show Clear button if token is enabled -->
                                @if($test->use_token)
                                    <x-table-button 
                                        @click="confirmAction('Clear Token?', 'This will disable the token for this test.', 'Yes, clear it!', () => $wire.clearToken({{ $test->id }}))"
                                        wire:loading.class="opacity-50" 
                                        wire:target="clearToken({{ $test->id }})"
                                        color="red"
                                    >
                                        Clear
                                    </x-table-button>
                                @endif
                            </x-table-td>
                        </x-table-row>
                    @empty
                        <x-table-empty title="No tests found" description="Create a test first to manage its access token." />
                    @endforelse
                </x-table>
                @if ($tests->hasMorePages())
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
                    Showing {{ $tests->count() }} of {{ $tests->total() }} tests
                </div>
            </div>
        </div>
    </div>

    <!-- Token Management Modal -->
    <x-modal name="token-modal" focusable>
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-900">
                    Manage Access Token
                </h2>
                <button x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-5">
                <!-- Enable Token Toggle -->
                <div class="flex items-center gap-3">
                    <x-checkbox wire:model.live="use_token" id="modal_use_token" />
                    <label for="modal_use_token" class="text-sm font-medium text-slate-700">
                        Require access token for this test
                    </label>
                </div>

                @if($use_token)
                    <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 space-y-4">
                        <div>
                            <x-input-label for="modal_token" value="Access Token" />
                            <div class="mt-1.5 flex gap-2">
                                <x-text-input wire:model="token" id="modal_token" type="text" class="w-full uppercase font-mono" placeholder="ENTER TOKEN" />
                                <x-secondary-button wire:click.prevent="generateRandomToken" type="button" class="whitespace-nowrap">
                                    Generate
                                </x-secondary-button>
                            </div>
                            <x-input-error :messages="$errors->get('token')" />
                        </div>

                        <div>
                            <x-input-label for="modal_token_duration" value="Token Validity Duration" />
                            <div class="mt-1.5">
                                <x-select wire:model="token_duration" id="modal_token_duration" class="w-full">
                                    <option value="1">1 Minute</option>
                                    <option value="5">5 Minutes</option>
                                    <option value="10">10 Minutes</option>
                                    <option value="15">15 Minutes</option>
                                    <option value="30">30 Minutes</option>
                                    <option value="60">1 Hour</option>
                                    <option value="1440">1 Day</option>
                                </x-select>
                                <x-input-error :messages="$errors->get('token_duration')" />
                            </div>
                            <p class="mt-1 text-xs text-slate-500">Token will expire after this duration from now.</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>
                <x-primary-button wire:click="saveToken" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveToken">Save Changes</span>
                    <span wire:loading.flex wire:target="saveToken" class="items-center">
                        <x-loading-spinner />
                        Saving...
                    </span>
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>
