<?php

use App\Models\NewsCategory;
use Tests\TestCase;

uses(TestCase::class);

it('loads create news page with categories ordered by name', function () {

    // Arrange: cria dados controlados (SEM factory aleatória)
    $z = NewsCategory::create(['name' => 'Z - Ultima']);
    $a = NewsCategory::create(['name' => 'A - Primeira']);
    $m = NewsCategory::create(['name' => 'M - Meio']);

    // Act
    $response = $this->get(route('news.create'));

    // Assert HTTP
    $response->assertStatus(200);
    $response->assertViewIs('news.create');

    // Assert view data existe
    $response->assertViewHas('categories');

    $categories = $response->viewData('categories');

    // garante ordenação (orderBy('name'))
    expect($categories->first()->name)->toBe('A - Primeira');
    expect($categories->last()->name)->toBe('Z - Ultima');

    // garante que dados aparecem na renderização
    $response->assertSee('A - Primeira');
    $response->assertSee('M - Meio');
    $response->assertSee('Z - Ultima');
});
