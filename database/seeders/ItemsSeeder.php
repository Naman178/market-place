<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'items-list']);
        Permission::create(['name' => 'items-create']);
        Permission::create(['name' => 'items-edit']);
        Permission::create(['name' => 'items-delete']);
        Permission::create(['name' => 'items-tab-show']);
    }
}
