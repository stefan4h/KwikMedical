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
        Schema::create('emergencies', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('caller_name'); // Name of the person reporting the emergency
            $table->string('caller_phone')->nullable(); // Contact number of the caller
            $table->string('patient_name');
            $table->unsignedBigInteger('patient_id')->nullable(); // Associated patient
            $table->string('nhs_registration_number');
            $table->string('location'); // Location of the emergency
            $table->text('description')->nullable(); // Details about the emergency
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergencies');
    }
};
