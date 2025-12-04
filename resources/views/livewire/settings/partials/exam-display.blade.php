{{-- Exam Settings Display --}}
<div class="bg-white shadow-sm ring-1 ring-slate-900/5 sm:rounded-xl">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-base font-semibold leading-6 text-slate-900 mb-5">Exam & Test Settings</h3>
        
        <dl class="divide-y divide-slate-100">
            {{-- Default Test Duration --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Default Test Duration</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="font-semibold">{{ $default_test_duration }} minutes</span>
                </dd>
            </div>

            {{-- Minimum Pass Score --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Minimum Pass Score</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    <span class="font-semibold">{{ $minimum_pass_score }}%</span>
                </dd>
            </div>

            {{-- Test Timer --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Test Timer</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    @if ($enable_test_timer)
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Enabled
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20">
                            Disabled
                        </span>
                    @endif
                </dd>
            </div>

            {{-- Allow Late Submission --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Allow Late Submission</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    @if ($allow_late_submission)
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Allowed
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                            Not Allowed
                        </span>
                    @endif
                </dd>
            </div>

            {{-- Show Correct Answers --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Show Correct Answers</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    @if ($show_correct_answers)
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Shown to Students
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20">
                            Hidden from Students
                        </span>
                    @endif
                </dd>
            </div>

            {{-- Show Score to Students --}}
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-slate-900">Show Score to Students</dt>
                <dd class="mt-1 text-sm text-slate-700 sm:col-span-2 sm:mt-0">
                    @if ($show_score_to_students)
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Shown to Students
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20">
                            Hidden from Students
                        </span>
                    @endif
                </dd>
            </div>
        </dl>
    </div>
</div>
