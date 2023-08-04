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
        Schema::create('monthlyfees_revenues', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id');
            $table->date('fees_for'); //month and year
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id');
            $table->integer('amount');
            $table->timestamps();
            $table->unique(['student_id','fees_for']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthlyfees_revenues');
    }
};
