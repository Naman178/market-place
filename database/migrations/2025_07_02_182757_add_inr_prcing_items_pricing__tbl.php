<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('items_pricing__tbl', function (Blueprint $table) {
            if (!Schema::hasColumn('items_pricing__tbl', 'fixed_inr_price')) {
                $table->text('fixed_inr_price')->nullable();
            }
            if (!Schema::hasColumn('items_pricing__tbl', 'sales_inr_price')) {
                $table->text('sales_inr_price')->nullable();
            }
            if (!Schema::hasColumn('items_pricing__tbl', 'gst_percentage_inr')) {
                $table->text('gst_percentage_inr')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
