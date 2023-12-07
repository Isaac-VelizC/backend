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
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->integer('porcion');
            $table->string('imagen')->nullable();
            $table->integer('tiempo')->nullable();
            $table->string('ocasion')->nullable();
            $table->timestamps();
        });

        Schema::create('ingrediente_recetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('cantidad');
            $table->string('unida_media')->nullable();
            $table->unsignedBigInteger('receta_id')->nullable();
            $table->foreign('receta_id')->references('id')->on('recetas')->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('pasos_recetas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('paso')->nullable();
            $table->unsignedBigInteger('receta_id')->nullable();
            $table->foreign('receta_id')->references('id')->on('recetas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
