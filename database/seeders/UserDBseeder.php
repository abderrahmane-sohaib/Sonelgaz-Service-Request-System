<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserDBseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('users')->insert([

            //Admin
            [
                'name' =>'Zemouri rafik',
                 'email'=>'ZemouriRafik@gmail.com',
                 'password'=>Hash::make('qaqa12121313'),
                 'role'=>'admin',
                 'prenom' => NULL,
                 'tel'=>NULL,
                 'status' => NULL,
                 'NumS'=>NULL,
               
            ],

            // //Ingenieur
            // [
            //     'name' =>'toubal',
            //     'email'=>'sohaibtoubal0935@gmail.com',
            //     'password'=>Hash::make('qaqa12121313'),
            //     'tel'=>'0555893001',
            //     'role'=>'ingenieur',
            //     'prenom'=>'sohaib',
            //      'status'=>'active',
            //      'NumS'=>NULL,
                
            // ],
           
            


       ]);
    }
}
