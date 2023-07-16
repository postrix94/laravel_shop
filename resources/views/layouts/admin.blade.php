@includeIf('admin.partials.header')

<!-- Preloader -->
{{--<div class="preloader flex-column justify-content-center align-items-center">--}}
{{--    <img class="animation__wobble" src="{{Vite::asset('resources/images/admin/AdminLTELogo.png')}}" alt="AdminLTELogo"--}}
{{--         height="60" width="60">--}}
{{--</div>--}}

@includeIf('admin.navigation.navbar')

@includeIf('admin.navigation.sidenav')

{{$slot}}

@includeIf('admin.partials.fixed_plugin')

@includeIf('admin.partials.footer')
