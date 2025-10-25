<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mlm_network_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sponsor_id')->nullable()->constrained('users');
            $table->foreignId('placement_id')->nullable()->constrained('users');
            $table->enum('position', ['left', 'right'])->nullable();
            $table->integer('level')->default(0);

            $table->timestamps();

            // Indexes
            $table->unique('user_id');
            $table->index(['sponsor_id', 'position']);
            $table->index('level');
            $table->index(['user_id', 'sponsor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mlm_network_nodes');
    }
};
