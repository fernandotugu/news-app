<?php

use App\Services\NewsService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

uses(TestCase::class);

it('renders search results using NewsService with query string', function () {
    $newsService = \Mockery::mock(NewsService::class);

    $paginator = new LengthAwarePaginator(
        collect([(object) [
            'title' => 'Laravel Search',
            'content' => 'Conteúdo da notícia mockada para render da view.',
            'uuid' => 'mock-uuid-1',
            'category' => (object) ['name' => 'Tech'],
        ]]),
        1,
        6,
        1
    );

    $newsService->shouldReceive('searchWeb')
        ->once()
        ->with('Laravel', 6)
        ->andReturn($paginator);

    $this->app->instance(NewsService::class, $newsService);

    $response = $this->get('/news/search?q=Laravel');

    $response->assertOk()
        ->assertViewIs('news.search-results')
        ->assertViewHas('query', 'Laravel')
        ->assertViewHas('news');
});

afterEach(function () {
    \Mockery::close();
});

