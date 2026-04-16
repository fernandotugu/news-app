<?php

use App\Providers\AppServiceProvider;
use Tests\TestCase;

uses(TestCase::class);

it('boots app service provider without errors', function () {
    $provider = new AppServiceProvider(app());

    expect(fn () => $provider->boot())->not->toThrow(Throwable::class);
});

