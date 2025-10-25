<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            
            $table->decimal('price', 15, 2);
            $table->decimal('compare_at_price', 15, 2)->nullable();
            $table->decimal('cost_price', 15, 2)->nullable();
            
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_alert')->default(10);
            $table->boolean('track_quantity')->default(true);
            $table->boolean('allow_backorder')->default(false);
            
            $table->string('main_image')->nullable();
            $table->json('gallery_images')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(false);
            
            $table->integer('view_count')->default(0);
            $table->integer('sold_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->fullText(['name', 'description', 'short_description']);
            $table->index(['store_id', 'category_id']);
            $table->index(['is_active', 'is_featured']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
