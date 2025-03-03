<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('invoice')) {
            Schema::create('invoice', function (Blueprint $table) {
                $table->id();
                $table->text('orderid');
                $table->text('user_id');
                $table->text('transaction_id');
                $table->text('invoice_number');
                $table->text('subtotal');
                $table->text('gst_percentage');
                $table->text('discount_type');
                $table->text('discount');
                $table->text('applied_coupon');
                $table->text('total');
                $table->text('payment_method');
                $table->text('payment_status');
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
        if (Schema::hasTable('invoice')) {
            Schema::dropIfExists('invoice');
        }
    }
}
