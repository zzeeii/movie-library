<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
       $users=[
       [
            'name'=>'zein',
            'email'=>'z@gmail.com',
            'password'=>'123456',

        ],
        [ 
        'name'=>'Ali',
        'email'=>'A@gmail.com',
        'password'=>'123456',


        ],
        [
            'name'=>'youssef',
            'email'=>'youssef@gmail.com',
            'password'=>'123456',

        ],
        [ 
        'name'=>'ptol',
        'email'=>'ptol@gmail.com',
        'password'=>'123456',


        ],
    ];
        foreach ($users as $user) {
            User::create($user);
        }    
   
    }
}
