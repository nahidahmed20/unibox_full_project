<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add parent_id to categories (only if doesn't exist)
        if (!Schema::hasColumn('categories', 'parent_id')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('id');
                $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            });
        }

        // 2. Migrate data from sub_categories to categories
        if (Schema::hasTable('sub_categories')) {
            $subcategories = DB::table('sub_categories')->get();
            foreach ($subcategories as $sub) {
                $existing = DB::table('categories')->where('slug', $sub->slug)->first();
                if ($existing) {
                    $newId = $existing->id;
                    if(is_null($existing->parent_id)) {
                        DB::table('categories')->where('id', $newId)->update(['parent_id' => $sub->category_id]);
                    }
                } else {
                    $newId = DB::table('categories')->insertGetId([
                        'parent_id' => $sub->category_id,
                        'name' => $sub->name,
                        'slug' => $sub->slug,
                        'image' => $sub->image,
                        'status' => 'active',
                        'created_at' => $sub->created_at,
                        'updated_at' => $sub->updated_at,
                    ]);
                }
                
                if (Schema::hasColumn('products', 'subcategory_id')) {
                    DB::table('products')->where('subcategory_id', $sub->id)->update(['category_id' => $newId]);
                }
            }
        }

        // 4. Drop subcategory_id from products
        if (Schema::hasColumn('products', 'subcategory_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('subcategory_id');
            });
        }
        
        // 5. Drop sub_categories table
        Schema::dropIfExists('sub_categories');
    }

    public function down(): void
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
