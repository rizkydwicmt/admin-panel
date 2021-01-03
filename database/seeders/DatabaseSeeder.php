<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'username' => 'zaenal', 
                'password' => 'admin', 
            ],
            [
                'username' => 'rizky', 
                'password' => 'admin', 
            ],
        ];

        
        foreach($datas as $data){

            $query = Admin::create([
                'username' => $data['username'], 
                'password' => bcrypt($data['password'].env('SALT')),
                'status' => 1,
            ]);

        }
        
        // \App\Models\User::factory(10)->create();
    }
}
