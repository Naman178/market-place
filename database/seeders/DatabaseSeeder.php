<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminUserSeeder::class,
            BlogCategorySeeder::class,
            BlogSeeder::class,
            ContactCountrySeeder::class,
            CouponSeeder::class,
            FAQSeeder::class,
            ItemsSeeder::class,
            NewsletterSeeder::class,
            PrivacyPolicySeeder::class,
            ReviewsSeeder::class,
            SentMailSeeder::class,
            SEOSeeder::class,
            SubCategorySeeder::class,
            TermAndConditionSeeder::class,
            UpdateContactCountySeeder::class,
        ]);
    }
}
