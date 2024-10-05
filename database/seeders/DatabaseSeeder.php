<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(
        //     BarangaySeeder::class,
        //     MemberSeeder::class,
        //     MunicipalitySeeder::class,
        //     ProvinceSeeder::class,
        //     UserSeeder::class,
        // );
        
        $this->call(BarangaySeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(MunicipalitySeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(UserSeeder::class);
    }
}