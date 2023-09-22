<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('monthlyfees_revenues', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable()->change();
            DB::statement('ALTER TABLE monthlyfees_revenues DROP FOREIGN KEY monthlyfees_revenues_student_id_foreign');
        
            // Add the foreign key constraint with SET NULL on UPDATE and DELETE
            DB::statement('ALTER TABLE monthlyfees_revenues ADD CONSTRAINT monthlyfees_revenues_student_id_foreign2
                           FOREIGN KEY (student_id)
                           REFERENCES students (id)
                           ON UPDATE SET NULL
                           ON DELETE SET NULL');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthlyfees_revenues', function (Blueprint $table) {
            //
        });
    }
};
