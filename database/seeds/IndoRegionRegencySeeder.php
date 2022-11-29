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

class IndoRegionRegencySeeder extends Seeder
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
        $csv = new Csv(public_path('/data/cities.csv'));
        // [
        //     "Code" => "1101"
        //     "Parent" => "11"
        //     "Name" => "SIMEULUE"
        //     "Latitude" => "2.5383346945001"
        //     "Longitude" => "96.038211656001"
        //     "Postal" => "23800"
        // ]
        $totalData = count($csv->data);
        $temp = [];
        DB::table('indoregion_regencies')->truncate();
        foreach ($csv->data as $index => $regency) {
            $temp[] = [
                'id' => $regency['Code'],
                'province_id' => $regency['Parent'],
                'Name' => $regency['Name'],
            ];

            if (count($temp) >= 50 || $index === $totalData - 1) {
                DB::table('indoregion_regencies')
                    ->insert($temp);
                $temp = [];
            }
        }
    }
}
