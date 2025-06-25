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
            if (!Schema::hasColumn('comments', 'commentable_type')) {
                $table->morphs('commentable');
            }
            if (!Schema::hasColumn('comments', 'deleted_at')) {
                $table->softDeletes();
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'parent_id', 'body', 'item_id', 'commentable_type', 'commentable_id', 'deleted_at']);
        });
    }
};
