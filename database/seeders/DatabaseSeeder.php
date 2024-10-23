<?php

namespace Database\Seeders;

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
        User::factory()->create([
            'name' => 'Frank Leimbergh D. Armodia',
            'bio' => 'Syempre Gwapo',
            'email' => 'farmodia@gmail.com',
        ]);

        User::factory(2)->create();
    }
}
