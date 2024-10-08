<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'email' => 'andy@gmail.com',
            'name' => 'andy',
            'password' => Hash::make('andi123'),
            'role' => 'superadmin',
        ]);

        $superadmin->assignRole('superadmin');

        $dev = User::create([
            'email' => 'dev@gmail.com',
            'name' => 'dev',
            'password' => Hash::make('dev123'),
            'role' => 'superadmin',
        ]);

        $dev->assignRole('superadmin');

        $sales = User::create([
            'email' => 'sales@gmail.com',
            'name' => 'sales',
            'password' => Hash::make('sales123'),
            'role' => 'sales',
        ]);

        $sales->assignRole('sales');
    }
}
