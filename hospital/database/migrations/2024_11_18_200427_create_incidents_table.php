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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->json('patient');
            $table->json('emergency');
            $table->json('ambulance');
            $table->boolean('ongoing')->default(false);
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('what')->nullable();
            $table->string('when')->nullable();
            $table->string('where')->nullable();
            $table->text('actions_taken')->nullable();
            $table->integer('time_on_call')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
