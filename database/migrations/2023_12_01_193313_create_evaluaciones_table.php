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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('curso_habilitados')->onDelete('restrict');
            $table->unsignedBigInteger('tipo_id')->nullable();
            $table->foreign('tipo_id')->references('id')->on('tipo_trabajos')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('titulo', 100);
            $table->text('descripcion')->nullable();
            $table->dateTime('inico')->default(now());
            $table->dateTime('fin');
            $table->boolean('con_nota')->default(true);
            $table->bigInteger('nota')->nullable();
            $table->boolean('visible')->default(false);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
