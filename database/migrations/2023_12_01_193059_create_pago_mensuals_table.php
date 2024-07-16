<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::create('metodo_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('monto', 10, 2);
            $table->boolean('estado')->default(true);
        });
        
        Schema::create('pago_mensuals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->unsignedBigInteger('metodo_id')->nullable();
            $table->foreign('metodo_id')->references('id')->on('metodo_pagos')->onDelete('restrict');
            $table->unsignedBigInteger('pago_id')->nullable();
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('restrict');
            $table->integer('mes')->nullable();
            $table->integer('anio')->nullable();
            $table->date('fecha')->default(now());
            $table->boolean('pagado')->default(false);
            $table->string('codigo')->unique();
            $table->decimal('monto', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pago_mensuals');
    }
};
