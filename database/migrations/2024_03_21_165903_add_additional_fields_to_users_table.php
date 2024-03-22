<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('country_code')->nullable()->after('lname');
            $table->string('contact_number')->nullable()->after('lname');
            $table->string('company_name')->nullable()->after('lname');
            $table->string('company_website')->nullable()->after('lname');
            $table->string('country')->nullable()->after('lname');
            $table->string('address_line1')->nullable()->after('lname');
            $table->string('address_line2')->nullable()->after('lname');
            $table->string('city')->nullable()->after('lname');
            $table->string('postal_code')->nullable()->after('lname');
            $table->string('confirm_password')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country_code');
            $table->dropColumn('contact_number');
            $table->dropColumn('company_name');
            $table->dropColumn('company_website');
            $table->dropColumn('country');
            $table->dropColumn('address_line1');
            $table->dropColumn('address_line2');
            $table->dropColumn('city');
            $table->dropColumn('postal_code');
            $table->dropColumn('confirm_password');
        });
    }
}
