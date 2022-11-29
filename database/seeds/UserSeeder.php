<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
        	[
        		'name' 			 => 'Admin John Doe',
                'username'       => 'admin',
        		'email'			 => 'admin@mail.com',
        		'password' 		 => Hash::make(123123),
        		'roles_id'		 => 1,
                'created_at'    => Carbon::now()
        	],
        	[
        		'name' 			 => 'Kepala Cabang Billy',
                'username'       => 'kepala',
        		'email'			 => 'kepala@mail.com',
        		'password' 		 => Hash::make(123123),
        		'roles_id'		 => 2,
                'created_at'    => Carbon::now()
        	],
        	[
        		'name' 			 => 'Kaptain Dapur Rizky',
                'username'       => 'kaptain',
        		'email'			 => 'kaptain@mail.com',
        		'password' 		 => Hash::make(123123),
        		'roles_id'		 => 3,
                'created_at'    => Carbon::now()
        	],
            [
                'name'           => 'CS Rifky',
                'username'       => 'cs',
                'email'          => 'cs@mail.com',
                'password'       => Hash::make(123123),
                'roles_id'        => 4,
                'created_at'    => Carbon::now()
            ],
            [
                'name'           => 'Crew Aditya',
                'username'       => 'crew',
                'email'          => 'crew@mail.com',
                'password'       => Hash::make(123123),
                'roles_id'        => 5,
                'created_at'    => Carbon::now()
            ],
            [
                'name'           => 'Direktur Teddy',
                'username'       => 'direktur',
                'email'          => 'direktur@mail.com',
                'password'       => Hash::make(123123),
                'roles_id'        => 6,
                'created_at'    => Carbon::now()
            ],
            [
                'name'           => 'Manager Rifai',
                'username'       => 'manager',
                'email'          => 'manager@mail.com',
                'password'       => Hash::make(123123),
                'roles_id'        => 7,
                'created_at'    => Carbon::now()
            ],
            [
                'name'           => 'PPIC Pambudi',
                'username'       => 'ppic',
                'email'          => 'ppic@mail.com',
                'password'       => Hash::make(123123),
                'roles_id'        => 8,
                'created_at'    => Carbon::now()
            ]
        ]);
    }
}
