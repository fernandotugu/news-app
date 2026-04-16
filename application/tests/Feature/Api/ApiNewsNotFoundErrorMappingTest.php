<?php

use App\Exceptions\NewsNotFoundException;
use App\Services\NewsService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

uses(TestCase::class);

it('maps NewsNotFoundException to 404 json on api routes', function () {
    $newsService = \Mockery::mock(NewsService::class);
    $newsSearchService = \Mockery::mock(\App\Services\NewsSearchService::class);

    // endpoint /api/news uses this method; provide happy path for this call
    $paginator = new LengthAwarePaginator(collect([]), 0, 6, 1);
    $newsService->shouldReceive('getPublishedPaginated')
        ->andReturn($paginator);

    // call a route that depends on NewsService and throws domain not found
    $newsSearchService->shouldReceive('searchWithHighlight')
        ->once()
        ->with('missing', 10)
        ->andThrow(new NewsNotFoundException('Notícia não encontrada.'));

    $this->app->instance(NewsService::class, $newsService);
    $this->app->instance(\App\Services\NewsSearchService::class, $newsSearchService);

    $response = $this->getJson('/api/news/search?search=missing');

    $response->assertStatus(404)
        ->assertJsonPath('message', 'Notícia não encontrada.');
});

afterEach(function () {
    \Mockery::close();
});

