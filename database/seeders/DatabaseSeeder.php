<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'Frank Leimbergh D. Armodia',
                'bio' => 'Syempre Gwapo',
                'email' => 'farmodia@gmail.com',
            ],
            [
                'name' => 'Francine Layla A. Dimpas',
                'bio' => 'Cutsie',
                'email' => 'test@gmail.com',
            ]
        ]);
        
        Interest::create(['name' => 'Music']);
        Interest::create(['name' => 'Guitar']);
        Interest::create(['name' => 'Art']);
        Interest::create(['name' => 'Video Games']);
        Interest::create(['name' => 'Technology']);
        Interest::create(['name' => 'League of Legends']);
        Interest::create(['name' => 'Anime']);
        Interest::create(['name' => 'K-drama']);
        Interest::create(['name' => 'Web Development']);
        Interest::create(['name' => 'Sports']);
        Interest::create(['name' => 'Arts and Crafts']);
        Interest::create(['name' => 'Design']);
        Interest::create(['name' => 'Architecture']);
        Interest::create(['name' => 'Digital Arts']);
        Interest::create(['name' => 'Graphic Design']);
        Interest::create(['name' => 'Movies']);
        Interest::create(['name' => 'Tv Shows']);


        User::factory(3)->create();
    }
}
