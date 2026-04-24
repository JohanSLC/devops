<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->enum('tipo', ['Preventivo', 'Correctivo', 'Predictivo']);
            $table->date('fecha_programada');
            $table->date('fecha_realizada')->nullable();
            $table->text('descripcion');
            $table->text('observaciones')->nullable();
            $table->decimal('costo', 10, 2)->nullable();
            $table->string('tecnico', 150)->nullable();
            $table->enum('estado', ['Pendiente', 'En Proceso', 'Completado', 'Cancelado'])->default('Pendiente');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};