<?php

use App\Models\User;

it('Lietotājs var izrakstīties no profila', function () {


    User::factory()->create([
        'email' => 'railijsgrieznis@gmail.com',
        'password' => 'phoenix21',
    ]);

    $page = visit('/login');

    $page->click('Ienākt')
        ->assertPathIs('/login')
        ->assertSee('Laipni lūdzam atpakaļ')
        ->fill('email', 'railijsgrieznis@gmail.com')
        ->fill('password', 'phoenix21')
        ->click('Ienāc')
        ->assertSee('Sākums');

    $page->click('[data-testid="profile-button"]')
        ->click('[data-testid="logout-link"]')
        ->assertSee('VolleyLV');
});
