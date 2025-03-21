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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('ranking');
            $table->string('achievements_name', 30);
            $table->enum('level', ['Kecamatan', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional']);
            $table->string('description');
            $table->enum('type', ['Individu', 'Kelompok']);
            $table->date('date');
            $table->string('recognition');
            $table->binary('certificate')->nullable();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });
        Schema::dropIfExists('achievements');
    }
};
