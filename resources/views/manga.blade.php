@extends('template')
@section('title', $manga['title'].' — WebManga')
@section('page-class', 'detail-page container')
@section('content')
    <section class="detail-banner {{ $isFullmetal ? 'fullmetal-banner' : 'plain-banner' }}" aria-labelledby="manga-title">
        <div class="detail-heading"><div><h1 id="manga-title">{{ $manga['title'] }}</h1>@if($isFullmetal)<p>Hagane no Renkinjutsushi</p>@endif</div>
            @if($isFullmetal)<div class="title-rating"><strong>★ 9.74 <span>· 9.3 K</span></strong><button type="button" data-dialog-title="Оценить тайтл" data-dialog-copy="Возможность оценивать мангу появится после подключения читательских оценок.">Оценить тайтл</button></div>@endif
        </div>
    </section>
    <div class="detail-columns">
        <aside class="manga-sidebar" aria-label="Информация о манге">
            <img class="detail-cover" src="{{ asset('images/'.($isFullmetal ? 'detail-cover.jpg' : $manga['cover'])) }}" alt="{{ $manga['title'] }}" width="244" height="342">
            <button class="button start-reading" type="button" data-select-tab="chapters-panel">Начать читать @if($isFullmetal)<small>· 0 / 111</small>@endif</button>
            <button class="plan-button" type="button" data-plan="{{ $slug }}" aria-pressed="false">+ Добавить в планы ⌄</button>
            <dl class="manga-metadata">
                @if($isFullmetal)
                    @foreach(['Тип' => 'Манга', 'Выпуск' => '2001 г.', 'Глав' => '111', 'Статус' => 'Завершён', 'Перевод' => 'Завершён', 'Франшиза' => 'Fullmetal Alchemist', 'Автор и художник' => 'Hiromu Arakawa', 'Издатели' => 'Square Enix · Азбука · Yen Press · Эксмо · Viz', 'Альтернативные названия' => 'Alchemist of Steel'] as $label => $value)<div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>@endforeach
                @else
                    <div><dt>Тип</dt><dd>Манга</dd></div><div><dt>Название</dt><dd>{{ $manga['short'] }}</dd></div>
                @endif
            </dl>
        </aside>
        <section class="manga-content" aria-label="О тайтле">
            <div class="title-tabs" role="tablist" aria-label="Разделы тайтла">
                @foreach(['about-panel' => 'О тайтле', 'chapters-panel' => 'Главы', 'comments-panel' => 'Комментарии', 'discussions-panel' => 'Обсуждения', 'cards-panel' => 'Карты', 'reviews-panel' => 'Отзывы'] as $id => $label)<button type="button" id="tab-{{ $id }}" role="tab" aria-controls="{{ $id }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" tabindex="{{ $loop->first ? '0' : '-1' }}">{{ $label }}</button>@endforeach
            </div>
            <div id="about-panel" class="tab-panel about-panel" role="tabpanel" aria-labelledby="tab-about-panel">
                <p class="manga-description">{{ $isFullmetal ? config('webmanga.description') : 'Описание тайтла пока не добавлено.' }}</p>
                <div class="detail-genres">@if($isFullmetal)<span class="tag">16+</span>@endif @foreach($manga['genres'] as $genre)<a class="tag" href="{{ route('home', ['genre' => $genre]) }}">{{ $genre }}</a>@endforeach</div>
                @if($isFullmetal)
                    <div class="detail-tags">@foreach(['Алхимия', 'Армия', 'Военные', 'Дружба', 'Жестокий мир'] as $tag)<span class="tag"># {{ $tag }}</span>@endforeach<span class="tag">+ ещё 5</span></div>
                    <p class="content-notice">Незаконное потребление наркотических средств, психотропных веществ, их аналогов причиняет вред здоровью, их незаконный оборот запрещён и влечёт установленную законодательством ответственность</p>
                    <section class="translators"><h2>Переводчики</h2><div>@foreach(['Inu-Nora', 'Bakuhatsu Maniacs', 'Death Note - KIRA Revival Project', 'Ё-team'] as $team)<span class="tag">{{ $team }}</span>@endforeach</div></section>
                    <div class="manga-statistics">
                        <section><h2>Оценки пользователей <span>★ 9.74</span></h2><div class="stat-list ratings-list">
                            @foreach([[10, 86.7, 8072], [9, 6.5, 602], [8, 4.6, 428], [7, 1, 95], [6, .4, 40], [5, .2, 16], [4, .1, 13], [3, 0, 4], [2, 0, 4], [1, .3, 32]] as [$score, $percentage, $count])
                                @include('partials.stat-row', ['label' => $score.' ★'])
                            @endforeach
                        </div></section>
                        <section><h2>В списках у 103477 человек</h2><div class="stat-list reader-list">
                            @foreach([['Читаю', 16.8, 17359], ['В планах', 37.9, 39253], ['Брошено', 1.7, 1776], ['Прочитано', 20.9, 21678], ['Любимые', 17, 17557], ['Другое', 5.7, 5854]] as [$label, $percentage, $count])
                                @include('partials.stat-row')
                            @endforeach
                        </div></section>
                    </div>
                @endif
            </div>
            @foreach(['chapters-panel' => ['Главы', 'Главы пока не загружены.'], 'comments-panel' => ['Комментарии', 'Комментариев пока нет.'], 'discussions-panel' => ['Обсуждения', 'Обсуждений пока нет.'], 'cards-panel' => ['Карты', 'Карты пока не добавлены.'], 'reviews-panel' => ['Отзывы', 'Отзывов пока нет.']] as $id => [$heading, $copy])
                <div id="{{ $id }}" class="tab-panel empty-panel" role="tabpanel" aria-labelledby="tab-{{ $id }}" hidden><h2>{{ $heading }}</h2><p class="muted">{{ $copy }}</p></div>
            @endforeach
        </section>
    </div>
@endsection
