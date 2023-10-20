<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(): ArticleCollection
    {
        $articles = Article::all();

        return ArticleCollection::make($articles);
    }

    public function show(Article $article): ArticleResource
    {
        return ArticleResource::make($article);
    }
}
