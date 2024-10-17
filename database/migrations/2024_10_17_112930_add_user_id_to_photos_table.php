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
            $table->unsignedBigInteger('user_id')->nullable()->after('category_id');

            // Voeg een foreign key toe om de relatie met de categories tabel af te dwingen
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            // Eerst de foreign key verwijderen
            $table->dropForeign(['user_id']);

            // Verwijder vervolgens de kolom zelf
            $table->dropColumn('user_id');
        });
    }
};
