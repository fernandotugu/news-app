<?php

use App\Exceptions\NewsNotFoundException;
use App\Exceptions\NewsSearchException;
use App\Models\News;
use App\Repositories\NewsRepository;
use App\Services\NewsService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

it('maps model not found to domain exception', function () {
    $repository = Mockery::mock(NewsRepository::class);
    $repository->shouldReceive('findByUuidWithCategory')
        ->once()
        ->with('missing-uuid')
        ->andThrow(new ModelNotFoundException());

    $service = new NewsService($repository);

    $service->getByUuidWithCategory('missing-uuid');
})->throws(NewsNotFoundException::class);

it('maps search infrastructure errors to domain exception', function () {
    $repository = Mockery::mock(NewsRepository::class);
    $repository->shouldReceive('searchApiPaginated')
        ->once()
        ->with('term', 10)
        ->andThrow(new RuntimeException('db failed'));

    $service = new NewsService($repository);

    $service->searchApi('term', 10);
})->throws(NewsSearchException::class);

it('returns homepage news from repository', function () {
    $repository = Mockery::mock(NewsRepository::class);
    $collection = new Collection([
        new News(),
        new News(),
    ]);

    $repository->shouldReceive('getPublishedLatest')
        ->once()
        ->with(6)
        ->andReturn($collection);

    $service = new NewsService($repository);
    $result = $service->getHomepageNews(6);

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result)->toHaveCount(2);
});

it('returns published paginated news from repository', function () {
    $repository = Mockery::mock(NewsRepository::class);
    $paginator = Mockery::mock(LengthAwarePaginator::class);

    $repository->shouldReceive('getPublishedPaginated')
        ->once()
        ->with(6)
        ->andReturn($paginator);

    $service = new NewsService($repository);
    $result = $service->getPublishedPaginated(6);

    expect($result)->toBe($paginator);
});

it('maps web search infrastructure errors to domain exception', function () {
    $repository = Mockery::mock(NewsRepository::class);
    $repository->shouldReceive('searchWebPaginated')
        ->once()
        ->with('term', 6)
        ->andThrow(new RuntimeException('db failed'));

    $service = new NewsService($repository);

    $service->searchWeb('term', 6);
})->throws(NewsSearchException::class);

afterEach(function () {
    \Mockery::close();
});

