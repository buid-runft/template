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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();

            $table->enum('payment_method', ['bank_transfer', 'qr_code', 'credit_card']);
            $table->decimal('amount', 15, 2);
            $table->string('transaction_id')->unique()->nullable();
            $table->string('payment_slip')->nullable();

            $table->enum('status', ['pending', 'confirmed', 'rejected', 'expired'])->default('pending');
            $table->text('rejection_reason')->nullable();

            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->json('payment_details')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['order_id', 'status']);
            $table->index('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
