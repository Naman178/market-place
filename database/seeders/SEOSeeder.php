<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class SEOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   
     public function run()
     {
        Permission::create(['name' => 'SEO-list']);
        Permission::create(['name' => 'SEO-create']);
        Permission::create(['name' => 'SEO-edit']);
        Permission::create(['name' => 'SEO-delete']);
        Permission::create(['name' => 'SEO-tab-show']);
     }
}
