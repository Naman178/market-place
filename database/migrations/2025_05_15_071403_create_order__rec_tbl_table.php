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
        Schema::create('order__rec_tbl', function (Blueprint $table) {
            $table->id();
            $table->text('product_id')->nullable();
            $table->text('user_id')->nullable();
            $table->text('payment_status')->nullable();
            $table->text('payment_amount')->nullable();
            $table->text('razorpay_payment_id')->nullable();
            $table->text('payment_method')->nullable();
            $table->text('transaction_id')->nullable();
            $table->integer('order_count')->default(0);
            $table->integer('order_limit')->default(0);
            $table->enum('sys_state', ['0', '1', '-1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order__rec_tbl');
    }
};