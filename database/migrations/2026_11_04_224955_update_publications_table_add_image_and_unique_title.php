<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('publications', function (Blueprint $table) {
        // Add an image column that allows NULL values
        $table->string('image')->nullable()->after('contenu');

        // Make the title unique
        $table->unique('titre');
    });
}

public function down(): void
{
    Schema::table('publications', function (Blueprint $table) {
        $table->dropColumn('image');
        $table->dropUnique(['titre']);
    });
}
};
