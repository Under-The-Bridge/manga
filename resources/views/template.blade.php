<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-utilities.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-reboot.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-grid.css.map') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>WebManga</title>
</head>


<body>
    @include('header')
    <main class="container mt-4">
        @yield('content')
    </main>
    @include('footer')
</body>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>

</html>
