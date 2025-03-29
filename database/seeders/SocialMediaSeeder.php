<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'SocialMedia-list']);
        Permission::create(['name' => 'SocialMedia-create']);
        Permission::create(['name' => 'SocialMedia-edit']);
        Permission::create(['name' => 'SocialMedia-delete']);
        Permission::create(['name' => 'SocialMedia-tab-show']);
    }
}
