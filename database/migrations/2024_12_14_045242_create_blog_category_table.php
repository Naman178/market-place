<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('blog_category')) {
            Schema::create('blog_category', function (Blueprint $table) {
                $table->id('category_id');
                $table->text('name')->nullable();
                $table->text('description')->nullable();
                $table->text('date')->nullable();
                $table->text('image')->nullable();
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
        if (Schema::hasTable('blog_category')) {
            Schema::dropIfExists('blog_category');
        }
    }
}
