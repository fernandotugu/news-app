<?php

use App\Support\Highlight;

it('highlights term in a case-insensitive way', function () {
    $result = Highlight::apply('Laravel News Search', 'news');

    expect($result)->toBe('Laravel <mark>News</mark> Search');
});

it('returns original text when term is empty', function () {
    $result = Highlight::apply('Laravel News Search', '');

    expect($result)->toBe('Laravel News Search');
});

it('returns null when text is null', function () {
    $result = Highlight::apply(null, 'news');

    expect($result)->toBeNull();
});

