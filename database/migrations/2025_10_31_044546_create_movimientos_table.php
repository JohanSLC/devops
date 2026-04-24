<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->enum('tipo', ['Entrada', 'Salida', 'Transferencia', 'Mantenimiento', 'Dado de Baja']);
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->date('fecha');
            $table->string('destino', 150)->nullable();
            $table->text('motivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};