<header class="site-header">
    <nav class="container header-content" aria-label="Основная навигация">
        <div class="header-start">
            <a class="brand" href="{{ route('home') }}" aria-label="WebManga — главная">WebManga</a>
            <a class="catalog-link" href="{{ route('home') }}#popular">Каталог</a>
        </div>
        <div class="header-end">
            <form class="search-form" action="{{ route('home') }}" role="search">
                <label class="sr-only" for="site-search">Поиск манги</label>
                <input id="site-search" name="q" type="search" placeholder="Поиск" value="{{ request('q') }}" maxlength="100">
            </form>
            @auth
                <form action="{{ route('logout') }}" method="POST">@csrf<button class="auth-btn" type="submit">Выйти</button></form>
            @else
                <div class="auth-btn"><a href="{{ route('login') }}">Вход</a><span aria-hidden="true">|</span><a href="{{ route('register') }}">Регистрация</a></div>
            @endauth
        </div>
    </nav>
</header>
