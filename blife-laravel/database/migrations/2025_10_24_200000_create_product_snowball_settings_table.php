<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_snowball_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('snowball_plan_type')->default(0);
            
            $table->decimal('custom_multiplier', 8, 4)->nullable();
            $table->decimal('fixed_points_per_unit', 10, 2)->nullable();
            $table->boolean('use_custom_calculation')->default(false);
            
            $table->integer('min_quantity_for_points')->default(1);
            $table->decimal('max_points_per_product', 10, 2)->nullable();
            
            $table->timestamps();

            // Indexes
            $table->unique('product_id');
            $table->index('snowball_plan_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_snowball_settings');
    }
};
