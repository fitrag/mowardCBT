@props(['header'])

<div class="overflow-hidden shadow-sm ring-1 ring-slate-200 rounded-2xl bg-white">
    <table class="min-w-full divide-y divide-slate-100">
        <thead class="bg-slate-50/50">
            <tr>
                {{ $header }}
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 bg-white">
            {{ $slot }}
        </tbody>
    </table>
</div>
