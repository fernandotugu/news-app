<?php

use App\Services\NewsService;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

uses(TestCase::class);

it('renders homepage using NewsService', function () {
    $newsService = \Mockery::mock(NewsService::class);
    $initialNews = new Collection([
        (object) ['title' => 'News 1'],
        (object) ['title' => 'News 2'],
    ]);

    $newsService->shouldReceive('getHomepageNews')
        ->once()
        ->with(6)
        ->andReturn($initialNews);

    $this->app->instance(NewsService::class, $newsService);

    $response = $this->get(route('news.index'));

    $response->assertOk()
        ->assertViewIs('news.index')
        ->assertViewHas('initialNews');
});

afterEach(function () {
    \Mockery::close();
});

