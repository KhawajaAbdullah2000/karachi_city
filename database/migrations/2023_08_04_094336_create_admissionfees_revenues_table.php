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
        Schema::create('admissionfees_revenues', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable();
            $table->date('fees_for'); //month and year
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('set null')->onDelete('set null');
            $table->timestamps();
            $table->unique(['student_id','fees_for']);
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissionfees_revenues');
    }
};
