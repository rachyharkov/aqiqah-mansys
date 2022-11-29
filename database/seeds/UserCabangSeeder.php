<?php

use App\Models\UserCabang;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserCabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCabang::insert([
            [
                'user_id' => 1,
                'cabang_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'cabang_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'user_id' => 3,
                'cabang_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'user_id' => 4,
                'cabang_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'user_id' => 5,
                'cabang_id' => 1,
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
