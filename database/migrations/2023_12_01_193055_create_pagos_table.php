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
        Schema::create('formas_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
        });

        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('restrict');
            $table->unsignedBigInteger('forma_id')->nullable();
            $table->foreign('forma_id')->references('id')->on('formas_pagos')->onDelete('restrict');
            $table->unsignedBigInteger('est_id')->nullable();
            $table->foreign('est_id')->references('id')->on('estudiantes')->onDelete('restrict');
            $table->dateTime('fecha');
            $table->string('codigo')->unique();
            $table->decimal('monto', 5, 2);
            $table->boolean('estado')->default(true);
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
