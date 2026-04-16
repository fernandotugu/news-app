<?php

use Tests\TestCase;

uses(TestCase::class);

it('serves the openapi spec file', function () {
    $this->get('/api/openapi.yaml')
        ->assertOk()
        ->assertHeaderContains('content-type', 'yaml');
});

it('serves the swagger ui page', function () {
    $this->get('/api/documentation')
        ->assertOk()
        ->assertSee('swagger-ui', false);
});
