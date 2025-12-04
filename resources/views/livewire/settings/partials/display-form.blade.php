{{-- Display Settings Form --}}
<div class="space-y-5">
    {{-- Date Format --}}
    <div>
        <x-input-label for="date_format" value="Date Format" />
        <div class="mt-1.5">
            <x-select wire:model="date_format" id="date_format">
                <option value="d/m/Y">DD/MM/YYYY ({{ now()->format('d/m/Y') }})</option>
                <option value="m/d/Y">MM/DD/YYYY ({{ now()->format('m/d/Y') }})</option>
                <option value="Y-m-d">YYYY-MM-DD ({{ now()->format('Y-m-d') }})</option>
                <option value="d F Y">DD Month YYYY ({{ now()->format('d F Y') }})</option>
                <option value="F d, Y">Month DD, YYYY ({{ now()->format('F d, Y') }})</option>
            </x-select>
            <p class="mt-2 text-xs text-slate-500">Format for displaying dates throughout the application</p>
            <x-input-error :messages="$errors->get('date_format')" />
        </div>
    </div>

    {{-- Items Per Page --}}
    <div>
        <x-input-label for="items_per_page" value="Items Per Page" />
        <div class="mt-1.5">
            <x-select wire:model="items_per_page" id="items_per_page">
                <option value="5">5 items</option>
                <option value="10">10 items</option>
                <option value="15">15 items</option>
                <option value="20">20 items</option>
                <option value="25">25 items</option>
                <option value="50">50 items</option>
                <option value="100">100 items</option>
            </x-select>
            <p class="mt-2 text-xs text-slate-500">Number of items to display per page in tables and lists</p>
            <x-input-error :messages="$errors->get('items_per_page')" />
        </div>
    </div>
</div>
