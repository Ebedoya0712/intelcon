<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Gestión')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('partials.navbar')
    @include('partials.sidebar')

    <div class="content-wrapper p-4">
        @yield('content')
    </div>

    @include('partials.footer')

</div>

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
