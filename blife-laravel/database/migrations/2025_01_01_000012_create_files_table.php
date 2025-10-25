<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('related_type')->nullable(); // Polymorphic
            $table->unsignedBigInteger('related_id')->nullable(); // Polymorphic

            $table->string('filename');
            $table->string('original_name');
            $table->string('path');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');

            $table->string('disk')->default('local');
            $table->boolean('is_public')->default(true);

            $table->timestamps();

            // Indexes
            $table->index(['related_type', 'related_id']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
