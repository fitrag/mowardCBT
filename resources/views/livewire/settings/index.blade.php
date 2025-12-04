<div x-data="{ currentTab: @entangle('currentTab') }">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-slate-900">Settings</h1>
            <p class="mt-2 text-sm text-slate-500">Configure all aspects of your application</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <x-primary-button wire:click="openEdit" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="openEdit">Edit Settings</span>
                <span wire:loading.flex wire:target="openEdit" class="items-center">
                    <x-loading-spinner />
                    Loading...
                </span>
            </x-primary-button>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="mt-8 border-b border-slate-200">
        <nav class="-mb-px flex space-x-8">
            <button @click="currentTab = 'general'" 
                :class="currentTab === 'general' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    General
                </div>
            </button>

            <button @click="currentTab = 'exam'" 
                :class="currentTab === 'exam' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                    </svg>
                    Exam
                </div>
            </button>

            <button @click="currentTab = 'ai'" 
                :class="currentTab === 'ai' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                    </svg>
                    AI Generator
                </div>
            </button>

            <button @click="currentTab = 'security'" 
                :class="currentTab === 'security' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Security
                </div>
            </button>

            <button @click="currentTab = 'display'" 
                :class="currentTab === 'display' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                    </svg>
                    Display
                </div>
            </button>
        </nav>
    </div>

    {{-- Tab Content --}}
    <div class="mt-8">
        {{-- General Tab --}}
        <div x-show="currentTab === 'general'" x-cloak>
            <div class="grid grid-cols-1 gap-6">
                @include('livewire.settings.partials.general-display')
            </div>
        </div>

        {{-- Exam Tab --}}
        <div x-show="currentTab === 'exam'" x-cloak>
            <div class="grid grid-cols-1 gap-6">
                @include('livewire.settings.partials.exam-display')
            </div>
        </div>

        {{-- AI Tab --}}
        <div x-show="currentTab === 'ai'" x-cloak>
            <div class="grid grid-cols-1 gap-6">
                @include('livewire.settings.partials.ai-display')
            </div>
        </div>

        {{-- Security Tab --}}
        <div x-show="currentTab === 'security'" x-cloak>
            <div class="grid grid-cols-1 gap-6">
                @include('livewire.settings.partials.security-display')
            </div>
        </div>

        {{-- Display Tab --}}
        <div x-show="currentTab === 'display'" x-cloak>
            <div class="grid grid-cols-1 gap-6">
                @include('livewire.settings.partials.display-display')
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <x-modal name="settings-modal" focusable max-width="4xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-900">
                    Edit Settings
                </h2>
                <button x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Tab Navigation in Modal --}}
            <div class="border-b border-slate-200 mb-6">
                <nav class="-mb-px flex space-x-6 overflow-x-auto">
                    <button @click="currentTab = 'general'" 
                        :class="currentTab === 'general' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium">
                        General
                    </button>
                    <button @click="currentTab = 'exam'" 
                        :class="currentTab === 'exam' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium">
                        Exam
                    </button>
                    <button @click="currentTab = 'ai'" 
                        :class="currentTab === 'ai' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium">
                        AI
                    </button>
                    <button @click="currentTab = 'security'" 
                        :class="currentTab === 'security' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium">
                        Security
                    </button>
                    <button @click="currentTab = 'display'" 
                        :class="currentTab === 'display' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700'"
                        class="whitespace-nowrap border-b-2 px-1 py-3 text-sm font-medium">
                        Display
                    </button>
                </nav>
            </div>

            <div class="space-y-5 max-h-[60vh] overflow-y-auto pr-2">
                {{-- General Settings Form --}}
                <div x-show="currentTab === 'general'" x-cloak>
                    @include('livewire.settings.partials.general-form')
                </div>

                {{-- Exam Settings Form --}}
                <div x-show="currentTab === 'exam'" x-cloak>
                    @include('livewire.settings.partials.exam-form')
                </div>

                {{-- AI Settings Form --}}
                <div x-show="currentTab === 'ai'" x-cloak>
                    @include('livewire.settings.partials.ai-form')
                </div>

                {{-- Security Settings Form --}}
                <div x-show="currentTab === 'security'" x-cloak>
                    @include('livewire.settings.partials.security-form')
                </div>

                {{-- Display Settings Form --}}
                <div x-show="currentTab === 'display'" x-cloak>
                    @include('livewire.settings.partials.display-form')
                </div>
            </div>

            <div class="mt-8 flex justify-between gap-3">
                <x-secondary-button wire:click="resetToDefaults" wire:loading.attr="disabled" class="!bg-red-50 !text-red-700 hover:!bg-red-100">
                    <span wire:loading.remove wire:target="resetToDefaults">Reset to Defaults</span>
                    <span wire:loading.flex wire:target="resetToDefaults" class="items-center">
                        <x-loading-spinner />
                        Resetting...
                    </span>
                </x-secondary-button>
                
                <div class="flex gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>
                    <x-primary-button wire:click="save" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">Save All Changes</span>
                        <span wire:loading.flex wire:target="save" class="items-center">
                            <x-loading-spinner />
                            Saving...
                        </span>
                    </x-primary-button>
                </div>
            </div>
        </div>
    </x-modal>
</div>
