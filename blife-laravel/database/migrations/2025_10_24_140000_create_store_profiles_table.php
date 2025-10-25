<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            
            $table->text('description')->nullable();
            $table->text('story')->nullable();
            $table->text('mission')->nullable();
            
            $table->string('logo_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->json('banner_images')->nullable();
            
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            
            $table->json('social_links')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->unique('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_profiles');
    }
};
