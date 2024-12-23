<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class TermAndConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'term-condition-list']);
        Permission::create(['name' => 'term-condition-create']);
        Permission::create(['name' => 'term-condition-edit']);
        Permission::create(['name' => 'term-condition-delete']);
        Permission::create(['name' => 'term-condition-tab-show']);
    }
}
