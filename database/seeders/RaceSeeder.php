<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\Race;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{
    public function run(): void
    {
        // 4 main competitions/series (you can rename these later).
        $comps = [
            ['name' => 'Romanian Karting Masters', 'slug' => 'rkm', 'sort_order' => 10],
            ['name' => 'Romanian Championship', 'slug' => 'ro-championship', 'sort_order' => 20],
            ['name' => 'Bucharest Cup', 'slug' => 'bucharest-cup', 'sort_order' => 30],
            ['name' => 'Regional Trophy', 'slug' => 'regional-trophy', 'sort_order' => 40],
        ];

        foreach ($comps as $c) {
            Competition::firstOrCreate(['slug' => $c['slug']], $c);
        }

        $year = (int) now()->year;

        $rkm = Competition::where('slug', 'rkm')->first();
        $rch = Competition::where('slug', 'ro-championship')->first();
        $buc = Competition::where('slug', 'bucharest-cup')->first();
        $reg = Competition::where('slug', 'regional-trophy')->first();

        $seedRaces = [
            [
                'competition_id' => $buc?->id,
                'title' => 'Bucharest Cup',
                'venue' => 'Motorsport Park',
                'city' => 'Bucuresti',
                'starts_at' => sprintf('%d-03-23', $year),
                'ends_at' => sprintf('%d-03-24', $year),
                'season_year' => $year,
                'classes' => 'OK-N, Mini, Junior, Senior',
                'image' => 'images/poza3.png',
                'tickets_url' => null,
                'details_url' => null,
                'status' => 'scheduled',
                'is_featured' => true,
            ],
            [
                'competition_id' => $reg?->id,
                'title' => 'Sibiu Trophy',
                'venue' => 'Speed Park',
                'city' => 'Piatra Neamt',
                'starts_at' => sprintf('%d-04-05', $year),
                'ends_at' => sprintf('%d-04-07', $year),
                'season_year' => $year,
                'classes' => 'Mini, Junior, Senior',
                'image' => 'images/poza.png',
                'status' => 'scheduled',
            ],
            [
                'competition_id' => $reg?->id,
                'title' => 'Cluj Kart Challenge',
                'venue' => 'Karting Track',
                'city' => 'Cluj-Napoca',
                'starts_at' => sprintf('%d-04-19', $year),
                'ends_at' => sprintf('%d-04-21', $year),
                'season_year' => $year,
                'classes' => 'Mini, Junior, Senior',
                'image' => 'images/poza2.webp',
                'status' => 'scheduled',
            ],
            [
                'competition_id' => $rkm?->id,
                'title' => 'Romanian Karting Masters - Round 2',
                'venue' => 'Prejmer Raceway',
                'city' => 'Brasov',
                'starts_at' => sprintf('%d-05-10', $year),
                'ends_at' => sprintf('%d-05-12', $year),
                'season_year' => $year,
                'classes' => 'OK-N, Junior, Senior',
                'image' => 'images/poza3.png',
                'status' => 'scheduled',
                'is_featured' => true,
            ],
            [
                'competition_id' => $rch?->id,
                'title' => 'National Championship - Round 1',
                'venue' => 'Kartodrom',
                'city' => 'Targu Mures',
                'starts_at' => sprintf('%d-06-07', $year),
                'ends_at' => sprintf('%d-06-09', $year),
                'season_year' => $year,
                'classes' => 'Mini, Junior, Senior',
                'image' => 'images/poza.png',
                'status' => 'scheduled',
                'is_featured' => true,
            ],
        ];

        foreach ($seedRaces as $r) {
            if (!$r['competition_id']) {
                continue;
            }

            Race::firstOrCreate(
                [
                    'competition_id' => $r['competition_id'],
                    'title' => $r['title'],
                    'starts_at' => $r['starts_at'],
                ],
                $r
            );
        }
    }
}

