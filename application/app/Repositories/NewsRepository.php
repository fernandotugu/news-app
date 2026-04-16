<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class NewsRepository
{
    public function findByUuidWithCategory(string $uuid): News
    {
        return News::with('category')
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    public function getPublishedLatest(int $limit = 6): Collection
    {
        return News::query()
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    public function getPublishedPaginated(int $perPage = 6): LengthAwarePaginator
    {
        return News::query()
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function create(array $data): News
    {
        return News::create($data);
    }

    public function searchApiPaginated(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        $query = News::with('category');

        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function (Builder $q2) use ($search) {
                        $q2->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function searchWebPaginated(?string $q, int $perPage = 6): LengthAwarePaginator
    {
        $query = News::query()
            ->with('category')
            ->when($q, function (Builder $queryBuilder) use ($q) {
                $queryBuilder->where('title', 'like', "%{$q}%")
                    ->orWhereHas('category', function (Builder $cat) use ($q) {
                        $cat->where('name', 'like', "%{$q}%");
                    });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return $query;
    }
}

