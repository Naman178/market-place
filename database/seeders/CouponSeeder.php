<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'coupon-list']);
        Permission::create(['name' => 'coupon-create']);
        Permission::create(['name' => 'coupon-edit']);
        Permission::create(['name' => 'coupon-delete']);
        Permission::create(['name' => 'coupon-tab-show']);
    }
}
