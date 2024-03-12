<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'reviews-list']);
        Permission::create(['name' => 'reviews-create']);
        Permission::create(['name' => 'reviews-edit']);
        Permission::create(['name' => 'reviews-delete']);
        Permission::create(['name' => 'reviews-tab-show']);
    }
}
