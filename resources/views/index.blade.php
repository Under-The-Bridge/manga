@extends('template')
@section('page-class', 'home-page container')
@section('content')
    @if(request()->filled('q') || request()->filled('genre'))
        <section class="search-results" aria-labelledby="results-heading">
            <div class="section-heading"><h1 id="results-heading">{{ request()->filled('q') ? 'Результаты поиска' : request('genre') }}</h1><a class="accent-link" href="{{ route('home') }}">Сбросить</a></div>
            <div class="search-grid">
                @forelse($filtered as $slug => $item)
                    @include('partials.manga-card')
                @empty
                    <p class="muted">Манга не найдена. Попробуйте другое название.</p>
                @endforelse
            </div>
        </section>
    @else
        <section class="hero" aria-labelledby="hero-title">
            <img class="hero-cover" src="{{ asset('images/fullmetal.png') }}" width="256" height="355" alt="Обложка манги Стальной алхимик">
            <div class="hero-data">
                <h1 id="hero-title"><a href="{{ route('manga.show', 'fullmetal-alchemist') }}">Стальной алхимик <span class="hero-divider">|</span> <span class="hero-year">2001</span></a></h1>
                <p class="hero-description">{{ config('webmanga.description') }}</p>
                <div class="hero-genres">@foreach(['Боевик', 'Драма', 'Комедия', 'Научная фантастика'] as $genre)<a class="tag" href="{{ route('home', ['genre' => $genre]) }}">{{ $genre }}</a>@endforeach</div>
                <a class="hero-read button" href="{{ route('manga.show', 'fullmetal-alchemist') }}">Читать</a>
            </div>
        </section>
        @include('partials.manga-rail', ['id' => 'popular', 'heading' => 'Популярное'])
        @include('partials.manga-rail', ['id' => 'new', 'heading' => 'Новинки'])
        <section class="recent-section" id="chapters" aria-labelledby="recent-heading">
            <div class="section-heading"><h2 id="recent-heading">Новые главы</h2><a class="accent-link" href="{{ route('home') }}#popular">Все →</a></div>
            <div class="three-column">
                @foreach(array_slice($titles, 0, 3, true) as $slug => $item)
                    <a class="chapter-card" href="{{ route('manga.show', $slug) }}"><img src="{{ asset('images/'.$item['cover']) }}" alt="{{ $item['short'] }}" width="60" height="83" loading="lazy"><div><h3>{{ $item['short'] }}</h3><span class="accent-link">Новая глава →</span><p class="muted">Обновлено сегодня</p></div></a>
                @endforeach
            </div>
        </section>
        <section class="genre-section" id="genres" aria-labelledby="genre-heading">
            <div class="section-heading"><div><h2 id="genre-heading">Найди мангу по настроению</h2><p class="section-subtitle">Выбери жанр и попробуй что-то новое</p></div><a class="accent-link" href="#genres">Все жанры →</a></div>
            <div class="genre-grid">@foreach(['Боевик', 'Приключения', 'Фэнтези', 'Комедия', 'Романтика', 'Ужасы'] as $genre)<a href="{{ route('home', ['genre' => $genre]) }}">{{ $genre }}</a>@endforeach</div>
        </section>
        <section class="collection-section" id="collections" aria-labelledby="collection-heading">
            <div class="section-heading"><div><h2 id="collection-heading">Коллекции сообщества</h2><p class="section-subtitle">Подборки от читателей</p></div><a class="accent-link" href="#collections">Все коллекции →</a></div>
            <div class="three-column">
                @foreach([['Каждый должен прочитать', 'ramz', 12], ['Лучшие манги по моему мнению', 'pixies', 8], ['Манга с красивой рисовкой', 'mangalover', 16]] as $collection)
                    <a class="collection-card" href="{{ route('home') }}#popular">
                        <div class="collection-covers">@for($i = 0; $i < 3; $i++)@php($cover = array_values($titles)[($i + $loop->index) % 3])<img src="{{ asset('images/'.$cover['cover']) }}" width="106" height="128" alt="{{ $cover['short'] }}" loading="lazy">@endfor</div>
                        <h3>{{ $collection[0] }}</h3><div class="collection-meta"><span class="accent-link">от {{ '@'.$collection[1] }}</span><span>{{ $collection[2] }} тайтлов</span></div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection
