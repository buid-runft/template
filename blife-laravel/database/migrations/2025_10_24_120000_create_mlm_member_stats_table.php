<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mlm_member_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->decimal('total_pv', 15, 2)->default(0);
            $table->decimal('total_commission', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->integer('team_size')->default(0);
            $table->integer('left_team_size')->default(0);
            $table->integer('right_team_size')->default(0);
            
            $table->timestamp('last_calculation_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->unique('user_id');
            $table->index(['total_pv', 'total_commission']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mlm_member_stats');
    }
};
