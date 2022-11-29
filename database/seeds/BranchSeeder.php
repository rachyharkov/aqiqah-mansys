<?php

use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::insert([
            [
                'name' => 'cabang 1',
                'address' => 'Jl. cabang 1',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'cabang 2',
                'address' => 'Jl. cabang 2',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'cabang 3',
                'address' => 'Jl. cabang 3',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'cabang 4',
                'address' => 'Jl. cabang 4',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'cabang 5',
                'address' => 'Jl. cabang 5',
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
