<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = [
            [
                'name' => 'Gedung Kolaboratif',
                'description' => 'Gedung utama untuk kolaborasi dan meeting',
                'lat' => -6.2088,
                'lng' => 106.8456,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Gerbang Utama',
                'description' => 'Pintu masuk utama ke area kilang',
                'lat' => -6.2090,
                'lng' => 106.8458,
                'address' => 'Jalan Raya Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'AWI',
                'description' => 'Area Workshop dan Instrumentasi',
                'lat' => -6.2092,
                'lng' => 106.8460,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Shelter Maintenance Area 1',
                'description' => 'Shelter untuk maintenance area 1',
                'lat' => -6.2094,
                'lng' => 106.8462,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Shelter Maintenance Area 2',
                'description' => 'Shelter untuk maintenance area 2',
                'lat' => -6.2096,
                'lng' => 106.8464,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Shelter Maintenance Area 3',
                'description' => 'Shelter untuk maintenance area 3',
                'lat' => -6.2098,
                'lng' => 106.8466,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Shelter Maintenance Area 4',
                'description' => 'Shelter untuk maintenance area 4',
                'lat' => -6.2100,
                'lng' => 106.8468,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Shelter White OM',
                'description' => 'Shelter White untuk operasi dan maintenance',
                'lat' => -6.2102,
                'lng' => 106.8470,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Pintu Masuk Area Kilang Pertamina',
                'description' => 'Pintu masuk khusus area kilang',
                'lat' => -6.2104,
                'lng' => 106.8472,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Marine Region III Pertamina Balongan',
                'description' => 'Area marine dan dermaga',
                'lat' => -6.2106,
                'lng' => 106.8474,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Main Control Room',
                'description' => 'Ruangan kontrol utama kilang',
                'lat' => -6.2108,
                'lng' => 106.8476,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Tank Farm Area 1',
                'description' => 'Area tanki penyimpanan 1',
                'lat' => -6.2110,
                'lng' => 106.8478,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Gedung EXOR',
                'description' => 'Gedung EXOR untuk operasi',
                'lat' => -6.2112,
                'lng' => 106.8480,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Area Produksi Crude Distillation Unit (CDU)',
                'description' => 'Area produksi CDU',
                'lat' => -6.2114,
                'lng' => 106.8482,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'HSSE Demo Room',
                'description' => 'Ruangan demo HSSE',
                'lat' => -6.2116,
                'lng' => 106.8484,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'Gedung Amanah',
                'description' => 'Gedung Amanah untuk kepercayaan',
                'lat' => -6.2118,
                'lng' => 106.8486,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'POC',
                'description' => 'Point of Control',
                'lat' => -6.2120,
                'lng' => 106.8488,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
            [
                'name' => 'JGC',
                'description' => 'Japan Gasoline Company',
                'lat' => -6.2122,
                'lng' => 106.8490,
                'address' => 'Area Kilang Pertamina Balongan',
                'status' => 'active'
            ],
        ];

        foreach ($buildings as $building) {
            Building::create($building);
        }

        $this->command->info('18 buildings created successfully!');
    }
}