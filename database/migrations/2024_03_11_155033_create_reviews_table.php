<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews__tbl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('rating');
            $table->text('review');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('sys_state', [0, 1, -1])->comment('0 = active, 1 = inactive, -1 = deleted');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('item_id')->references('id')->on('items__tbl')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews__tbl');
    }
}
