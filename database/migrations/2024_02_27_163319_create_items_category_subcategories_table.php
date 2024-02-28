<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsCategorySubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_category_subcategories__tbl', function (Blueprint $table) {
            $table->foreignId('item_id')->constrained('items__tbl')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories__tbl');
            $table->foreignId('subcategory_id')->constrained('sub_categories__tbl');
            $table->timestamps();
        
            $table->primary(['item_id', 'category_id', 'subcategory_id'], 'custom_primary_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_category_subcategories__tbl');
    }
}
