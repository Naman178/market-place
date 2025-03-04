<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubscriptionCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subscription')) {
            Schema::create('subscription', function (Blueprint $table) {
                $table->id();
                $table->text('user_id');
                $table->text('subscription_id');
                $table->text('product_id');
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
        if (Schema::hasTable('subscription')) {
            Schema::dropIfExists('subscription');
        }
    }
}
