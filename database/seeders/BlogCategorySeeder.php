<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  
     public function run()
     {
        Permission::create(['name' => 'Blog_category-list']);
        Permission::create(['name' => 'Blog_category-create']);
        Permission::create(['name' => 'Blog_category-edit']);
        Permission::create(['name' => 'Blog_category-delete']);
        Permission::create(['name' => 'Blog_category-tab-show']);
     }
}
