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
        // User::factory(10)->create();
        
        // Call AdminSeeder
        $this->call(AdminSeeder::class);
        
        // Call MenuSeeder
        $this->call(MenuSeeder::class);
        
        // Call SettingsSeeder
        $this->call(SettingsSeeder::class);
        
        // Call EventCategorySeeder
        $this->call(EventCategorySeeder::class);
        
        // Call EventSeeder
        $this->call(EventSeeder::class);
        
        // Call PartnerSeeder
        $this->call(PartnerSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);
    }
}
