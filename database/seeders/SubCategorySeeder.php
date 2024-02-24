<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'sub-category-list']);
        Permission::create(['name' => 'sub-category-create']);
        Permission::create(['name' => 'sub-category-edit']);
        Permission::create(['name' => 'sub-category-delete']);
        Permission::create(['name' => 'sub-category-tab-show']);
    }
}
