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
        Schema::create('temas', function (Blueprint $table) {
            $table->id();
            $table->string('tema');
            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('curso_habilitados')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('tipo_trabajos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
        });

        Schema::create('trabajos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_id')->nullable();
            $table->foreign('tipo_id')->references('id')->on('tipo_trabajos')->onDelete('cascade');
            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('curso_habilitados')->onDelete('restrict');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('tema_id')->nullable();
            $table->foreign('tema_id')->references('id')->on('temas')->onDelete('cascade');
            $table->unsignedBigInteger('criterio_id')->nullable();
            $table->foreign('criterio_id')->references('id')->on('criterios')->onDelete('cascade');
            $table->unsignedBigInteger('ingrediente_id')->nullable();
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes')->onDelete('cascade');
            $table->unsignedBigInteger('receta_id')->nullable();
            $table->foreign('receta_id')->references('id')->on('recetas')->onDelete('cascade');
            $table->boolean('evaluacion')->default(false);
            $table->string('titulo', 100);
            $table->text('descripcion')->nullable();
            $table->dateTime('inico')->default(now());
            $table->dateTime('fin')->nullable();
            $table->boolean('con_nota')->default(false);
            $table->bigInteger('nota')->default(0);
            $table->boolean('visible')->default(false);
            $table->string('estado')->default('Borrador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajos');
    }
};
