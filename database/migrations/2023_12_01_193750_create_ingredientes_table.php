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
        Schema::create('tipo_ingredientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        Schema::create('ingredientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->integer('cantidad');
            $table->boolean('estado')->default(false);
            $table->unsignedBigInteger('tipo_ing_id')->nullable();
            $table->foreign('tipo_ing_id')->references('id')->on('tipo_ingredientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredientes');
    }
};
