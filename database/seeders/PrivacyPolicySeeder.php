<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PrivacyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'privacy-policy-list']);
        Permission::create(['name' => 'privacy-policy-create']);
        Permission::create(['name' => 'privacy-policy-edit']);
        Permission::create(['name' => 'privacy-policy-delete']);
        Permission::create(['name' => 'privacy-policy-tab-show']);
    }
}
