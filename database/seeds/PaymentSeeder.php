<?php

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::insert([
            [
                'name' => 'tunai',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'kredit',
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
