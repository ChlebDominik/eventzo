<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'title' => 'Summer Beats',
            'description' => 'Letný open-air festival s DJ-mi.',
            'location' => 'Bratislava',
            'start_date' => Carbon::now()->addDays(14),
            'capacity' => 500,
        ]);

        Event::create([
            'title' => 'Tech Meetup',
            'description' => 'Prednášky o modernom vývoji.',
            'location' => 'Košice',
            'start_date' => Carbon::now()->addDays(30),
            'capacity' => 150,
        ]);
    }
}
