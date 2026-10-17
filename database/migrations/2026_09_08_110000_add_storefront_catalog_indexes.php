<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('slug', 'store_products_slug');
            $table->index(['status', 'created_at'], 'store_products_latest');
            $table->index(['category_id', 'status'], 'store_products_category');
            $table->index(['subcategory_id', 'status'], 'store_products_subcategory');
            $table->index(['is_bestseller', 'status'], 'store_products_bestseller');
        });
        Schema::table('product_variants', function (Blueprint $table) {
            $table->index('product_id', 'store_variants_product');
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->index('slug', 'store_subcategories_slug');
            $table->index('category_id', 'store_subcategories_category');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            foreach (['slug', 'latest', 'category', 'subcategory', 'bestseller'] as $index) {
                $table->dropIndex('store_products_'.$index);
            }
        });
        Schema::table('product_variants', fn (Blueprint $table) => $table->dropIndex('store_variants_product'));
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropIndex('store_subcategories_slug');
            $table->dropIndex('store_subcategories_category');
        });
    }
};
