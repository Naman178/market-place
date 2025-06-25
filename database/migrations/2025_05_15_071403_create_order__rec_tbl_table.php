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
        if (!Schema::hasTable('order__rec_tbl')) {
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
        } else {
            // Optional: update table if some columns are missing
            Schema::table('order__rec_tbl', function (Blueprint $table) {
                if (!Schema::hasColumn('order__rec_tbl', 'product_id')) {
                    $table->text('product_id')->nullable();
                }
                if (!Schema::hasColumn('order__rec_tbl', 'user_id')) {
                    $table->text('user_id')->nullable();
                }
                if (!Schema::hasColumn('order__rec_tbl', 'payment_status')) {
                    $table->text('payment_status')->nullable();
                }
                if (!Schema::hasColumn('order__rec_tbl', 'payment_amount')) {
                    $table->text('payment_amount')->nullable();
                }
                if (!Schema::hasColumn('order__rec_tbl', 'razorpay_payment_id')) {
                    $table->text('razorpay_payment_id')->nullable();
                }
                if (!Schema::hasColumn('order__rec_tbl', 'payment_method')) {
                    $table->text('payment_method')->nullable();
                }
                if (!Schema::hasColumn('order__rec_tbl', 'transaction_id')) {
                    $table->text('transaction_id')->nullable();
                }
                if (!Schema::hasColumn('order__rec_tbl', 'order_count')) {
                    $table->integer('order_count')->default(0);
                }
                if (!Schema::hasColumn('order__rec_tbl', 'order_limit')) {
                    $table->integer('order_limit')->default(0);
                }
                if (!Schema::hasColumn('order__rec_tbl', 'sys_state')) {
                    $table->enum('sys_state', ['0', '1', '-1'])->default('0');
                }
                if (!Schema::hasColumn('order__rec_tbl', 'created_at') || !Schema::hasColumn('order__rec_tbl', 'updated_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order__rec_tbl');
    }
};