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
        Schema::create('receta_generadas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->json('ingredientes');
            $table->json('pasos');
            $table->integer('tiempo');
            $table->text('descripcion')->nullable();
            $table->string('porciones')->nullable();
            $table->dateTime('fecha')->default(now());
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_generadas');
    }
};
