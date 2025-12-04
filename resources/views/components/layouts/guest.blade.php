<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ \App\Models\Setting::get('app_description', 'MowardCBT - Computer Based Test Application') }}">
    <title>{{ $title ?? 'MowardCBT' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">
    {{ $slot }}
</body>
</html>
