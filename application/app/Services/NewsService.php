<?php

namespace App\Services;

use App\Models\News;
use App\Exceptions\NewsNotFoundException;
use App\Exceptions\NewsSearchException;
use App\Repositories\NewsRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NewsService
{
    public function __construct(
        private readonly NewsRepository $newsRepository,
    ) {
    }

    /**
     * Notícias para a homepage (lista inicial).
     */
    public function getHomepageNews(int $limit = 6): Collection
    {
        return $this->newsRepository->getPublishedLatest($limit);
    }

    /**
     * Lista paginada de notícias publicadas (API index).
     */
    public function getPublishedPaginated(int $perPage = 6): LengthAwarePaginator
    {
        return $this->newsRepository->getPublishedPaginated($perPage);
    }

    /**
     * Detalhe de uma notícia por UUID, carregando categoria.
     */
    public function getByUuidWithCategory(string $uuid): News
    {
        try {
            return $this->newsRepository->findByUuidWithCategory($uuid);
        } catch (ModelNotFoundException $e) {
            throw new NewsNotFoundException('Notícia não encontrada.', 0, $e);
        }
    }

    /**
     * Criação de notícia já publicada (caso de uso atual da API).
     */
    public function createAndPublish(array $data): News
    {
        return $this->newsRepository->create($data);
    }

    /**
     * Busca da API, com paginação.
     */
    public function searchApi(?string $term, int $perPage = 10): LengthAwarePaginator
    {
        try {
            return $this->newsRepository->searchApiPaginated($term, $perPage);
        } catch (\Throwable $e) {
            throw new NewsSearchException('Erro ao buscar notícias.', 0, $e);
        }
    }

    /**
     * Busca da web (blade), com paginação.
     */
    public function searchWeb(?string $term, int $perPage = 6): LengthAwarePaginator
    {
        try {
            return $this->newsRepository->searchWebPaginated($term, $perPage);
        } catch (\Throwable $e) {
            throw new NewsSearchException('Erro ao buscar notícias.', 0, $e);
        }
    }
}

