<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController;

Route::get('/news', [NewsController::class, 'index']);
Route::post('/news', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/search', [NewsController::class, 'search'])->name('news.search');
