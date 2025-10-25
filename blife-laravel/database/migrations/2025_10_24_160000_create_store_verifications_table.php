<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            
            $table->string('business_registration_document')->nullable();
            $table->string('id_card_document')->nullable();
            $table->string('bank_account_document')->nullable();
            
            $table->boolean('documents_verified')->default(false);
            $table->boolean('bank_account_verified')->default(false);
            $table->boolean('identity_verified')->default(false);
            
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            
            $table->text('notes')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->unique('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_verifications');
    }
};
