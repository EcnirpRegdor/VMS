<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
            'name' => 'Super Admin Demo',
            'email' => 'Admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'dept_id' => '0'
        ]);
    }
}
