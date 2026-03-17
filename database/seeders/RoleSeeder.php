<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // manage products
        Permission::create(['name' => 'add products']);
        Permission::create(['name' => 'update products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'show product']);
        Permission::create(['name' => 'get products']);

        //manage orders
        Permission::create(['name' => 'place orders']);
        Permission::create(['name' => 'cancel orders']);
        Permission::create(['name' => 'update order status']);
        Permission::create(['name' => 'show order']);
        Permission::create(['name' => 'get orders']);

        // manage categories
        Permission::create(['name' => 'add categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);
        Permission::create(['name' => 'show category']);
        Permission::create(['name' => 'get categories']);

        // manage images
        Permission::create(['name' => 'add images']);
        Permission::create(['name' => 'update images']);
        Permission::create(['name' => 'delete images']);
        Permission::create(['name' => 'show image']);
        Permission::create(['name' => 'get images']);

        // manage users
        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'show user']);
        Permission::create(['name' => 'get users']);

        // manage roles
        Permission::create(['name' => 'add roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'show role']);
        Permission::create(['name' => 'get roles']);

        // manage permissions
        Permission::create(['name' => 'add permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);
        Permission::create(['name' => 'show permission']);
        Permission::create(['name' => 'get permissions']);


        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        
    }
}
