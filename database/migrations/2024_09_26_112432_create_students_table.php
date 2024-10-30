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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 20);
            $table->string('name', 50);
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('place_of_birth', 50);
            $table->date('date_of_birth');
            $table->string('religion', 30);
            $table->string('phone_number', 20);
            $table->string('address');
            $table->string('photo')->nullable();
            $table->date('admission_date');
            $table->string('guardian_name', 50);
            $table->string('guardian_phone_number', 20);
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
