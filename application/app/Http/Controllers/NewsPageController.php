<?php

namespace App\Http\Controllers;

use App\Services\NewsService;

class NewsPageController extends Controller
{
    public function __construct(private readonly NewsService $newsService)
    {
        //
    }

    public function index()
    {
        $initialNews = $this->newsService->getHomepageNews(6);

        return view('news.index', compact('initialNews'));
    }
}
