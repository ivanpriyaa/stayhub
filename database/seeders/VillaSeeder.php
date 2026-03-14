<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('villa')->insert([
            [
                'idvilla' => 'VIL001',
                'nama_villa' => 'Bromo 1',
                'alamat_villa' => 'ksadasd',
                'harga_villa' => 500000,
            ],
            [
                'idvilla' => 'VIL002',
                'nama_villa' => 'Bromo 2',
                'alamat_villa' => 'ksadasd',
                'harga_villa' => 550000,
            ],
            [
                'idvilla' => 'VIL003',
                'nama_villa' => 'Topaz',
                'alamat_villa' => 'ksadasd',
                'harga_villa' => 600000,
            ],
            [
                'idvilla' => 'VIL004',
                'nama_villa' => 'Medan',
                'alamat_villa' => 'ksadasd',
                'harga_villa' => 700000,
            ]
        ]);
    }
}
