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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona_id');
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->foreign('contact_id')->references('id')->on('contactos')->onDelete('cascade');
            $table->unsignedBigInteger('turno_id')->nullable();
            $table->foreign('turno_id')->references('id')->on('horarios')->onDelete('restrict');
            $table->string('direccion')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->boolean('estado')->default(true);
            $table->boolean('graduado')->default(false);
            $table->string('titulo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
