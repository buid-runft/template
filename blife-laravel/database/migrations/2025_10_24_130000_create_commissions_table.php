<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('from_user_id')->constrained('users');
            $table->foreignId('order_id')->constrained();
            
            $table->decimal('pv_amount', 15, 2);
            $table->decimal('commission_amount', 15, 2);
            $table->string('commission_type');
            $table->integer('level');
            
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'status']);
            $table->index(['order_id', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
