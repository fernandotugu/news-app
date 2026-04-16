<?php

use Tests\TestCase;

uses(TestCase::class);

it('returns 404 for unknown news uuid on web detail', function () {
    $response = $this->get('/news/non-existing-uuid');

    $response->assertNotFound();
});

