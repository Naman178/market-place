<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('seo')) {
            Schema::create('seo', function (Blueprint $table) {
                $table->id();
                $table->string('page')->unique();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->string('keyword')->nullable();
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
        if (Schema::hasTable('seo')) {
            Schema::dropIfExists('seo');
        }
    }
}
