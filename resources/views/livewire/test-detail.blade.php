<div>
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('student.dashboard') }}" wire:navigate class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Test Header -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $test->name }}</h1>
                        <p class="text-slate-600">{{ $test->description }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Active
                    </span>
                </div>
            </div>

            <!-- Test Information -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Test Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Total Questions</p>
                            <p class="text-xl font-bold text-slate-900">{{ $this->getTotalQuestions() }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Duration</p>
                            <p class="text-xl font-bold text-slate-900">{{ $test->duration }} minutes</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Maximum Score</p>
                            <p class="text-xl font-bold text-slate-900">{{ $test->max_score }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Available Until</p>
                            <p class="text-xl font-bold text-slate-900">{{ $test->end_date->format('M d, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Instructions</h2>
                
                <div class="prose prose-slate max-w-none">
                    <ul class="space-y-2">
                        <li>Read each question carefully before answering</li>
                        <li>You have <strong>{{ $test->duration }} minutes</strong> to complete this test</li>
                        <li>The test will be automatically submitted when time runs out</li>
                        <li>You can navigate between questions using the navigation panel</li>
                        <li>Make sure to review your answers before submitting</li>
                        @if($test->show_results)
                            <li>Results will be available immediately after submission</li>
                        @else
                            <li>Results will be available after the instructor reviews your submission</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Start Test Card -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Ready to Start?</h3>
                
                @if($test->use_token)
                    <div class="mb-4">
                        <x-input-label for="accessToken" :value="__('Access Token Required')" class="mb-2" />
                        <x-text-input 
                            wire:model="accessToken" 
                            id="accessToken" 
                            class="block w-full" 
                            type="text" 
                            placeholder="Enter access token" 
                        />
                        <x-input-error :messages="$errors->get('accessToken')" class="mt-2" />
                    </div>
                @endif

                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $this->getTotalQuestions() }} questions</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $test->duration }} minutes</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                        <span>Max score: {{ $test->max_score }}</span>
                    </div>
                </div>

                <button 
                    wire:click="startTest" 
                    wire:loading.attr="disabled"
                    class="w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove wire:target="startTest">Start Test Now</span>
                    <span wire:loading wire:target="startTest" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Starting...
                    </span>
                </button>

                <p class="mt-4 text-xs text-center text-slate-500">
                    By starting this test, you agree to complete it within the allocated time
                </p>
            </div>
        </div>
    </div>

    <!-- Confirmation Dialog -->
    @if($showConfirmation)
    <div 
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div 
                class="fixed inset-0 bg-slate-500 bg-opacity-75 transition-opacity" 
                wire:click="$set('showConfirmation', false)"
            ></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div 
                class="relative inline-block align-bottom bg-white rounded-2xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 z-50"
            >
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-semibold leading-6 text-slate-900" id="modal-title">
                            Start Test?
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-slate-500">
                                Are you ready to begin <strong>{{ $test->name }}</strong>? Once you start, the timer will begin and you'll have <strong>{{ $test->duration }} minutes</strong> to complete the test.
                            </p>
                            <div class="mt-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <p class="text-xs text-yellow-800">
                                    <strong>Important:</strong> Make sure you have a stable internet connection and won't be interrupted during the test.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse gap-3">
                    <button 
                        wire:click="confirmStartTest"
                        type="button" 
                        class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Yes, Start Test
                    </button>
                    <button 
                        wire:click="$set('showConfirmation', false)"
                        type="button" 
                        class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
