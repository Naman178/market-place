<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToItemsPricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_pricing__tbl', function (Blueprint $table) {
            $table->enum('pricing_type', ['one-time', 'recurring'])->after('item_id');
            $table->text('validity')->nullable();
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'yearly', 'custom'])->nullable()->after('pricing_type');
            $table->integer('custom_cycle_days')->nullable()->after('billing_cycle');
            $table->boolean('auto_renew')->default(false)->after('custom_cycle_days');
            $table->integer('grace_period')->nullable()->after('auto_renew');
            $table->date('expiry_date')->nullable()->after('grace_period');
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
            $table->dropColumn(['pricing_type', 'billing_cycle', 'custom_cycle_days', 'auto_renew', 'grace_period', 'expiry_date']);
        });
    }
}
