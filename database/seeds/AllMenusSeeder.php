<?php

use App\Models\ChickenMenu;
use App\Models\EggMenu;
use App\Models\MeatMenu;
use App\Models\OffalMenu;
use App\Models\RiceMenu;
use App\Models\VegetableMenu;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AllMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // meet menu table
        MeatMenu::insert([
            [
                'name' => 'Semur',
                'created_at'    => Carbon::now()
            ],
            [
                'name' => 'Rendang',
                'created_at'    => Carbon::now()
            ],
            [
                'name' => 'Teriyaki',
                'created_at'    => Carbon::now()
            ],
            [
                'name' => 'BBQ',
                'created_at'    => Carbon::now()
            ]
        ]);

        // offal menu table
        OffalMenu::insert([
            [
                'name' => 'Gule',
                'created_at'    => Carbon::now()
            ],
            [
                'name' => 'Tongseng',
                'created_at'    => Carbon::now()
            ],
            [
                'name' => 'Sop',
                'created_at'    => Carbon::now()
            ],
            [
                'name' => 'Empal Gentong',
                'created_at'    => Carbon::now()
            ],
        ]);

        // egg menu table
        EggMenu::insert([
            ['name' => 'Telur Balado', 'created_at'    => Carbon::now()],
            ['name' => 'Telur Rebus', 'created_at'    => Carbon::now()]
        ]);

        // chicken menu table
        ChickenMenu::insert([
            ['name' => 'Ayam Goreng', 'created_at'    => Carbon::now()],
            ['name' => 'Ayam Bakar', 'created_at'    => Carbon::now()]
        ]);

        // vegetale menu table
        VegetableMenu::insert([
            ['name' => 'Mix Vegetables', 'created_at'    => Carbon::now()],
            ['name' => 'Tumis Buncis', 'created_at'    => Carbon::now()],
            ['name' => 'Tumis Putren', 'created_at'    => Carbon::now()],
            ['name' => 'Mie', 'created_at'    => Carbon::now()],
            ['name' => 'Bihun', 'created_at'    => Carbon::now()],
        ]);

        // rice menu table
        RiceMenu::insert([
            ['name' => 'Nasi Putih', 'created_at'    => Carbon::now()],
            ['name' => 'Nasi Mandhi', 'created_at'    => Carbon::now()],
            ['name' => 'Nasi Kebuli', 'created_at'    => Carbon::now()],
            ['name' => 'Nasi Biryani', 'created_at'    => Carbon::now()],
            ['name' => 'Nasi Kabsah', 'created_at'    => Carbon::now()],
            ['name' => 'Nasi Kuning', 'created_at'    => Carbon::now()],
            ['name' => 'Nasi Uduk', 'created_at'    => Carbon::now()],
        ]);
    }
}
