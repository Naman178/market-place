<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items__tbl', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('html_description')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('main_file_zip')->nullable();
            $table->string('preview_url')->nullable();
            $table->enum('status', ['Active', 'Deactive'])->default('Active');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('category_id')->references('id')->on('categories__tbl');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories__tbl');
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
        Schema::dropIfExists('items__tbl');
    }
}
