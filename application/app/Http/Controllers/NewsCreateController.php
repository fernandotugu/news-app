<?php

namespace App\Http\Controllers;

use App\Services\NewsCategoryService;

class NewsCreateController extends Controller
{
    public function __construct(private readonly NewsCategoryService $newsCategoryService)
    {
        //
    }

    public function index()
    {
        $categories = $this->newsCategoryService->getAllOrdered();

        return view('news.create', [
            'categories' => $categories
        ]);
    }
}
