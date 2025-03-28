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
        Schema::create('strengths', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('descripcionshort')->nullable();
            $table->string('link1')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('icono')->nullable();
            $table->string('imagen')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strengths');
    }
};
