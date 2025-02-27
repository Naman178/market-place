<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coupon_code')->unique();
            $table->enum('discount_type', ['flat', 'percentage']);
            $table->decimal('discount_value', 10, 2);
            $table->bigInteger('max_discount')->nullable();
            $table->dateTime('valid_from');
            $table->dateTime('valid_until')->nullable();
            $table->decimal('min_cart_amount', 10, 2)->nullable();
            $table->enum('applicable_type', ['all', 'category', 'sub-category', 'product']);
            $table->json('applicable_selection')->nullable();
            $table->enum('applicable_for', ['one-time', 'recurring', 'both']);
            $table->integer('limit_per_user')->nullable();
            $table->integer('total_redemptions')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('auto_apply', ['no', 'yes'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
