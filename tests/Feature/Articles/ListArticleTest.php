<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPSTORM_META\type;

class ListArticleTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_fetch_a_single_article(): void
    {
        // No muestra la traza de la excepción para que sea mas fácil leer el error
        $this->withoutExceptionHandling();
        
        $article = Article::factory()->create();
        // getRouteKey por defecto es id, si no el que le especificamos en el modelo, más adelante será el slug
        $response = $this->getJson(route('api.v1.articles.show', $article));

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                // La especificación JSON:API nos dice que el id debe ser un string
                'id' => (string) $article->id,
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article)
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_articles(): void
    {
        $this->withExceptionHandling();

        $articles = Article::factory()->count(3)->create();
        $response = $this->getJson(route('api.v1.articles.index'));
        $response->assertExactJson([
            'data' => [
                [
                    'type' => 'articles',
                    'id' => (string) $articles[0]->id,
                    'attributes' => [
                        'title' => $articles[0]->title,
                        'slug' => $articles[0]->slug,
                        'content' => $articles[0]->content
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $articles[0])
                    ]
                ],
                [
                    'type' => 'articles',
                    'id' => (string) $articles[1]->id,
                    'attributes' => [
                        'title' => $articles[1]->title,
                        'slug' => $articles[1]->slug,
                        'content' => $articles[1]->content
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $articles[1])
                    ]
                ],
                [
                    'type' => 'articles',
                    'id' => (string) $articles[2]->id,
                    'attributes' => [
                        'title' => $articles[2]->title,
                        'slug' => $articles[2]->slug,
                        'content' => $articles[2]->content
                    ],
                    'links' => [
                        'self' => route('api.v1.articles.show', $articles[2])
                    ]
                ],
            ],
            'links' => [
                'self' => route('api.v1.articles.index')
            ]
        ]);
    }
}
