<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFixedPriceColumnInItemsPricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_pricing__tbl', function (Blueprint $table) {
            $table->decimal('fixed_price', 10, 2)->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items_pricing__tbl', function (Blueprint $table) {
            $table->decimal('fixed_price', 10, 2)->nullable(false)->default(0.00)->change();
        });
    }
}
