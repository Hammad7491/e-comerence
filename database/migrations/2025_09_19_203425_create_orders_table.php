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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('name');
        $table->string('phone', 50);
        $table->text('address');
        $table->enum('payment_method', ['cod','online']);
        $table->string('payment_proof')->nullable(); // public disk path
        $table->decimal('total', 12, 2)->default(0);
        $table->string('status')->default('pending'); // pending/approved/rejected
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
