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
            $table->enum('status', [0,1])->default('1')->comment('0 = inactive, 1 = active');
            $table->enum('sys_state',[0,1,-1])->comment('0 = active, 1 = inactive, -1 = deleted');
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
