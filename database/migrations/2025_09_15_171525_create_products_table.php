<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('images')->nullable();                // multiple image paths (public disk)
            $table->decimal('original_price', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2);             // main price (shown)
            $table->unsignedInteger('stock')->default(0);      // inventory count
            $table->boolean('is_active')->default(true);       // availability toggle
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
