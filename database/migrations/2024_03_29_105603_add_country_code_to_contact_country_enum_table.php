<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryCodeToContactCountryEnumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_country__enum', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_country__enum', 'country_code')) {
                $table->longText('country_code')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_country__enum', function (Blueprint $table) {
            $table->dropColumn('country_code');
        });
    }
}
