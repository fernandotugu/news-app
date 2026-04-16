<?php

use App\Models\News;
use App\Models\NewsCategory;
use App\Repositories\NewsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('returns only published latest news with limit', function () {
    $category = NewsCategory::factory()->create();

    News::factory()->create([
        'category_id' => $category->id,
        'title' => 'Old published',
        'published_at' => now()->subDays(2),
    ]);

    News::factory()->create([
        'category_id' => $category->id,
        'title' => 'Latest published',
        'published_at' => now()->subDay(),
    ]);

    News::factory()->create([
        'category_id' => $category->id,
        'title' => 'Draft',
        'published_at' => null,
    ]);

    $repository = app(NewsRepository::class);
    $result = $repository->getPublishedLatest(2);

    expect($result)->toHaveCount(2);
    expect($result->pluck('title')->all())->toBe(['Latest published', 'Old published']);
});

it('returns paginated published news ordered by latest publication date', function () {
    $category = NewsCategory::factory()->create();

    News::factory()->create([
        'category_id' => $category->id,
        'title' => 'P1',
        'published_at' => now()->subDays(3),
    ]);
    News::factory()->create([
        'category_id' => $category->id,
        'title' => 'P2',
        'published_at' => now()->subDays(1),
    ]);
    News::factory()->create([
        'category_id' => $category->id,
        'title' => 'Draft',
        'published_at' => null,
    ]);

    $repository = app(NewsRepository::class);
    $result = $repository->getPublishedPaginated(10);

    expect($result->total())->toBe(2);
    expect(collect($result->items())->pluck('title')->all())->toBe(['P2', 'P1']);
});

it('searches api by title and category name', function () {
    $sports = NewsCategory::factory()->create(['name' => 'Sports']);
    $tech = NewsCategory::factory()->create(['name' => 'Tech']);

    News::factory()->create([
        'title' => 'Match Day',
        'category_id' => $sports->id,
    ]);
    News::factory()->create([
        'title' => 'Framework Release',
        'category_id' => $tech->id,
    ]);

    $repository = app(NewsRepository::class);

    $byTitle = $repository->searchApiPaginated('Match', 10);
    $byCategory = $repository->searchApiPaginated('Sports', 10);

    expect($byTitle->total())->toBeGreaterThanOrEqual(1);
    expect($byCategory->total())->toBeGreaterThanOrEqual(1);
});

it('searches web with query string and keeps query params in pagination links', function () {
    $sports = NewsCategory::factory()->create(['name' => 'Sports']);
    $tech = NewsCategory::factory()->create(['name' => 'Tech']);

    News::factory()->create([
        'title' => 'Sports Daily',
        'category_id' => $sports->id,
        'published_at' => now(),
    ]);
    News::factory()->create([
        'title' => 'Tech Daily',
        'category_id' => $tech->id,
        'published_at' => now(),
    ]);

    // Simula query atual para validar withQueryString() no paginator.
    request()->query->set('q', 'Sports');

    $repository = app(NewsRepository::class);
    $result = $repository->searchWebPaginated('Sports', 1);

    expect($result->total())->toBeGreaterThanOrEqual(1);
    expect($result->url(2))->toContain('q=Sports');
});

