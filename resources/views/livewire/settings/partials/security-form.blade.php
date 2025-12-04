{{-- Security Settings Form --}}
<div class="space-y-5">
    {{-- Enable Safe Browser --}}
    <div>
        <label class="flex items-start gap-3">
            <input type="checkbox" wire:model="enable_safe_browser" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
            <div class="flex-1">
                <span class="text-sm font-medium text-slate-900">Require Safe Browser</span>
                <p class="text-xs text-slate-500 mt-1">Require students to use a secure exam browser when taking tests</p>
            </div>
        </label>
        <x-input-error :messages="$errors->get('enable_safe_browser')" />
    </div>

    {{-- Enable Cheating Detection --}}
    <div>
        <label class="flex items-start gap-3">
            <input type="checkbox" wire:model="enable_cheating_detection" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
            <div class="flex-1">
                <span class="text-sm font-medium text-slate-900">Enable Cheating Detection</span>
                <p class="text-xs text-slate-500 mt-1">Monitor tab switching and window focus during tests</p>
            </div>
        </label>
        <x-input-error :messages="$errors->get('enable_cheating_detection')" />
    </div>

    {{-- Max Login Attempts --}}
    <div>
        <x-input-label for="max_login_attempts" value="Maximum Login Attempts" />
        <div class="mt-1.5">
            <x-text-input wire:model="max_login_attempts" id="max_login_attempts" type="number" min="1" max="10" placeholder="5" />
            <p class="mt-2 text-xs text-slate-500">Number of failed login attempts before account lockout</p>
            <x-input-error :messages="$errors->get('max_login_attempts')" />
        </div>
    </div>

    {{-- Session Timeout --}}
    <div>
        <x-input-label for="session_timeout" value="Session Timeout (minutes)" />
        <div class="mt-1.5">
            <x-text-input wire:model="session_timeout" id="session_timeout" type="number" min="5" max="1440" placeholder="120" />
            <p class="mt-2 text-xs text-slate-500">How long users stay logged in (5-1440 minutes)</p>
            <x-input-error :messages="$errors->get('session_timeout')" />
        </div>
    </div>
</div>
