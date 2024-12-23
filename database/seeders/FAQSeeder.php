<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Permission::create(['name' => 'FAQ-list']);
       Permission::create(['name' => 'FAQ-create']);
       Permission::create(['name' => 'FAQ-edit']);
       Permission::create(['name' => 'FAQ-delete']);
       Permission::create(['name' => 'FAQ-tab-show']);
    }
}
