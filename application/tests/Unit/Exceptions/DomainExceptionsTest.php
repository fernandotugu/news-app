<?php

use App\Exceptions\DomainException;
use App\Exceptions\NewsNotFoundException;
use App\Exceptions\NewsSearchException;

it('NewsNotFoundException extends DomainException', function () {
    $exception = new NewsNotFoundException('Not found');

    expect($exception)->toBeInstanceOf(DomainException::class);
    expect($exception->getMessage())->toBe('Not found');
});

it('NewsSearchException extends DomainException', function () {
    $exception = new NewsSearchException('Search error');

    expect($exception)->toBeInstanceOf(DomainException::class);
    expect($exception->getMessage())->toBe('Search error');
});

