<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubIdToItemsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('items_pricing__tbl', 'sub_id')) {
            Schema::table('items_pricing__tbl', function (Blueprint $table) {
                $table->integer('sub_id')->nullable()->after('id');
            });
        }

        if (!Schema::hasColumn('items_images__tbl', 'sub_id')) {
            Schema::table('items_images__tbl', function (Blueprint $table) {
                $table->integer('sub_id')->nullable()->after('id');
            });
        }

        if (!Schema::hasColumn('items_features__tbl', 'sub_id')) {
            Schema::table('items_features__tbl', function (Blueprint $table) {
                $table->integer('sub_id')->nullable()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('items_pricing__tbl', 'sub_id')) {
            Schema::table('items_pricing__tbl', function (Blueprint $table) {
                $table->dropColumn('sub_id');
            });
        }

        if (Schema::hasColumn('items_images__tbl', 'sub_id')) {
            Schema::table('items_images__tbl', function (Blueprint $table) {
                $table->dropColumn('sub_id');
            });
        }

        if (Schema::hasColumn('items_features__tbl', 'sub_id')) {
            Schema::table('items_features__tbl', function (Blueprint $table) {
                $table->dropColumn('sub_id');
            });
        }
    }
}
