<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
                $table->text('body');
                $table->string('item_id')->nullable();
                $table->morphs('commentable'); // commentable_type + commentable_id
                $table->softDeletes();
                $table->timestamps();
            });
        } else {
            // If table exists, only add missing columns
            Schema::table('comments', function (Blueprint $table) {
                if (!Schema::hasColumn('comments', 'user_id')) {
                    $table->foreignId('user_id')->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('comments', 'parent_id')) {
                    $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
                }
                if (!Schema::hasColumn('comments', 'body')) {
                    $table->text('body');
                }
                if (!Schema::hasColumn('comments', 'item_id')) {
                    $table->string('item_id')->nullable();
                }
                if (!Schema::hasColumn('comments', 'commentable_type') || !Schema::hasColumn('comments', 'commentable_id')) {
                    $table->morphs('commentable');
                }
                if (!Schema::hasColumn('comments', 'deleted_at')) {
                    $table->softDeletes();
                }
                if (!Schema::hasColumn('comments', 'created_at') || !Schema::hasColumn('comments', 'updated_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
