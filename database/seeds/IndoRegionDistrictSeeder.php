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

class IndoRegionDistrictSeeder extends Seeder
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
        $csv = new Csv(public_path('/data/subDistricts.csv'));
        // [
        //     "Code" => "1101010"
        //     "Parent" => "1101"
        //     "Name" => "TEUPAH SELATAN"
        //     "Latitude" => "2.2738827445"
        //     "Longitude" => "96.513062697495"
        //     "Postal" => "23895,23898"
        // ]
        DB::table('indoregion_districts')->truncate();
        foreach ($csv->data as $district) {
            DB::table('indoregion_districts')
                ->insert([
                    'id' => $district['Code'],
                    'regency_id' => $district['Parent'],
                    'name' => $district['Name'],
                ]);
        }
    }
}
