<section class="manga-group" id="{{ $id }}" aria-labelledby="{{ $id }}-heading">
    <div class="section-heading">
        <h2 id="{{ $id }}-heading"><a href="#{{ $id }}">{{ $heading }} →</a></h2>
        <div class="rail-controls"><button type="button" data-scroll="-1" aria-label="{{ $heading }}: назад">←</button><button type="button" data-scroll="1" aria-label="{{ $heading }}: вперёд">→</button></div>
    </div>
    <div class="manga-rail" tabindex="0" aria-label="{{ $heading }}">
        @foreach($rail as $slug)
            @include('partials.manga-card', ['item' => $titles[$slug], 'slug' => $slug])
        @endforeach
    </div>
</section>
