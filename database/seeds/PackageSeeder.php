<?php

use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::insert([
            [
                'name' => 'Paket Kambing Masak',
                'is_meat' => true,
                'is_offal' => true,
                'is_egg' => false,
                'is_chicken' => false,
                'is_vegetable' => false,
                'is_rice' => true,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Paket Nasi Box Hemat',
                'is_meat' => true,
                'is_offal' => true,
                'is_egg' => false,
                'is_chicken' => false,
                'is_vegetable' => false,
                'is_rice' => true,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Paket Nasi Box Praktis',
                'is_meat' => true,
                'is_offal' => true,
                'is_egg' => true,
                'is_chickent' => false,
                'is_vegetable' => true,
                'is_rice' => true,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Paket Nasi Box Spesial',
                'is_meat' => true,
                'is_offal' => true,
                'is_egg' => false,
                'is_chicken' => true,
                'is_vegetable' => true,
                'is_rice' => true,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Paket Nasi Box Arab',
                'is_meat' => true,
                'is_offal' => true,
                'is_egg' => false,
                'is_chicken' => false,
                'is_vegetable' => false,
                'is_rice' => true,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Paket Ekonomis Mewah (Bento)',
                'is_meat' => true,
                'is_offal' => false,
                'is_egg' => false,
                'is_chicken' => false,
                'is_vegetable' => true,
                'is_rice' => true,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Paket Ekonomis Manis (Bento)',
                'is_meat' => true,
                'is_offal' => false,
                'is_egg' => false,
                'is_chicken' => true,
                'is_vegetable' => false,
                'is_rice' => true,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Paket Aqiqah Tumpeng',
                'is_meat' => true,
                'is_offal' => true,
                'is_egg' => true,
                'is_chicken' => false,
                'is_vegetable' => false,
                'is_rice' => true,
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
