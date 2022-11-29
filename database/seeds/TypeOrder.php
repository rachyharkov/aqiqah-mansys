<?php

use App\Models\TypeOrder as ModelsTypeOrder;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TypeOrder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsTypeOrder::insert([
           ['name' => 'paket aqiqah', 'created_at' => Carbon::now()], 
           ['name' => 'catering umum', 'created_at' => Carbon::now()], 
           ['name' => 'qurban', 'created_at' => Carbon::now()] 
        ]);
    }
}
