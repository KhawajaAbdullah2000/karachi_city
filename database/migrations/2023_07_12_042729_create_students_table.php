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
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->date('DOB');
            $table->string('Gender',8);
            $table->string('email',50);
            $table->string('password',255);
            $table->string('phone',50);
            $table->string('school',50);
            $table->string('medical',150);
            $table->string('parent_email',50);
            $table->string('parent_phone',13);
            $table->string('emergency_name',50);
            $table->string('emergency_contact',13);
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
