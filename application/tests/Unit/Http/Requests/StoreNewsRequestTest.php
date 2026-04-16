<?php

use App\Http\Requests\StoreNewsRequest;

it('authorizes by default', function () {
    $request = new StoreNewsRequest();

    expect($request->authorize())->toBeTrue();
});

it('defines expected validation rules', function () {
    $request = new StoreNewsRequest();
    $rules = $request->rules();

    expect($rules)->toHaveKeys(['title', 'content', 'category_id']);
    expect($rules['title'])->toContain('required');
    expect($rules['content'])->toContain('required');
    expect($rules['category_id'])->toContain('required');
});

