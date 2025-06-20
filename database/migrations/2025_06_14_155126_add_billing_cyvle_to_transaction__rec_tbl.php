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
        Schema::table('transaction__rec_tbl', function (Blueprint $table) {
            $table->string('billing_cycle')->nullable();
            $table->string('product_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction__rec_tbl', function (Blueprint $table) {
            //
        });
    }
};
