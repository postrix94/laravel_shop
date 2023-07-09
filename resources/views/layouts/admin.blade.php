<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{Vite::asset('resources/images/admin/favicon.png')}}" />

    <title>{{ $title ?? "Admin Panel" }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/admin/app.scss', 'resources/js/admin/app.js'])
</head>
<body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
    @includeIf('admin.navigation.sidenav')
    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
        @includeIf('admin.navigation.navbar')
        {{ $slot }}
    </main>
    @includeIf('admin.partials.fixed_plugin')
</body>
</html>
