<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'sandiaz',
            'email' => 'sandiaz@gmail.com',
            'password' => Hash::make('root1234')
        ]);
        $superAdmin->assignRole('Super Admin');

        $superAdmin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('root1234')
        ]);

        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'radjaoloan',
            'email' => 'radjaoloan@gmail.com',
            'password' => Hash::make('root1234')
        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $pengguna = User::create([
            'name' => 'gultom',
            'email' => 'gultom@gmail.com',
            'password' => Hash::make('root1234')
        ]);
        $pengguna->assignRole('pengguna');
    }
}
