<?php

use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shipping::insert([
            [
                'name' => 'dikirim',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'diambil sendiri',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'disalurkan',
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
