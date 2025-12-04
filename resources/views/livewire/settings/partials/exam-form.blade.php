{{-- Exam Settings Form --}}
<div class="space-y-5">
    {{-- Default Test Duration --}}
    <div>
        <x-input-label for="default_test_duration" value="Default Test Duration (minutes)" />
        <div class="mt-1.5">
            <x-text-input wire:model="default_test_duration" id="default_test_duration" type="number" min="1" max="600" placeholder="60" />
            <p class="mt-2 text-xs text-slate-500">Default duration applied when creating new tests</p>
            <x-input-error :messages="$errors->get('default_test_duration')" />
        </div>
    </div>

    {{-- Minimum Pass Score --}}
    <div>
        <x-input-label for="minimum_pass_score" value="Minimum Pass Score (%)" />
        <div class="mt-1.5">
            <x-text-input wire:model="minimum_pass_score" id="minimum_pass_score" type="number" min="0" max="100" placeholder="60" />
            <p class="mt-2 text-xs text-slate-500">Minimum percentage score required to pass a test</p>
            <x-input-error :messages="$errors->get('minimum_pass_score')" />
        </div>
    </div>

    {{-- Enable Test Timer --}}
    <div>
        <label class="flex items-start gap-3">
            <input type="checkbox" wire:model="enable_test_timer" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
            <div class="flex-1">
                <span class="text-sm font-medium text-slate-900">Enable Test Timer</span>
                <p class="text-xs text-slate-500 mt-1">Display countdown timer during tests</p>
            </div>
        </label>
        <x-input-error :messages="$errors->get('enable_test_timer')" />
    </div>

    {{-- Allow Late Submission --}}
    <div>
        <label class="flex items-start gap-3">
            <input type="checkbox" wire:model="allow_late_submission" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
            <div class="flex-1">
                <span class="text-sm font-medium text-slate-900">Allow Late Submission</span>
                <p class="text-xs text-slate-500 mt-1">Allow students to submit tests after the deadline has passed</p>
            </div>
        </label>
        <x-input-error :messages="$errors->get('allow_late_submission')" />
    </div>

    {{-- Show Correct Answers --}}
    <div>
        <label class="flex items-start gap-3">
            <input type="checkbox" wire:model="show_correct_answers" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
            <div class="flex-1">
                <span class="text-sm font-medium text-slate-900">Show Correct Answers</span>
                <p class="text-xs text-slate-500 mt-1">Show correct answers to students after test completion</p>
            </div>
        </label>
        <x-input-error :messages="$errors->get('show_correct_answers')" />
    </div>

    {{-- Show Score to Students --}}
    <div>
        <label class="flex items-start gap-3">
            <input type="checkbox" wire:model="show_score_to_students" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
            <div class="flex-1">
                <span class="text-sm font-medium text-slate-900">Show Score to Students</span>
                <p class="text-xs text-slate-500 mt-1">Display numeric score (points/percentage) to students in test results</p>
            </div>
        </label>
        <x-input-error :messages="$errors->get('show_score_to_students')" />
    </div>
</div>
