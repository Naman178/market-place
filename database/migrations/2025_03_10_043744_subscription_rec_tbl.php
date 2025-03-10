<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubscriptionRecTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subscription_rec_tbl')) {
            Schema::create('subscription_rec_tbl', function (Blueprint $table) {
                $table->id();
                $table->text('user_id');
                $table->text('product_id');
                $table->text('order_id');
                $table->text('invoice_id');
                $table->text('key_id');
                $table->text('status');
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
        if (Schema::hasTable('subscription_rec_tbl')) {
            Schema::dropIfExists('subscription_rec_tbl');
        }
    }
}
