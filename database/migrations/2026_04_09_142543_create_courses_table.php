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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            
              //campos    
            $table->string('course_number',45);
            $table->string('day',45);
            $table->string('imagen_url');
            $table->string('imagen_public_id');

            // llaves foraneas
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('training_center_id')->nullable();

            // Referenciando tabla areas
            $table->foreign('area_id')
                ->references('id')
                ->on('areas')->onDelete('set null');

            // Referenciando tabla training_centers
            $table->foreign('training_center_id')
                ->references('id')
                ->on('training_centers')->onDelete('set null');

            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
