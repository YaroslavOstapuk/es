<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::create([
            'name' => 'Yaroslav',
            'surname' => 'Ostapuk',
            'email' => 'admin@app.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'User',
            'surname' => 'Partner',
            'email' => 'user@app.com',
            'password' => Hash::make('password'),
        ]);
    }
}
