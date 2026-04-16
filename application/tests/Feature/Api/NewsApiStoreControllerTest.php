<?php

use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('creates news via api store endpoint', function () {
    $category = NewsCategory::factory()->create();

    $payload = [
        'title' => 'New API Article',
        'content' => 'API content for created article.',
        'category_id' => $category->id,
    ];

    $response = $this->postJson('/api/news', $payload);

    $response->assertCreated()
        ->assertJsonPath('message', 'Notícia criada com sucesso');

    $this->assertDatabaseHas('news', [
        'title' => 'New API Article',
        'category_id' => $category->id,
    ]);
});

it('validates required fields on api store', function () {
    $response = $this->postJson('/api/news', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['title', 'content', 'category_id']);
});

