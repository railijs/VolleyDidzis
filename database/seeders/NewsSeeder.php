<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title'   => 'FIVB 2025: sezonas atklāšana ar jaunu enerģiju',
                'content' => 'Starptautiskajā skatuvē sezona sākusies ar jaudīgu volejbola šovu un rekordu pieteikumiem.',
                'image'   => 'https://www.fivb.com/wp-content/uploads/2025/04/101954-scaled.jpeg',
                'created' => Carbon::now()->subDays(10)->setTime(11, 15),
            ],
            [
                'title'   => 'FIVB 2024 spilgtākie mirkļi — atskats uz emocionāliem dueļiem',
                'content' => 'Atskatāmies uz aizvadītās sezonas izšķirošajiem punktiem un lielākajiem pārsteigumiem.',
                'image'   => 'https://www.fivb.com/wp-content/uploads/2024/03/101096-15.jpeg',
                'created' => Carbon::now()->subDays(8)->setTime(18, 30),
            ],
            [
                'title'   => 'Jauniešu turnīrs kadros — komandu gars un smaidi',
                'content' => 'Aizraujošas spēles un iedvesmojoši stāsti no jauniešu volejbola turnīra aizkulisēm.',
                'image'   => 'https://cdn1.sportngin.com/attachments/call_to_action/e349-190383150/DSC01633-153_large.jpg',
                'created' => Carbon::now()->subDays(6)->setTime(14, 5),
            ],
            [
                'title'   => 'Kā top volejbola laukums: konstrukcija un seguma izvēle',
                'content' => 'Praktisks ceļvedis laukuma izbūvei — no pamatiem līdz seguma tipiem un uzturēšanai.',
                'image'   => 'https://en.reformsports.com/oxegrebi/2023/10/volleyball-court-construction-and-types.jpg',
                'created' => Carbon::now()->subDays(4)->setTime(9, 40),
            ],
            [
                'title'   => 'Oficiālie volejbola laukuma izmēri un iezīmējums',
                'content' => 'Ātrs pārskats par laukuma izmēriem, līnijām un marķējumu saskaņā ar noteikumiem.',
                'image'   => 'https://www.shelter-structures.com/wp-content/uploads/2024/06/Volleyball-Court-Dimensions.webp',
                'created' => Carbon::now()->subDays(2)->setTime(16, 20),
            ],
            [
                'title'   => 'Taktika un rotācijas: pamati komandas izvietojumam',
                'content' => 'Koordinācija, sakari un kustība — pamati, kas palīdz dominēt laukumā.',
                'image'   => 'https://www.volleyballengland.org/uploads/images/w1500/7934.png',
                'created' => Carbon::now()->setTime(10, 0),
            ],
        ];

        foreach ($items as $item) {
            // Skip clearly invalid URLs
            if (!filter_var($item['image'], FILTER_VALIDATE_URL)) {
                continue;
            }

            // Upsert by image URL to avoid duplicates on re-run
            DB::table('news')->updateOrInsert(
                ['image' => $item['image']],
                [
                    'title'      => $item['title'],
                    'content'    => $item['content'],
                    'created_at' => $item['created'] ?? now(),
                    'updated_at' => $item['created'] ?? now(),
                ]
            );
        }
    }
}
