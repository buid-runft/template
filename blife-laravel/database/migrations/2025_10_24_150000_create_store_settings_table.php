<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            
            $table->string('theme_color', 7)->default('#3B82F6');
            $table->enum('layout_type', ['grid', 'list', 'mixed'])->default('grid');
            $table->integer('products_per_page')->default(24);
            
            $table->boolean('auto_approve_products')->default(false);
            $table->boolean('low_stock_notification')->default(true);
            
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);
            
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->unique('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
