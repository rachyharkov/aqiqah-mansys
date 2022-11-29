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

class IndoRegionVillageSeeder extends Seeder
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
        $csv = new Csv(public_path('/data/villages.csv'));
        // [
        //     "Code" => "1101010001"
        //     "Parent" => "1101010"
        //     "Name" => "LATIUNG"
        //     "Latitude" => ""
        //     "Longitude" => ""
        //     "Postal" => "23895,23898"
        // ]
        $totalData = count($csv->data);
        $temp = [];
        DB::table('indoregion_villages')->truncate();
        foreach ($csv->data as $index => $village) {
            $temp[] = [
                'id' => $village['Code'],
                'district_id' => $village['Parent'],
                'name' => $village['Name'],
            ];

            if (count($temp) > 50 || $index == $totalData - 1) {
                DB::table('indoregion_villages')
                    ->insert($temp);
                $temp = [];
            }
        }
    }
}
