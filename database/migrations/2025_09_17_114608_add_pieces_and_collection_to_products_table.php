<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('pieces', ['2-piece', '3-piece'])->default('2-piece')->after('stock');
            $table->enum('collection', ['summer', 'winter', 'spring'])->default('summer')->after('pieces');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['pieces', 'collection']);
        });
    }
};
