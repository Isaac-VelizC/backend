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
        Schema::create('trabajo_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trabajo_id')->nullable();
            $table->foreign('trabajo_id')->references('id')->on('trabajos')->onDelete('cascade');
            $table->unsignedBigInteger('estudiante_id')->nullable();
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->text('descripcion')->nullable();
            $table->decimal('nota')->default(0);
            $table->string('estado')->default('Borrador');
            $table->timestamps();
        });

        Schema::create('preguntas_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pregunta_id')->nullable();
            $table->foreign('pregunta_id')->references('id')->on('preguntas')->onDelete('cascade');
            $table->unsignedBigInteger('estudiante_id')->nullable();
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->text('respuesta')->nullable();
            $table->decimal('nota')->default(0);
            $table->string('estado')->default('Enviado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajo_estudiantes');
    }
};
