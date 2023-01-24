<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'product-admin']);
        
        Role::create([
            'name' => 'product-admin',
            'guard_name' => 'web'
        ])->givePermissionTo(['product-admin']);

        Role::create([
            'name' => 'superadmin',
            'guard_name' => 'web'
        ])->givePermissionTo(['product-admin']);
    }
}
