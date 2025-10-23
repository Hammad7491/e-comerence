<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('what_news', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g. HAND EMBROIDERY UNSTITCHED
            $table->string('image')->nullable(); // store image path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('what_news');
    }
};
