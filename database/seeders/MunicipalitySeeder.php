<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipalities = [
            // Albay
            ['province_id' => 1, 'name' => 'Legazpi City', 'code' => 'LEGAZPI', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Tabaco City', 'code' => 'TABACO', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Ligao City', 'code' => 'LIGAO', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Polangui', 'code' => 'POLANGUI', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Guinobatan', 'code' => 'GUINOBATAN', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Malinao', 'code' => 'MALINAO', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Daraga', 'code' => 'DARAGA', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Camalig', 'code' => 'CAMALIG', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Libon', 'code' => 'LIBON', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Sto. Domingo', 'code' => 'STO_DOMINGO', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Bocaue', 'code' => 'BOCAUE', 'status' => '1'],
            ['province_id' => 1, 'name' => 'Rapu-Rapu', 'code' => 'RAPU_RAPU', 'status' => '1'],

            // Camarines Norte
            ['province_id' => 2, 'name' => 'Daet', 'code' => 'DAET', 'status' => '1'],
            ['province_id' => 2, 'name' => 'Jose Panganiban', 'code' => 'JOSE_PANGANIBAN', 'status' => '1'],
            ['province_id' => 2, 'name' => 'Mambulao', 'code' => 'MAMBULAO', 'status' => '1'],
            ['province_id' => 2, 'name' => 'Mercedez', 'code' => 'MERCEDES', 'status' => '1'],
            ['province_id' => 2, 'name' => 'Paracale', 'code' => 'PARACALE', 'status' => '1'],
            ['province_id' => 2, 'name' => 'Vinzons', 'code' => 'VINZONS', 'status' => '1'],

            // Camarines Sur
            ['province_id' => 3, 'name' => 'Naga City', 'code' => 'NAGA', 'status' => '1'],
            ['province_id' => 3, 'name' => 'Iriga City', 'code' => 'IRIGA', 'status' => '1'],
            ['province_id' => 3, 'name' => 'Caramoan', 'code' => 'CARAMOAN', 'status' => '1'],
            ['province_id' => 3, 'name' => 'Pili', 'code' => 'PILI', 'status' => '1'],
            ['province_id' => 3, 'name' => 'Tigaon', 'code' => 'TIGAON', 'status' => '1'],
            ['province_id' => 3, 'name' => 'Bombon', 'code' => 'BOMBON', 'status' => '1'],
            ['province_id' => 3, 'name' => 'Gainza', 'code' => 'GAINZA', 'status' => '1'],
            ['province_id' => 3, 'name' => 'Magarao', 'code' => 'MAGARAO', 'status' => '1'],
            ['province_id' => 3, 'name' => 'Minalabac', 'code' => 'MINALABAC', 'status' => '1'],
            ['province_id' => 3, 'name' => 'Sagñay', 'code' => 'SAGÑAY', 'status' => '1'],
            ['province_id' => 3, 'name' => 'San Fernando', 'code' => 'SAN_FERNANDO', 'status' => '1'],
            ['province_id' => 3, 'name' => 'Presentacion', 'code' => 'PRESENTACION', 'status' => '1'],

            // Catanduanes
            ['province_id' => 4, 'name' => 'Virac', 'code' => 'VIRAC', 'status' => '1'],
            ['province_id' => 4, 'name' => 'Bato', 'code' => 'BATO', 'status' => '1'],
            ['province_id' => 4, 'name' => 'Pandan', 'code' => 'PANDAN', 'status' => '1'],
            ['province_id' => 4, 'name' => 'San Andres', 'code' => 'SAN_ANDRES', 'status' => '1'],
            ['province_id' => 4, 'name' => 'San Miguel', 'code' => 'SAN_MIGUEL', 'status' => '1'],

            // Masbate
            ['province_id' => 5, 'name' => 'Masbate City', 'code' => 'MASBATE', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Aroroy', 'code' => 'AROROY', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Baleno', 'code' => 'BALENO', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Batuan', 'code' => 'BATUAN', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Cataingan', 'code' => 'CATAINGAN', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Claveria', 'code' => 'CLAVERIA', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Dimasalang', 'code' => 'DIMASALANG', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Esperanza', 'code' => 'ESPERANZA', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Mandaon', 'code' => 'MANDAON', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Milagros', 'code' => 'MILAGROS', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Mobo', 'code' => 'MOBO', 'status' => '1'],
            ['province_id' => 5, 'name' => 'San Pascual', 'code' => 'SAN_PASCUAL', 'status' => '1'],
            ['province_id' => 5, 'name' => 'Uson', 'code' => 'USON', 'status' => '1'],

            // Sorsogon
            ['province_id' => 6, 'name' => 'Sorsogon City', 'code' => 'SORSONC', 'status' => '1'],
            ['province_id' => 6, 'name' => 'Bulusan', 'code' => 'BULUSAN', 'status' => '1'],
            ['province_id' => 6, 'name' => 'Casiguran', 'code' => 'CASIGURAN', 'status' => '1'],
            ['province_id' => 6, 'name' => 'Donsol', 'code' => 'DONOL', 'status' => '1'],
            ['province_id' => 6, 'name' => 'Gubat', 'code' => 'GUBAT', 'status' => '1'],
            ['province_id' => 6, 'name' => 'Irosin', 'code' => 'IROSIN', 'status' => '1'],
            ['province_id' => 6, 'name' => 'Prieto Diaz', 'code' => 'PRIETO_DIAZ', 'status' => '1'],
            ['province_id' => 6, 'name' => 'Sorsogon', 'code' => 'SORSON', 'status' => '1'],
        ];

        // Insert the data into the municipalities table
        DB::table('municipalities')->insert($municipalities);
    }
}
