<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_id')->nullable();
            $table->string('content_type')->nullable();
            $table->string('content_heading')->nullable();
            $table->string('content_image')->nullable();
            $table->text('content_descriptipn_1')->nullable();
            $table->text('content_descriptipn_2')->nullable();
            $table->timestamps();
            // Adding foreign keys
            $table->foreign('blog_id')->references('blog_id')->on('blog')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_content');
    }
}
