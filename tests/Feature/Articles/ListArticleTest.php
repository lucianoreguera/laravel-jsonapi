<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
