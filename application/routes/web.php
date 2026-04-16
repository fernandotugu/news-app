<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewsPageController;
use App\Http\Controllers\NewsCreateController;
use App\Http\Controllers\NewsDetailController;
use App\Http\Controllers\NewsResultSearchController;

Route::get('/', [NewsPageController::class, 'index'])->name('news.index');;
Route::get('/news/create', [NewsCreateController::class, 'index'])->name('news.create');;
Route::get('/news/search', [NewsResultSearchController::class, 'search'])->name('news.search');
Route::get('/news/{uuid}', [NewsDetailController::class, 'index'])->name('news.show');

