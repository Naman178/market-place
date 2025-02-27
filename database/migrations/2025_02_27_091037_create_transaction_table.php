<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('addon__rec_tbl')) {
            Schema::create('addon__rec_tbl', function (Blueprint $table) {
                $table->id();
                $table->text('upload_category')->nullable();
                $table->text('addon_name')->nullable();
                $table->text('addon_slug')->nullable();
                $table->text('key_features')->nullable();
                $table->text('html_description')->nullable();
                $table->text('thumbnail')->nullable();
                $table->text('main_file')->nullable();
                $table->text('addon_category')->nullable();
                $table->text('tags')->nullable();
                $table->text('regular_price')->nullable();
                $table->enum('sys_state', ['0', '1', '-1'])->default('0');
                $table->text('created_by')->nullable();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('key__rec_tbl')) {
            Schema::create('key__rec_tbl', function (Blueprint $table) {
                $table->id();
                $table->text('key')->nullable();
                $table->text('user_id')->nullable();
                $table->text('order_id')->nullable();
                $table->text('product_id')->nullable();
                $table->text('creared_at')->nullable();
                $table->text('expire_at')->nullable();
                $table->text('key_used_limit')->nullable();
                $table->enum('sys_state', ['0', '1', '-1'])->default('0');
                $table->timestamps();
            });
        }
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
                $table->text('order_count')->nullable();
                $table->text('order_limit')->nullable();
                $table->enum('sys_state', ['0', '1', '-1'])->default('0');
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('transaction__rec_tbl')) {
            Schema::create('transaction__rec_tbl', function (Blueprint $table) {
                $table->id();
                $table->text('user_id')->nullable();
                $table->text('product_id')->nullable();
                $table->text('payment_status')->nullable();
                $table->text('payment_amount')->nullable();
                $table->text('razorpay_payment_id')->nullable();
                $table->text('payment_method')->nullable();
                $table->text('transaction_id')->nullable();
                $table->enum('sys_state', ['0', '1', '-1'])->default('0');
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('user_customer__rec_tbl')) {
            Schema::create('user_customer__rec_tbl', function (Blueprint $table) {
                $table->id();
                $table->text('contact_number')->nullable();
                $table->text('email')->nullable();
                $table->text('register_under_user_id')->nullable();
                $table->text('site_url')->nullable();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('user_inquiry__rec_tbl')) {
            Schema::create('user_inquiry__rec_tbl', function (Blueprint $table) {
                $table->id();
                $table->text('full_name')->nullable();
                $table->text('email')->nullable();
                $table->text('contact_number')->nullable();
                $table->text('website_url')->nullable();
                $table->text('message')->nullable();
                $table->text('stack')->nullable();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('wallet__rec_tbl')) {
            Schema::create('wallet__rec_tbl', function (Blueprint $table) {
                $table->id();
                $table->text('user_id')->nullable();
                $table->text('product_id')->nullable();
                $table->text('wallet_amount')->nullable();
                $table->text('total_order')->nullable();
                $table->text('remaining_order')->nullable();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('woocommerce_order_history__rec_tbl')) {
            Schema::create('woocommerce_order_history__rec_tbl', function (Blueprint $table) {
                $table->id();
                $table->text('user_id')->nullable();
                $table->text('plan_id')->nullable();
                $table->text('woocommerce_order_id')->nullable();
                $table->text('woocommerce_order_total')->nullable();
                $table->text('woocommerce_order_date')->nullable();
                $table->text('woocommerce_order_url')->nullable();
                $table->text('per_order_price')->nullable();
                $table->text('remaining_wallet_amount')->nullable();
                $table->timestamps();
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
        if (Schema::hasTable('addon__rec_tbl')) {
            Schema::dropIfExists('addon__rec_tbl');
        }
        if (Schema::hasTable('key__rec_tbl')) {
            Schema::dropIfExists('key__rec_tbl');
        }
        if (Schema::hasTable('order__rec_tbl')) {
            Schema::dropIfExists('order__rec_tbl');
        }
        if (Schema::hasTable('transaction__rec_tbl')) {
            Schema::dropIfExists('transaction__rec_tbl');
        }
        if (Schema::hasTable('user_customer__rec_tbl')) {
            Schema::dropIfExists('user_customer__rec_tbl');
        }
        if (Schema::hasTable('user_inquiry__rec_tbl')) {
            Schema::dropIfExists('user_inquiry__rec_tbl');
        }
        if (Schema::hasTable('wallet__rec_tbl')) {
            Schema::dropIfExists('wallet__rec_tbl');
        }
        if (Schema::hasTable('woocommerce_order_history__rec_tbl')) {
            Schema::dropIfExists('woocommerce_order_history__rec_tbl');
        }
    }
}
