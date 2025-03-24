<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Testimonial-list']);
        Permission::create(['name' => 'Testimonial-create']);
        Permission::create(['name' => 'Testimonial-edit']);
        Permission::create(['name' => 'Testimonial-delete']);
        Permission::create(['name' => 'Testimonial-tab-show']);
    }
}
