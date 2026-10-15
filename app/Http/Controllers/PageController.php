<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate(['q' => ['nullable', 'string', 'max:100'], 'genre' => ['nullable', 'string', 'max:100']]);
        $titles = config('webmanga.titles');
        $filtered = collect($titles)->filter(function (array $item) use ($request) {
            return (! $request->filled('q') || mb_stripos($item['title'], trim($request->string('q')->toString())) !== false)
                && (! $request->filled('genre') || in_array($request->string('genre')->toString(), $item['genres'], true));
        });

        return view('index', ['titles' => $titles, 'filtered' => $filtered, 'rail' => ['steel-ball-run', 'hellsing', 'made-in-abyss', 'steel-ball-run', 'hellsing', 'made-in-abyss', 'steel-ball-run']]);
    }

    public function show(string $slug): View
    {
        $titles = config('webmanga.titles');
        abort_unless(isset($titles[$slug]), 404);

        return view('manga', ['manga' => $titles[$slug], 'slug' => $slug, 'isFullmetal' => $slug === 'fullmetal-alchemist']);
    }
}
