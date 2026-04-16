<?php

namespace App\Http\Controllers;

use App\Services\NewsService;

class NewsDetailController extends Controller
{
    public function __construct(private readonly NewsService $newsService)
    {
        //
    }

    public function index(string $uuid)
    {
        $news = $this->newsService->getByUuidWithCategory($uuid);

        return view('news.detail', compact('news'));
    }
}
