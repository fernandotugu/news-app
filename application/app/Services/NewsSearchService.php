<?php

namespace App\Services;

use App\Support\Highlight;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NewsSearchService
{
    public function __construct(
        private readonly NewsService $newsService,
    ) {
    }

    /**
     * Busca de notícias para API, já com highlight aplicado nos campos relevantes.
     */
    public function searchWithHighlight(?string $term, int $perPage = 10): LengthAwarePaginator
    {
        $paginator = $this->newsService->searchApi($term, $perPage);

        if (!$term) {
            return $paginator;
        }

        $paginator->getCollection()->transform(function ($item) use ($term) {
            $item->title = Highlight::apply($item->title, $term);

            if (isset($item->category) && isset($item->category->name)) {
                $item->category->name = Highlight::apply($item->category->name, $term);
            }

            return $item;
        });

        return $paginator;
    }
}

