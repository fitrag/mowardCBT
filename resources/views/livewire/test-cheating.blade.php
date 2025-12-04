<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 to-orange-50 px-4">
    <div class="max-w-md w-full">
        <!-- Warning Icon -->
        <div class="flex justify-center mb-6">
            <div class="h-24 w-24 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
        </div>

        <!-- Content Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <h1 class="text-2xl font-bold text-red-600 mb-3">Cheating Detected!</h1>
            <h2 class="text-lg font-semibold text-slate-900 mb-4">{{ $test->name }}</h2>
            
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <p class="text-sm text-red-800 font-medium mb-2">⚠️ Test Automatically Terminated</p>
                <p class="text-sm text-red-700">
                    Your test has been automatically submitted because suspicious activity was detected.
                </p>
            </div>

            <div class="space-y-3 text-left mb-6">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Violation Detected:</p>
                        <p class="text-sm text-slate-600">Switching tabs or leaving the test window</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="h-5 w-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Action Taken:</p>
                        <p class="text-sm text-slate-600">Test submitted with current answers</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="h-5 w-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Next Steps:</p>
                        <p class="text-sm text-slate-600">Contact your instructor if you believe this was an error</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <a href="{{ route('student.dashboard') }}" wire:navigate class="block w-full">
                    <button class="w-full px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl transition-colors">
                        Return to Dashboard
                    </button>
                </a>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center">
            <p class="text-sm text-slate-600">
                This incident has been recorded and reported to your instructor.
            </p>
        </div>
    </div>
</div>
