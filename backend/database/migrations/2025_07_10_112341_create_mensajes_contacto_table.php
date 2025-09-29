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
        Schema::create('mensajes_contacto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_apellidos');
            $table->string('email');
            $table->string('telefono', 20);
            $table->text('mensaje');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes_contacto');
    }
};
