<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0d0d0d">
    <title>@yield('title', 'WebManga — читать мангу')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/script.js') }}" defer></script>
</head>
<body>
    <a class="skip-link" href="#main-content">К содержимому</a>
    @include('header')
    <main id="main-content" class="page-main @yield('page-class')">
        @if(session('status'))<p class="status-message container" role="status">{{ session('status') }}</p>@endif
        @yield('content')
    </main>
    @include('footer')
    <dialog id="site-dialog" class="site-dialog" aria-labelledby="dialog-title">
        <button class="dialog-close" type="button" data-close-dialog aria-label="Закрыть">×</button>
        <h2 id="dialog-title"></h2>
        <p id="dialog-copy"></p>
    </dialog>
</body>
</html>
