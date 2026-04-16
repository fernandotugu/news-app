<?php

use App\Models\User;

it('contains password in hidden attributes', function () {
    $user = new User();

    expect($user->getHidden())->toContain('password');
});

