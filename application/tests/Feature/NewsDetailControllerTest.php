<?php

use App\Models\News;
use App\Models\NewsCategory;
use Tests\TestCase;

uses(TestCase::class);

it('shows news detail page successfully', function () {

    // Arrange
    $category = NewsCategory::create([
        'name' => 'Tecnologia'
    ]);

    $news = News::create([
        'uuid' => (string) \Illuminate\Support\Str::uuid(),
        'title' => 'Notícia de Teste',
        'content' => 'Conteúdo da notícia de teste para detalhe.',
        'category_id' => $category->id,
        'published_at' => now(),
    ]);

    // Act
    $response = $this->get(route('news.show', $news->uuid));

    // Assert HTTP
    $response->assertStatus(200);
    $response->assertViewIs('news.detail');

    // Assert view data
    $response->assertViewHas('news');

    $viewNews = $response->viewData('news');

    expect($viewNews->uuid)->toBe($news->uuid);
    expect($viewNews->title)->toBe('Notícia de Teste');
    expect($viewNews->category->name)->toBe('Tecnologia');

    // Assert rendering
    $response->assertSee('Notícia de Teste');
    $response->assertSee('Tecnologia');
});
