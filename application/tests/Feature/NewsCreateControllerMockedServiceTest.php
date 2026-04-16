<?php

use App\Services\NewsCategoryService;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

uses(TestCase::class);

it('renders create page using NewsCategoryService without direct repository coupling', function () {
    $service = \Mockery::mock(NewsCategoryService::class);

    $categories = new Collection([
        (object) ['id' => 1, 'name' => 'A - Primeira'],
        (object) ['id' => 2, 'name' => 'Z - Ultima'],
    ]);

    $service->shouldReceive('getAllOrdered')
        ->once()
        ->andReturn($categories);

    $this->app->instance(NewsCategoryService::class, $service);

    $response = $this->get(route('news.create'));

    $response->assertOk()
        ->assertViewIs('news.create')
        ->assertViewHas('categories');
});

afterEach(function () {
    \Mockery::close();
});

