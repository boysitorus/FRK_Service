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
    public function run(): void
    {
        //
        User::create([
            'name'=>'Wilona Diva Artha Simbolon',
            'username'=>'wilona.simbolon',
            'password'=>'wilona00',
            'jabatan'=>'dosen',
        ]); 
    }
}
