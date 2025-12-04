{{-- AI Generator Settings Form --}}
<div class="space-y-5">
    {{-- Enable AI Generator --}}
    <div>
        <label class="flex items-start gap-3">
            <input type="checkbox" wire:model="enable_ai_generator" class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
            <div class="flex-1">
                <span class="text-sm font-medium text-slate-900">Enable AI Generator</span>
                <p class="text-xs text-slate-500 mt-1">Allow AI-powered question generation from topics</p>
            </div>
        </label>
        <x-input-error :messages="$errors->get('enable_ai_generator')" />
    </div>

    {{-- AI Model --}}
    <div>
        <x-input-label for="ai_model" value="AI Model" />
        <div class="mt-1.5">
            <x-select wire:model="ai_model" id="ai_model">
                <option value="gemini-1.5-flash">Gemini 1.5 Flash (Fastest)</option>
                <option value="gemini-1.5-pro">Gemini 1.5 Pro (Most Capable)</option>
                <option value="gemini-2.0-flash-exp">Gemini 2.0 Flash (Experimental)</option>
            </x-select>
            <p class="mt-2 text-xs text-slate-500">AI model to use for question generation</p>
            <x-input-error :messages="$errors->get('ai_model')" />
        </div>
    </div>

    {{-- Temperature --}}
    <div>
        <x-input-label for="ai_temperature" value="Temperature" />
        <div class="mt-1.5">
            <x-text-input wire:model="ai_temperature" id="ai_temperature" type="number" step="0.1" min="0" max="1" placeholder="0.7" />
            <p class="mt-2 text-xs text-slate-500">Controls randomness: 0.0 = focused & deterministic, 1.0 = creative & diverse</p>
            <x-input-error :messages="$errors->get('ai_temperature')" />
        </div>
    </div>

    {{-- Max Tokens --}}
    <div>
        <x-input-label for="ai_max_tokens" value="Maximum Tokens" />
        <div class="mt-1.5">
            <x-text-input wire:model="ai_max_tokens" id="ai_max_tokens" type="number" min="100" max="8000" placeholder="2048" />
            <p class="mt-2 text-xs text-slate-500">Maximum length of AI responses (100-8000)</p>
            <x-input-error :messages="$errors->get('ai_max_tokens')" />
        </div>
    </div>
</div>
