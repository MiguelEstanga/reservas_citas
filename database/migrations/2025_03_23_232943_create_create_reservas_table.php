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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id('id_reserva');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('tipo_evento');
            $table->dateTime('horario');
            $table->string('ubicacion');
            $table->foreignId('id_usuario')->constrained('users', 'id');
            $table->foreignId('id_sala')->constrained('salas', 'id_sala');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_reservas');
    }
};
