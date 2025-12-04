{{-- General Settings Form --}}
<div class="space-y-5">
    {{-- Logo Upload --}}
    <div>
        <x-input-label for="logo" value="Application Logo" />
        
        @if ($current_logo)
            <div class="mt-3 mb-4">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 overflow-hidden">
                        <img src="{{ asset('storage/' . $current_logo) }}" alt="Current Logo" class="h-full w-full object-cover">
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-900">Current Logo</p>
                        <p class="text-xs text-slate-500 mt-1">{{ basename($current_logo) }}</p>
                    </div>
                    <button type="button" wire:click="removeLogo" class="text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">
                        Remove
                    </button>
                </div>
            </div>
        @endif

        <div class="mt-1.5">
            <input wire:model="logo" id="logo" type="file" accept="image/*" class="block w-full text-sm text-slate-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-lg file:border-0
                file:text-sm file:font-semibold
                file:bg-indigo-50 file:text-indigo-700
                hover:file:bg-indigo-100
                file:cursor-pointer cursor-pointer
                transition-colors" />
            <p class="mt-2 text-xs text-slate-500">Recommended: Square image, max 2MB (PNG, JPG, SVG)</p>
            <x-input-error :messages="$errors->get('logo')" />
            
            @if ($logo)
                <div class="mt-4">
                    <p class="text-sm font-medium text-slate-900 mb-2">Preview:</p>
                    <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 overflow-hidden">
                        <img src="{{ $logo->temporaryUrl() }}" alt="Logo Preview" class="h-full w-full object-cover">
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Application Name --}}
    <div>
        <x-input-label for="app_name" value="Application Name" />
        <div class="mt-1.5">
            <x-text-input wire:model="app_name" id="app_name" type="text" placeholder="MowardCBT" />
            <p class="mt-2 text-xs text-slate-500">This name will be displayed throughout the application</p>
            <x-input-error :messages="$errors->get('app_name')" />
        </div>
    </div>

    {{-- Description --}}
    <div>
        <x-input-label for="app_description" value="Application Description" />
        <div class="mt-1.5">
            <textarea wire:model="app_description" id="app_description" rows="3" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
            <p class="mt-2 text-xs text-slate-500">Brief description of your application</p>
            <x-input-error :messages="$errors->get('app_description')" />
        </div>
    </div>

    {{-- Contact Email --}}
    <div>
        <x-input-label for="contact_email" value="Contact Email" />
        <div class="mt-1.5">
            <x-text-input wire:model="contact_email" id="contact_email" type="email" placeholder="admin@mowardcbt.com" />
            <p class="mt-2 text-xs text-slate-500">Support email for user inquiries</p>
            <x-input-error :messages="$errors->get('contact_email')" />
        </div>
    </div>

    {{-- Timezone --}}
    <div>
        <x-input-label for="timezone" value="Timezone" />
        <div class="mt-1.5">
            <x-select wire:model="timezone" id="timezone">
                <option value="Asia/Jakarta">Asia/Jakarta (WIB)</option>
                <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                <option value="UTC">UTC</option>
            </x-select>
            <p class="mt-2 text-xs text-slate-500">Application timezone for dates and times</p>
            <x-input-error :messages="$errors->get('timezone')" />
        </div>
    </div>

    {{-- Language --}}
    <div>
        <x-input-label for="language" value="Language" />
        <div class="mt-1.5">
            <x-select wire:model="language" id="language">
                <option value="id">Indonesian</option>
                <option value="en">English</option>
            </x-select>
            <p class="mt-2 text-xs text-slate-500">Default application language</p>
            <x-input-error :messages="$errors->get('language')" />
        </div>
    </div>

    {{-- Login Method --}}
    <div>
        <x-input-label for="login_method" value="Login Method" />
        <div class="mt-1.5">
            <x-select wire:model="login_method" id="login_method">
                <option value="email">Email Address</option>
                <option value="username">Username</option>
            </x-select>
            <p class="mt-2 text-xs text-slate-500">Choose how users will login to the system</p>
            <x-input-error :messages="$errors->get('login_method')" />
        </div>
    </div>
</div>
