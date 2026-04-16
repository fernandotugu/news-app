<?php

use App\Repositories\NewsCategoryRepository;
use App\Services\NewsCategoryService;
use Illuminate\Database\Eloquent\Collection;

it('returns ordered categories from repository', function () {
    $repository = \Mockery::mock(NewsCategoryRepository::class);
    $categories = new Collection([
        (object) ['id' => 1, 'name' => 'A'],
        (object) ['id' => 2, 'name' => 'B'],
    ]);

    $repository->shouldReceive('getOrderedByName')
        ->once()
        ->andReturn($categories);

    $service = new NewsCategoryService($repository);
    $result = $service->getAllOrdered();

    expect($result)->toHaveCount(2);
    expect($result->first()->name)->toBe('A');
});

afterEach(function () {
    \Mockery::close();
});

