<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
        	[
        		'nama'		 => 'Admin',
        		'keterangan' => 'Ini role Admin'
        	],        	
        	[
        		'nama'		 => 'Kepala Cabang',
        		'keterangan' => 'Ini role Kepala Cabang'
        	],
        	[
        		'nama'		 => 'Kaptain Dapur',
        		'keterangan' => 'Ini role Kaptain Dapur'
        	],
            [
                'nama'       => 'CS',
                'keterangan' => 'Ini role CS'
            ],
            [
                'nama'       => 'Crew',
                'keterangan' => 'Ini role Crew'
            ],
            [
                'nama'       => 'Direktur',
                'keterangan' => 'Ini role Direktur'
            ],
            [
                'nama'       => 'Manager',
                'keterangan' => 'Ini role Manager'
            ],
            [
                'nama'       => 'PPIC',
                'keterangan' => 'Ini role PPIC'
            ]
        ]);
    }
}
