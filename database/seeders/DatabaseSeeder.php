<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed admin user
        $this->call([\Database\Seeders\AdminSeeder::class]);

        // Seed default user
        $this->call([\Database\Seeders\UserSeeder::class]);

        // Seed master cards
        $this->call([\Database\Seeders\MstCardSeeder::class]);
    }
}
