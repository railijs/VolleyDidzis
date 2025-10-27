<?php

use App\Models\User;
use App\Models\Tournament;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Pest\Browser\Support\Screenshot;

/**
 * Testu mērķis: sadalīt “turnīra izveides” plūsmu vairākos, fokusētos testos,
 * saglabājot to pašu “visit → click → fill → select → press” loģiku.
 */

// 1) Admins var atvērt turnīra izveides formu
test('Admins var atvērt turnīra izveides formu', function () {
    User::factory()->create([
        'email' => 'railijsgrieznis@gmail.com',
        'password' => Hash::make('phoenix21'),
        'role' => 'admin',
    ]);

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
        ->assertSee('Izveidot turnīru'); // virsraksts/formas indikators
});

// 2) Validācija: neļauj iesniegt tukšu formu (obligātie lauki)
test('Neļauj izveidot turnīru ar tukšiem obligātajiem laukiem', function () {
    User::factory()->create([
        'email' => 'railijsgrieznis@gmail.com',
        'password' => Hash::make('phoenix21'),
        'role' => 'admin',
    ]);

    $this->artisan('db:seed');

    $page = visit('/login');

    $page->click('Ienākt')
        ->assertPathIs('/login')
        ->fill('email', 'railijsgrieznis@gmail.com')
        ->fill('password', 'phoenix21')
        ->click('Ienāc')
        ->click('Admin panelis')
        ->click('Izveidot turnīru');

    $countBefore = Tournament::count();

    $page->press('.submit'); // sūtām tukšu formu

    // Paliekam formā un DB neparādās jauns turnīrs
    expect(Tournament::count())->toBe($countBefore);
});

// 3) Veiksmīga turnīra izveide ar derīgiem datiem
test('Izveido turnīru ar derīgiem datiem', function () {
    User::factory()->create([
        'email' => 'railijsgrieznis@gmail.com',
        'password' => Hash::make('phoenix21'),
        'role' => 'admin',
    ]);

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

    expect(
        Tournament::where('name', 'Valmieyiufytfras Meža Kauss')->exists()
    )->toBeTrue();
});

// 4) Autorizācija: parasts lietotājs neredz admin funkcijas
test('Parasts lietotājs neredz admin paneļa darbības', function () {
    User::factory()->create([
        'email' => 'user@example.com',
        'password' => Hash::make('password123'),
        'role' => 'user', // ne-admin
    ]);

    $this->artisan('db:seed');

    $page = visit('/login');

    $page->click('Ienākt')
        ->assertPathIs('/login')
        ->fill('email', 'user@example.com')
        ->fill('password', 'password123')
        ->click('Ienāc')
        ->assertSee('Sākums')
        ->assertDontSee('Admin panelis'); // nav pieejas administrēšanai
});
