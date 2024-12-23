<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
     {
        Permission::create(['name' => 'Blog-list']);
        Permission::create(['name' => 'Blog-create']);
        Permission::create(['name' => 'Blog-edit']);
        Permission::create(['name' => 'Blog-delete']);
        Permission::create(['name' => 'Blog-tab-show']);
     }
}
