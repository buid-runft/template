<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('snowball_plans', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('plan_type')->unique();
            $table->string('plan_name');
            $table->text('description')->nullable();
            
            $table->string('master_formula')->default('price * quantity * multiplier');
            $table->decimal('base_multiplier', 8, 4)->default(1.0000);
            $table->decimal('currency_factor', 8, 4)->default(1.0000);
            
            $table->boolean('time_limited')->default(false);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_to')->nullable();
            
            $table->decimal('min_order_amount', 15, 2)->default(0);
            $table->decimal('max_points_per_transaction', 10, 2)->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users');
            
            $table->timestamps();

            // Indexes
            $table->index('plan_type');
            $table->index(['time_limited', 'valid_from', 'valid_to']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('snowball_plans');
    }
};
