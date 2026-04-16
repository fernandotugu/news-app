<?php

use App\Services\NewsSearchService;
use App\Services\NewsService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

uses(TestCase::class);

it('returns paginated list on api index', function () {
    $newsService = \Mockery::mock(NewsService::class);
    $newsSearchService = \Mockery::mock(NewsSearchService::class);

    $paginator = new LengthAwarePaginator(
        collect([
            ['id' => 1, 'title' => 'News 1'],
            ['id' => 2, 'title' => 'News 2'],
        ]),
        2,
        6,
        1
    );

    $newsService->shouldReceive('getPublishedPaginated')
        ->once()
        ->with(6)
        ->andReturn($paginator);

    $this->app->instance(NewsService::class, $newsService);
    $this->app->instance(NewsSearchService::class, $newsSearchService);

    $response = $this->getJson('/api/news');

    $response->assertOk()
        ->assertJsonStructure(['data', 'links', 'current_page', 'per_page', 'total']);
});

it('delegates api search to NewsSearchService', function () {
    $newsService = \Mockery::mock(NewsService::class);
    $newsSearchService = \Mockery::mock(NewsSearchService::class);

    $paginator = new LengthAwarePaginator(
        collect([
            ['id' => 1, 'title' => 'Laravel <mark>News</mark>'],
        ]),
        1,
        10,
        1
    );

    $newsSearchService->shouldReceive('searchWithHighlight')
        ->once()
        ->with('news', 10)
        ->andReturn($paginator);

    $this->app->instance(NewsService::class, $newsService);
    $this->app->instance(NewsSearchService::class, $newsSearchService);

    $response = $this->getJson('/api/news/search?search=news');

    $response->assertOk()
        ->assertJsonStructure(['data', 'links', 'current_page', 'per_page', 'total']);
});

afterEach(function () {
    \Mockery::close();
});

