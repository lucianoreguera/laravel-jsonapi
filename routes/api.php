<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// En RouteServiceProvider agregamos v1 al prefix => prefix('api/v1')
Route::get('articles', [ArticleController::class, 'index'])->name('api.v1.articles.index');
Route::get('articles/{article}', [ArticleController::class, 'show'])->name('api.v1.articles.show');
Route::post('articles', [ArticleController::class, 'create'])->name('api.v1.articles.create');