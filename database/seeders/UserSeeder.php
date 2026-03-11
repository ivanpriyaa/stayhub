<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        $data = [
            [
                'nama_user' => 'admin',
                'username' => 'admin',
                'password' => Hash::make('admin123'),

            ]
        ];
        foreach ($data as $value) {
            User::insert([
                'nama_user' => $value['nama_user'],
                'username' => $value['username'],
                'password' => $value['password'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
