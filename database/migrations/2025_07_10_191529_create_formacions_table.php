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
        Schema::create('formacions', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('instructor');
            $table->integer('duracion_horas');
            $table->decimal('precio', 8, 2);
            $table->string('categoria');
            $table->enum('nivel', ['principiante', 'intermedio', 'avanzado']);
            $table->datetime('fecha_inicio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formacions');
    }
};
