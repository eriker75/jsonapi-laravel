<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller
{
    public function index(): ArticleCollection
    {
        return ArticleCollection::make(Article::all());
    }

    public function show(Article $article): ArticleResource
    {
        /*
            $articleRoute = route('api.v1.articles.show', $article);
            return response()->json([
                'data' => [
                    'type' => 'articles',
                    'id' => $article->getRouteKey(),
                    'attributes' => [
                        'title' => $article->title,
                        'slug' => $article->slug,
                        'content' => $article->content,
                    ]
                ],
                'links' => [
                    'self' => $articleRoute
                ]
            ]);
        */

        return ArticleResource::make($article);
    }
}
