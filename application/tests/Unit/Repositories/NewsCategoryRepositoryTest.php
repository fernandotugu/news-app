<?php

use App\Models\NewsCategory;
use App\Repositories\NewsCategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('returns categories ordered by name', function () {
    NewsCategory::create(['name' => 'Z', 'description' => 'z', 'active' => true]);
    NewsCategory::create(['name' => 'A', 'description' => 'a', 'active' => true]);
    NewsCategory::create(['name' => 'M', 'description' => 'm', 'active' => true]);

    $repository = app(NewsCategoryRepository::class);
    $result = $repository->getOrderedByName();

    expect($result->pluck('name')->all())->toBe(['A', 'M', 'Z']);
});

