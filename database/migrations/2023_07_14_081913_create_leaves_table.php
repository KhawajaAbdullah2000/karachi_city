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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('reason');
            $table->string('details');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->foreign('emp_id')->references('id')->on('users')->onUpdate('SET NULL')
            ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
