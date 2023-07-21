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
        Schema::table('monthly_fees', function (Blueprint $table) {
            $table->string('month');
            $table->string('year');
            $table->unique(['student_id','month','year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_fees', function (Blueprint $table) {
            //
        });
    }
};
