<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Gestión')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    @include('partials.navbar')
    @include('partials.sidebar')

    <div class="content-wrapper">
        <section class="content pt-3 px-3">
            @yield('content')
        </section>
    </div>

    @include('partials.footer')

</div>
@stack('scripts')
</body>
</html>
