<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use App\Models\Tournament;
use Pest\Browser\Support\Screenshot;

test('Turnīra brakets strādā', function () {
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

        ->fill('name', 'Valmieras Meža Kauss')
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
        ->assertSee('Valmieras Meža Kauss')
        ->press('Skatīt')
        ->assertSee('Pieteikties')

        ->fill('team_name', 'Lauvas')
        ->fill('captain_name', 'Didzis')
        ->fill('email', 'railijsgrieznis@gmail.com')
        ->press('Iesniegt pieteikumu')

        ->assertSee('Pieteikums veiksmīgi iesniegts!')

        ->fill('team_name', 'Tigeri')
        ->fill('captain_name', 'Railijs')
        ->fill('email', 'railijsgrieznis@gmail.com')

        ->press('Iesniegt pieteikumu')

        ->press('Sākt turnīru')


        ->assertSee('Tigeri')
        ->fill('input[data-side="A"]', '12')

        ->assertSee('Lauvas')
        ->fill('input[data-side="B"]', '25')

        ->assertSee('Turnīra uzvarētājs')

        ->screenshot(filename: 'tournament');
});
