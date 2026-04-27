<?php

namespace Database\Seeders;

use App\Models\Musician;
use Illuminate\Database\Seeder;

class MusicianSeeder extends Seeder
{
    public function run(): void
    {
        $musicians = [
            ['name' => 'Dušan Vlk',         'genre' => 'Pop / Rock'],
            ['name' => 'Marek Hamšík Band', 'genre' => 'Rock'],
            ['name' => 'Hex',               'genre' => 'Hip-hop / Rap'],
            ['name' => 'Rytmus',            'genre' => 'Hip-hop / Rap'],
            ['name' => 'Celeste Buckingham','genre' => 'Pop'],
            ['name' => 'Katarzia',          'genre' => 'Indie Pop'],
            ['name' => 'Para',              'genre' => 'Rock'],
            ['name' => 'Michal Dočolomanský', 'genre' => 'Folk / Country'],
            ['name' => 'IMT Smile',         'genre' => 'Pop / Rock'],
            ['name' => 'Desmod',            'genre' => 'Rock'],
            ['name' => 'Užívaj',            'genre' => 'Reggae / Pop'],
            ['name' => 'Horkýže Slíže',     'genre' => 'Punk / Ska'],
        ];

        foreach ($musicians as $m) {
            Musician::firstOrCreate(['name' => $m['name']], $m);
        }
    }
}