<?php

// Create a new migration that dumps the table structure to log

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Log table structure
        if (Schema::hasTable('user_category_preferences')) {
            $columns = Schema::getColumnListing('user_category_preferences');
            Log::info('UserCategoryPreference table columns:', $columns);
            
            // Try to find any records
            $records = DB::table('user_category_preferences')->get();
            Log::info('UserCategoryPreference records count:', ['count' => $records->count()]);
            
            if ($records->count() > 0) {
                Log::info('Sample record:', (array)$records->first());
            }
        } else {
            Log::warning('user_category_preferences table does not exist!');
        }
        
        // Check if categories table exists
        if (Schema::hasTable('categories')) {
            $categoryColumns = Schema::getColumnListing('categories');
            Log::info('Categories table columns:', $categoryColumns);
            
            $categories = DB::table('categories')->get();
            Log::info('Categories count:', ['count' => $categories->count()]);
            
            if ($categories->count() > 0) {
                Log::info('Sample category:', (array)$categories->first());
            }
        } else {
            Log::warning('categories table does not exist!');
        }
        
        // Check Product model structure
        if (Schema::hasTable('products')) {
            $productColumns = Schema::getColumnListing('products');
            Log::info('Products table columns:', $productColumns);
            
            // Check if any products have category_id
            if (in_array('category_id', $productColumns)) {
                $productsWithCategory = DB::table('products')
                    ->whereNotNull('category_id')
                    ->count();
                    
                Log::info('Products with category_id:', ['count' => $productsWithCategory]);
            } else {
                Log::warning('Products table does not have category_id column!');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nothing to revert
    }
};