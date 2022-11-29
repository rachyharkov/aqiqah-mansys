<?php

/*
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ParseCsv\Csv;

class IndoRegionProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @deprecated
     *
     * @return void
     */
    public function run()
    {
        $csv = new Csv(public_path('/data/provinces.csv'));
        // [
        //     "Code" => "94"
        //     "Parent" => "62"
        //     "Name" => "PAPUA"
        //     "Latitude" => "-4.0912830155479"
        //     "Longitude" => "137.65753146755"
        //     "Postal" => "90000,98000,99000"
        //   ]
        DB::table('indoregion_provinces')->truncate();
        foreach ($csv->data as $province) {
            DB::table('indoregion_provinces')
                ->insert([
                    'id' => $province['Code'],
                    'name' => $province['Name'],
                ]);
        }
    }
}
