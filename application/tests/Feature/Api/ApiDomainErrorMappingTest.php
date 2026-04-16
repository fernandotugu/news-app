<?php

use App\Exceptions\NewsSearchException;
use App\Services\NewsService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

uses(TestCase::class);

it('maps DomainException to 422 json on api routes', function () {
    $newsService = \Mockery::mock(NewsService::class);
    $newsSearchService = \Mockery::mock(\App\Services\NewsSearchService::class);

    $paginator = new LengthAwarePaginator(collect([]), 0, 6, 1);
    $newsService->shouldReceive('getPublishedPaginated')
        ->andReturn($paginator);

    $newsSearchService->shouldReceive('searchWithHighlight')
        ->once()
        ->with('explode', 10)
        ->andThrow(new NewsSearchException('Erro ao buscar notícias.'));

    $this->app->instance(NewsService::class, $newsService);
    $this->app->instance(\App\Services\NewsSearchService::class, $newsSearchService);

    $response = $this->getJson('/api/news/search?search=explode');

    $response->assertStatus(422)
        ->assertJsonPath('message', 'Erro ao buscar notícias.');
});

afterEach(function () {
    \Mockery::close();
});

