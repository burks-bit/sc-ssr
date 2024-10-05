<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barangay;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangays = [
            // Barangays in Polangui
            ['municipality_id'=>'1', 'code' => 'POL001', 'name' => 'Balangibang', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL002', 'name' => 'Balinad', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL003', 'name' => 'Basud', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL004', 'name' => 'Bautista', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL005', 'name' => 'Binanuaan', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL006', 'name' => 'Centro Occidental (Poblacion)', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL007', 'name' => 'Centro Oriental (Poblacion)', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL008', 'name' => 'Danao', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL009', 'name' => 'Kinale', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL010', 'name' => 'La Medalla', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL011', 'name' => 'Lanigay', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL012', 'name' => 'Lidong', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL013', 'name' => 'Magurang', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL014', 'name' => 'Matacon', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL015', 'name' => 'Maynaga', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL016', 'name' => 'Napo', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL017', 'name' => 'Ponso', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL018', 'name' => 'Salvacion', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL019', 'name' => 'Santa Cruz', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL020', 'name' => 'Santo Angel', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL021', 'name' => 'Santicon', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL022', 'name' => 'Sugcad', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL023', 'name' => 'Tagaytay', 'status' => '1'],
            ['municipality_id'=>'1', 'code' => 'POL024', 'name' => 'Ubaliw', 'status' => '1'],
            
            // Barangays in Oas
            ['municipality_id'=>'2', 'code' => 'OAS001', 'name' => 'Badbad', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS002', 'name' => 'Badburon', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS003', 'name' => 'Bagumbayan', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS004', 'name' => 'Bagsa', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS005', 'name' => 'Balayong', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS006', 'name' => 'Balogo', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS007', 'name' => 'Banadero', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS008', 'name' => 'Bangiawon', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS009', 'name' => 'Bogtong', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS010', 'name' => 'Bongoran', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS011', 'name' => 'Busac', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS012', 'name' => 'Cadawag', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS013', 'name' => 'Calzada', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS014', 'name' => 'Calzadan', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS015', 'name' => 'Candelaria', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS016', 'name' => 'Cares', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS017', 'name' => 'Casispalan', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS018', 'name' => 'Centro Poblacion', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS019', 'name' => 'Culiat', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS020', 'name' => 'Dinginan', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS021', 'name' => 'Ilaor Norte', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS022', 'name' => 'Ilaor Sur', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS023', 'name' => 'Iraya Norte', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS024', 'name' => 'Iraya Sur', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS025', 'name' => 'Labini', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS026', 'name' => 'Libon', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS027', 'name' => 'Mabalod-balod', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS028', 'name' => 'Maramba', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS029', 'name' => 'Mayao', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS030', 'name' => 'Nagas', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS031', 'name' => 'Obaliw-Runggi', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS032', 'name' => 'Rizal', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS033', 'name' => 'San Agustin', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS034', 'name' => 'San Antonio', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS035', 'name' => 'San Isidro', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS036', 'name' => 'San Jose', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS037', 'name' => 'San Miguel', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS038', 'name' => 'San Pascual', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS039', 'name' => 'San Ramon', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS040', 'name' => 'San Vicente Norte', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS041', 'name' => 'San Vicente Sur', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS042', 'name' => 'Sinimbahan', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS043', 'name' => 'Tabog', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS044', 'name' => 'Tobog', 'status' => '1'],
            ['municipality_id'=>'2', 'code' => 'OAS045', 'name' => 'Tos-tos', 'status' => '1']
        ];

        foreach ($barangays as $barangay) {
            Barangay::create($barangay);
        }
    }
}
