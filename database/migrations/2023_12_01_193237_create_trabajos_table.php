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

        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->text('pregunta');
            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('curso_habilitados')->onDelete('restrict');
            $table->boolean('con_nota')->default(false);
            $table->bigInteger('nota')->nullable();
            $table->dateTime('inicio')->nullable();
            $table->dateTime('limite')->nullable();
            $table->unsignedBigInteger('tema_id')->nullable();
            $table->foreign('tema_id')->references('id')->on('temas')->onDelete('cascade');
            $table->string('estado')->default('Borrador');
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
