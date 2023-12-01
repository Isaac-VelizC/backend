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
        Schema::create('evento_cursos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tarea_id')->nullable();
            $table->foreign('tarea_id')->references('id')->on('trabajos')->onDelete('cascade');
            $table->unsignedBigInteger('evaluacion_id')->nullable();
            $table->foreign('evaluacion_id')->references('id')->on('evaluaciones')->onDelete('cascade');
            $table->datetime('start');
            $table->datetime('end')->nullable();
            $table->mediumText('title');
            $table->text('descripcion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_cursos');
    }
};
