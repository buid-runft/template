<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->foreignId('store_id')->constrained();

            $table->string('product_name');
            $table->string('product_sku');
            $table->decimal('price', 15, 2);
            $table->integer('quantity');
            $table->decimal('total', 15, 2);

            $table->decimal('snowball_points', 15, 2)->default(0);
            $table->decimal('pv_points', 15, 2)->default(0);

            $table->timestamps();

            // Indexes
            $table->index(['order_id', 'store_id']);
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
