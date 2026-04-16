<?php

namespace App\Services;

use App\Repositories\NewsCategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class NewsCategoryService
{
    public function __construct(
        private readonly NewsCategoryRepository $newsCategoryRepository,
    ) {
    }

    /**
     * Categorias ordenadas por nome para telas de listagem/criação.
     */
    public function getAllOrdered(): Collection
    {
        return $this->newsCategoryRepository->getOrderedByName();
    }
}

