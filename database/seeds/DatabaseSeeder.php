<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	RoleSeeder::class,
        	UserSeeder::class,
            BranchSeeder::class,
            UserBranchSeeder::class,
            PaymentSeeder::class,
            PackageSeeder::class,
            AllMenusSeeder::class,
            TypeOrder::class,
            ShippingSeeder::class
        ]);
    }
}
