<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make payment_method a normal string large enough for 'cash'/'online'
            $table->string('payment_method', 20)->nullable(false)->change();

            // Ensure this is a nullable string path (storage/app/public/…)
            if (Schema::hasColumn('orders', 'payment_proof_path')) {
                // If you had an old column name, rename it first:
                $table->renameColumn('payment_proof_path', 'payment_proof');
            }

            $table->string('payment_proof')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // If you previously had ENUM and want to revert, you could restore it here.
            // Example (only if you really need to):
            // $table->enum('payment_method', ['cash','online'])->change();
            // $table->string('payment_proof')->nullable()->change();
        });
    }
};
