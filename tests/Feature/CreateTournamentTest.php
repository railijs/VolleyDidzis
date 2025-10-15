<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use App\Models\Tournament;
use Pest\Browser\Support\Screenshot;

it('Lietotājs var izveidot turnīru', function () {
    User::factory()->create([
        'email' => 'railijsgrieznis@gmail.com',
        'password' => Hash::make('phoenix21'),
        'role' => 'admin',
    ]);

    Event::fake();

    $this->artisan('db:seed');

    $page = visit('/login');

    $page->click('Ienākt')
        ->assertPathIs('/login')
        ->assertSee('Laipni lūdzam atpakaļ')
        ->fill('email', 'railijsgrieznis@gmail.com')
        ->fill('password', 'phoenix21')
        ->click('Ienāc')
        ->assertSee('Sākums')
        ->click('Admin panelis')
        ->click('Izveidot turnīru')

        ->fill('name', 'Valmieyiufytfras Meža Kauss')
        ->fill('description', 'Īss turnīra apraksts, nolikums un reģistrācijas norise.')
        ->fill('start_date', '2025-10-17')
        ->fill('end_date', '2025-10-19')
        ->fill('location', 'Valmiera, LV')
        ->fill('max_teams', '8')
        ->fill('team_size', '6')
        ->select('gender_type', 'mix')
        ->fill('min_boys', '2')
        ->fill('min_girls', '2')
        ->fill('min_age', '16')
        ->fill('max_age', '40')
        ->fill('recommendations', 'Spēles noteikumi, apģērba prasības, sākuma laiki u.c.')

        ->press('.submit')
        ->screenshot(filename: 'create-tournament');
});
