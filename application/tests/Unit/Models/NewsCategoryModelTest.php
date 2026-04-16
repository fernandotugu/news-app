<?php

use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

uses(TestCase::class);

it('defines news hasMany relationship', function () {
    $relation = (new NewsCategory())->news();

    expect($relation)->toBeInstanceOf(HasMany::class);
});

