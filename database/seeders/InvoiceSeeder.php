<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'invoice-list']);
        Permission::create(['name' => 'invoice-create']);
        Permission::create(['name' => 'invoice-edit']);
        Permission::create(['name' => 'invoice-delete']);
        Permission::create(['name' => 'invoice-tab-show']);
        Permission::create(['name' => 'order-tab-show']);
    }
}
