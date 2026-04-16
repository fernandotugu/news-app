<?php

namespace App\Repositories;

use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Collection;

class NewsCategoryRepository
{
    public function getOrderedByName(): Collection
    {
        return NewsCategory::orderBy('name')->get();
    }
}

