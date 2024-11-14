<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Abdletif outzgui',
            'email' => 'abdletif.outzgui@gmail.com',
            'password' => Hash::make('password') 
        ]);

        $this->call([
            ProduitSeeder::class,
            ClientSeeder::class,
            CommandeSeeder::class
        ]);
    }
}
