<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $pengguna = Role::create(['name' => 'Pengguna']);

        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            'create-category',
            'edit-category',
            'delete-category',
            'create-books',
            'edit-books',
            'delete-books'
        ]);

        $pengguna->givePermissionTo([
            'create-books',
            'edit-books',
            'delete-books'
        ]);
    }
}
