<?php

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('casts published_at as datetime', function () {
    $category = NewsCategory::factory()->create();
    $news = News::factory()->create([
        'category_id' => $category->id,
        'published_at' => now(),
    ]);

    expect($news->published_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

it('defines category belongsTo relationship', function () {
    $relation = (new News())->category();

    expect($relation)->toBeInstanceOf(BelongsTo::class);
});

