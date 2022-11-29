<?php

use App\Models\UsersBranch;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UsersBranch::insert([
            [
                'users_id' => 1,
                'branch_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'users_id' => 2,
                'branch_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'users_id' => 3,
                'branch_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'users_id' => 4,
                'branch_id' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'users_id' => 5,
                'branch_id' => 1,
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
