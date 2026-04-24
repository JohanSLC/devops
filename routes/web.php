<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ConfiguracionController;

// Redirección a login
Route::get('/', function () {
    return redirect('login');
});

// Autenticación con Breeze
require __DIR__.'/auth.php';

// ========== RUTAS PROTEGIDAS POR AUTENTICACIÓN ==========
Route::middleware(['auth'])->group(function () {
    
    // ========== DASHBOARD (Todos los usuarios) ==========
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // ========== REPORTES (Todos los usuarios - Solo lectura) ==========
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::get('/inventario-general', [ReporteController::class, 'inventarioGeneral'])->name('inventario-general');
        Route::get('/equipos-por-estado', [ReporteController::class, 'equiposPorEstado'])->name('equipos-por-estado');
        Route::get('/equipos-por-categoria', [ReporteController::class, 'equiposPorCategoria'])->name('equipos-por-categoria');
        Route::get('/valor-inventario', [ReporteController::class, 'valorInventario'])->name('valor-inventario');
        Route::get('/historial-equipo/{equipo?}', [ReporteController::class, 'historialEquipo'])->name('historial-equipo');
        Route::get('/usuarios-actividad', [ReporteController::class, 'usuariosActividad'])->name('usuarios-actividad');
        Route::get('/movimientos', [ReporteController::class, 'movimientos'])->name('movimientos');
        Route::get('/mantenimientos', [ReporteController::class, 'mantenimientos'])->name('mantenimientos');
    });

    // ========== RUTAS SOLO PARA ADMINISTRADORES ==========
    Route::middleware(['admin'])->group(function () {
        
        // INVENTARIO (EQUIPOS) - Solo Admin puede crear, editar, eliminar
        Route::post('/inventario', [EquipoController::class, 'store'])->name('inventario.store');
        Route::put('/inventario/{equipo}', [EquipoController::class, 'update'])->name('inventario.update');
        Route::delete('/inventario/{equipo}', [EquipoController::class, 'destroy'])->name('inventario.destroy');

        // CATEGORÍAS - Solo Admin puede crear, editar, eliminar
        Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
        Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
        Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
        Route::post('/categorias/{categoria}/cambiar-estado', [CategoriaController::class, 'cambiarEstado'])->name('categorias.cambiar-estado');

        // USUARIOS - Solo Admin puede gestionar usuarios
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

        // MANTENIMIENTO - Solo Admin puede crear, editar y eliminar
        Route::post('/mantenimiento', [MantenimientoController::class, 'store'])->name('mantenimiento.store');
        Route::put('/mantenimiento/{mantenimiento}', [MantenimientoController::class, 'update'])->name('mantenimiento.update');
        Route::delete('/mantenimiento/{mantenimiento}', [MantenimientoController::class, 'destroy'])->name('mantenimiento.destroy');

        // CONFIGURACIÓN - Solo Admin
        Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    });

    // ========== RUTAS DE SOLO LECTURA (Todos los usuarios) ==========
    
    // INVENTARIO - Ver listado y detalles
    Route::get('/inventario', [EquipoController::class, 'index'])->name('inventario.index');
    Route::get('/inventario/{equipo}', [EquipoController::class, 'show'])->name('inventario.show');

    // CATEGORÍAS - Ver listado y detalles
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/categorias/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');

    // USUARIOS - Ver detalles (solo para referencia)
    Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');

    // MANTENIMIENTO - Ver listado y detalles
    Route::get('/mantenimiento', [MantenimientoController::class, 'index'])->name('mantenimiento.index');
    Route::get('/mantenimiento/{mantenimiento}', [MantenimientoController::class, 'show'])->name('mantenimiento.show');
});