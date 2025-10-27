    <?php

    use App\Models\User;
    use Illuminate\Support\Facades\Hash;

    // Pārbaudām: veiksmīga pieteikšanās
    test('Lietotājs var ienākt profilā', function () {
        // Izveido lietotāju ar hasotu paroli
        $user = User::factory()->create([
            'email'    => 'railijsgrieznis@gmail.com',
            'password' => Hash::make('phoenix21'),
        ]);

        $page = visit('/login');

        $page->click('Ienāc')                  // pārliecināmies, ka esam login skatā
            ->assertPathIs('/login')
            ->assertSee('Laipni lūdzam atpakaļ')
            ->fill('email', $user->email)      // ievadam derīgus datus
            ->fill('password', 'phoenix21')
            ->click('Ienāc')                   // iesniedzam formu
            ->assertSee('Sākums');             // jānonāk sākumlapā
    });

    // Pārbaudām: nepareiza parole netiek ielaista
    test('Neļauj pieteikties ar nepareizu paroli', function () {
        $user = User::factory()->create([
            'email'    => 'railijsgrieznis@gmail.com',
            'password' => Hash::make('phoenix21'),
        ]);

        visit('/login')
            ->fill('email', $user->email)
            ->fill('password', 'nepareizi123') // kļūdaina parole
            ->click('Ienāc')
            ->assertPathIs('/login')           // paliekam pie login
            ->assertDontSee('Sākums');         // sākumlapu neredzam
    });

    // Pārbaudām: abi lauki ir obligāti
    test('Validācija: abi lauki ir obligāti', function () {
        visit('/login')
            ->click('Ienāc')                   // sūtām tukšu formu
            ->assertPathIs('/login')           // neizlaiž tālāk
            ->assertSee('Laipni lūdzam atpakaļ'); // paliekam tajā pašā skatā
    });

// it('Lietotājs var izrakstīties no profila', function () {


//     User::factory()->create([
//         'email' => 'railijsgrieznis@gmail.com',
//         'password' => 'phoenix21',
//     ]);

//     $page = visit('/login');

//     $page->click('Ienākt')
//         ->assertPathIs('/login')
//         ->assertSee('Laipni lūdzam atpakaļ')
//         ->fill('email', 'railijsgrieznis@gmail.com')
//         ->fill('password', 'phoenix21')
//         ->click('Ienāc')
//         ->assertSee('Sākums');

//     $page->click('[data-testid="profile-button"]')
//         ->click('[data-testid="logout-link"]')
//         ->assertSee('VolleyLV');
// });
