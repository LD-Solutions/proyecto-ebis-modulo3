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
            $table->integer('duracion_horas')->nullable();
            $table->decimal('precio', 8, 2);
            $table->enum('tipo', ['curso', 'video', 'libro', 'webinar']);
            $table->string('categoria');
            $table->enum('nivel', ['principiante', 'intermedio', 'avanzado']);
            $table->datetime('fecha_inicio')->nullable();
            $table->string('archivo_path')->nullable();
            $table->integer('paginas')->nullable();
            $table->string('url_video')->nullable();
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
