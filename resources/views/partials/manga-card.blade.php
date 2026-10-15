<a class="manga-card" href="{{ route('manga.show', $slug) }}" title="{{ $item['title'] }}">
    <img src="{{ asset('images/'.$item['cover']) }}" width="160" height="221" alt="{{ $item['title'] }}" loading="lazy">
    <span>{{ $item['title'] }}</span>
</a>
