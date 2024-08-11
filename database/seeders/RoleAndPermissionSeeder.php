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
        Permission::create(['name' => 'product-item-admin']);
        Permission::create(['name' => 'product-stock-admin']);
        Permission::create(['name' => 'product-transaction-admin']);
        
        Role::create([
            'name' => 'sales',
            'guard_name' => 'web'
        ])->givePermissionTo(['product-admin', 'product-transaction-admin']);

        Role::create([
            'name' => 'superadmin',
            'guard_name' => 'web'
        ])->givePermissionTo(['product-admin', 'product-item-admin', 'product-stock-admin', 'product-transaction-admin']);
    }
}
