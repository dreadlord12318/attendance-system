<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name' => 'Diaz Admin',
        'email' => 'admin@diazcollege.edu',
        'password' => Hash::make('admin'), 
        'is_admin' => true,
    ]);
    }
}
