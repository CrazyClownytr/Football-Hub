<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->enum('status', ['active', 'inactive'])->default('active');

//            $table->string('status')->default('active');
//            // Voeg een check constraint toe
//            $table->check("status IN ('active', 'inactive')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
