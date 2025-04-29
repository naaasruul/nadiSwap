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
        // Check if the column exists first
        if (Schema::hasColumn('user_category_preferences', 'category')) {
            Schema::table('user_category_preferences', function (Blueprint $table) {
                // Drop the old column if it exists
                $table->dropColumn('category');
            });
        }

        // Only add the new column if it doesn't exist
        if (!Schema::hasColumn('user_category_preferences', 'category_id')) {
            Schema::table('user_category_preferences', function (Blueprint $table) {
                // Add the foreign key column
                $table->unsignedBigInteger('category_id')->after('user_id');
                
                // Add foreign key constraint
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_category_preferences', function (Blueprint $table) {
            if (Schema::hasColumn('user_category_preferences', 'category_id')) {
                // Drop the foreign key constraint first
                $table->dropForeign(['category_id']);
                // Then drop the column
                $table->dropColumn('category_id');
            }
            
            if (!Schema::hasColumn('user_category_preferences', 'category')) {
                // Add back the original column
                $table->string('category')->after('user_id');
            }
        });
    }
};