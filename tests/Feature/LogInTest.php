<?php

use App\Models\User;

it('Lietotājs var ienākt profilā', function () {


    User::factory()->create([ // assumes RefreshDatabase trait is used on Pest.php...
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
});
