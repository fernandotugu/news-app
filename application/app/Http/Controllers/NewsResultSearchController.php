<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsResultSearchController extends Controller
{
    public function __construct(private readonly NewsService $newsService)
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $news = $this->newsService->searchWeb($query, 6);

        return view('news.search-results', [
            'news' => $news,
            'query' => $query
        ]);
    }
}
