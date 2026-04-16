<?php

use App\Services\NewsSearchService;
use App\Services\NewsService;
use Illuminate\Pagination\LengthAwarePaginator;

it('returns paginator unchanged when search term is empty', function () {
    $newsService = \Mockery::mock(NewsService::class);

    $paginator = new LengthAwarePaginator(
        collect([(object) ['title' => 'Laravel News', 'category' => (object) ['name' => 'Tech']]]),
        1,
        10,
        1
    );

    $newsService->shouldReceive('searchApi')
        ->once()
        ->with(null, 10)
        ->andReturn($paginator);

    $service = new NewsSearchService($newsService);
    $result = $service->searchWithHighlight(null, 10);

    expect($result->items()[0]->title)->toBe('Laravel News');
    expect($result->items()[0]->category->name)->toBe('Tech');
});

it('applies highlight to title and category name when term is informed', function () {
    $newsService = \Mockery::mock(NewsService::class);

    $paginator = new LengthAwarePaginator(
        collect([(object) ['title' => 'Laravel News', 'category' => (object) ['name' => 'Tech News']]]),
        1,
        10,
        1
    );

    $newsService->shouldReceive('searchApi')
        ->once()
        ->with('news', 10)
        ->andReturn($paginator);

    $service = new NewsSearchService($newsService);
    $result = $service->searchWithHighlight('news', 10);

    expect($result->items()[0]->title)->toBe('Laravel <mark>News</mark>');
    expect($result->items()[0]->category->name)->toBe('Tech <mark>News</mark>');
});

it('applies highlight only to title when category is missing', function () {
    $newsService = \Mockery::mock(NewsService::class);

    $paginator = new LengthAwarePaginator(
        collect([(object) ['title' => 'Breaking News']]),
        1,
        10,
        1
    );

    $newsService->shouldReceive('searchApi')
        ->once()
        ->with('news', 10)
        ->andReturn($paginator);

    $service = new NewsSearchService($newsService);
    $result = $service->searchWithHighlight('news', 10);

    expect($result->items()[0]->title)->toBe('Breaking <mark>News</mark>');
});

afterEach(function () {
    \Mockery::close();
});

