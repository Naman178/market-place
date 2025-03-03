<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SentMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'email-tab-show']);
        Permission::create(['name' => 'email-list']);
        Permission::create(['name' => 'email-sent']);
    }
}
