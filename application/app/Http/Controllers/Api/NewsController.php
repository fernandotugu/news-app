<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Services\NewsService;
use App\Services\NewsSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function __construct(
        private readonly NewsService $newsService,
        private readonly NewsSearchService $newsSearchService,
    ) {
        //
    }

    public function index()
    {
        return $this->newsService->getPublishedPaginated(6);
    }

    public function store(StoreNewsRequest $request)
    {
        $data = $request->validated();

        $news = $this->newsService->createAndPublish([
            'uuid' => (string) Str::uuid(),
            'title' => $data['title'],
            'content' => $data['content'],
            'category_id' => $data['category_id'],
            'published_at' => now(),
        ]);

        return response()->json([
            'message' => 'Notícia criada com sucesso',
            'data' => $news,
        ], 201);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $news = $this->newsSearchService->searchWithHighlight($search, 10);

        return response()->json($news);
    }
}
