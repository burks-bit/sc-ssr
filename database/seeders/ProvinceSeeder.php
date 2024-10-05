<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            ['id' => 1, 'code' => 'ALBAY', 'name' => 'Albay', 'status' => '1'],
            ['id' => 2, 'code' => 'CAMNORTE', 'name' => 'Camarines Norte', 'status' => '1'],
            ['id' => 3, 'code' => 'CAMSUR', 'name' => 'Camarines Sur', 'status' => '1'],
            ['id' => 4, 'code' => 'CATANDUANES', 'name' => 'Catanduanes', 'status' => '1'],
            ['id' => 5, 'code' => 'MASBATE', 'name' => 'Masbate', 'status' => '1'],
            ['id' => 6, 'code' => 'SORSGON', 'name' => 'Sorsogon', 'status' => '1'],
        ];

        // Insert the data into the provinces table
        DB::table('provinces')->insert($provinces);
    }
}
