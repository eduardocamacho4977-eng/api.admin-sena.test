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
        Schema::create('apprentices', function (Blueprint $table) {
            $table->id();
            //campos  
            $table->string('name');
            $table->string('email');
            $table->string('cell_number');
            $table->string('imagen_url');
            $table->string('imagen_public_id');

            // llaves foraneas de courses y computers
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('computer_id')->nullable();

            // Referencia courses
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')->onDelete('set null');

            // Referencia  computers
            $table->foreign('computer_id')
                ->references('id')
                ->on('computers')->onDelete('set null');

            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apprentices');
    }
};
