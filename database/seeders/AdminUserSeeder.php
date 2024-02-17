<?php

namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $user = User::create([
            'name' => 'Super Admin', 
            'fname' => 'Super',
            'lname' => 'Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('admin@123')
        ]);
        
        // Creating the permission
        Permission::create(['name' => 'role-list']);
        Permission::create(['name' => 'role-create']);
        Permission::create(['name' => 'role-edit']);
        Permission::create(['name' => 'role-delete']);
        Permission::create(['name' => 'role-tab-show']);
        Permission::create(['name' => 'user-list']);
        Permission::create(['name' => 'user-create']);
        Permission::create(['name' => 'user-edit']);
        Permission::create(['name' => 'user-delete']);
        Permission::create(['name' => 'user-tab-show']);
        Permission::create(['name' => 'settings-tab-show']);

        // Creating the role
        $role = Role::create(['name' => 'Super Admin']);

        // Giving all permission to the user - superadmin
        $role->givePermissionTo(Permission::all());
        
        // Assign the the superadmin role to user 
        $user->assignRole([$role->id]);
    }
}
