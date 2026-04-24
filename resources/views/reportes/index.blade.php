@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">📊 Centro de Reportes</h1>
            <p class="text-muted">Genera y consulta reportes del sistema de inventario</p>
        </div>
        
        <!-- Badge del rol del usuario -->
        <div>
            @if(auth()->user()->isAdmin())
                <span class="badge bg-danger fs-6">
                    <i class="bi bi-shield-fill-check me-1"></i> Administrador
                </span>
            @else
                <span class="badge bg-primary fs-6">
                    <i class="bi bi-person-fill me-1"></i> Usuario
                </span>
            @endif
        </div>
    </div>

    <!-- Grid de Reportes -->
    <div class="row g-4">
        
        <!-- REPORTE 1: Inventario General -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-box-seam text-primary fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Inventario General</h5>
                    </div>
                    <p class="card-text text-muted">
                        Listado completo de todos los equipos con filtros por categoría y estado.
                    </p>
                    <a href="{{ route('reportes.inventario-general') }}" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-eye me-1"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- REPORTE 2: Equipos por Estado -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="bi bi-diagram-3 text-success fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Equipos por Estado</h5>
                    </div>
                    <p class="card-text text-muted">
                        Distribución de equipos por estado: Disponible, En Uso, Mantenimiento, etc.
                    </p>
                    <a href="{{ route('reportes.equipos-por-estado') }}" class="btn btn-success btn-sm w-100">
                        <i class="bi bi-eye me-1"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- REPORTE 3: Equipos por Categoría -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                            <i class="bi bi-collection text-info fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Equipos por Categoría</h5>
                    </div>
                    <p class="card-text text-muted">
                        Análisis de equipos agrupados por categoría con gráficos estadísticos.
                    </p>
                    <a href="{{ route('reportes.equipos-por-categoria') }}" class="btn btn-info btn-sm w-100">
                        <i class="bi bi-eye me-1"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- REPORTE 4: Valor del Inventario -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="bi bi-currency-dollar text-warning fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Valor del Inventario</h5>
                    </div>
                    <p class="card-text text-muted">
                        Valorización total del inventario con estadísticas de costos.
                    </p>
                    <a href="{{ route('reportes.valor-inventario') }}" class="btn btn-warning btn-sm w-100">
                        <i class="bi bi-eye me-1"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>


        <style>
    /* Definir el color morado personalizado */
    .bg-custom-purple {
        background-color: #f6891dff; /* Puedes cambiar el valor a otro tono de morado */
    }
    .btn-custom-purple {
        background-color: #f6891dff;
        border-color: #eae5f3ff;
    }
    .text-custom-purple {
        color: #f1f0f2ff;
    }
        </style>

        <!-- REPORTE 5: Historial de Equipo -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-custom-purple bg-opacity-10 p-3 me-3">
                            <i class="bi bi-clock-history text-custom-purple fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Historial de Equipo</h5>
                    </div>
                    <p class="card-text text-muted">
                        Línea de tiempo completa de movimientos y mantenimientos por equipo.
                    </p>
                    <a href="{{ route('reportes.historial-equipo') }}" class="btn btn-custom-purple btn-sm w-100">
                        <<i class="bi bi-eye me-1"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- REPORTE 6: Usuarios y Actividad -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="bi bi-people text-danger fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Usuarios y Actividad</h5>
                    </div>
                    <p class="card-text text-muted">
                        Actividad de usuarios: movimientos y mantenimientos realizados.
                    </p>
                    <a href="{{ route('reportes.usuarios-actividad') }}" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-eye me-1"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- REPORTE 7: Movimientos -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-secondary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-arrow-left-right text-secondary fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Movimientos</h5>
                    </div>
                    <p class="card-text text-muted">
                        Registro de entradas, salidas y transferencias de equipos.
                    </p>
                    <a href="{{ route('reportes.movimientos') }}" class="btn btn-secondary btn-sm w-100">
                        <i class="bi bi-eye me-1"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- REPORTE 8: Mantenimientos -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-dark bg-opacity-10 p-3 me-3">
                            <i class="bi bi-wrench text-dark fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Mantenimientos</h5>
                    </div>
                    <p class="card-text text-muted">
                        Historial de mantenimientos preventivos y correctivos.
                    </p>
                    <a href="{{ route('reportes.mantenimientos') }}" class="btn btn-dark btn-sm w-100">
                        <i class="bi bi-eye me-1"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Estadísticas rápidas -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-bar-chart-line me-2"></i>
                        Resumen General
                    </h5>
                    <div class="row text-center">
                        <div lass="col-md-3">
                            <div class="p-3">
                                <h2 class="text-primary mb-1">{{ \App\Models\Equipo::count() }}</h2>
                                <p class="text-muted mb-0">Total Equipos</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <h2 class="text-success mb-1">{{ \App\Models\Equipo::where('estado', 'Disponible')->count() }}</h2>
                                <p class="text-muted mb-0">Disponibles</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <h2 class="text-warning mb-1">{{ \App\Models\Mantenimiento::where('estado', 'Pendiente')->count() }}</h2>
                                <p class="text-muted mb-0">Mant. Pendientes</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <h2 class="text-info mb-1">S/. {{ number_format(\App\Models\Equipo::sum('precio_adquisicion'), 2) }}</h2>
                                <p class="text-muted mb-0">Valor Total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.bg-purple {
    background-color: #6f42c1;
}

.text-purple {
    color: #6f42c1;
}

.btn-purple {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: white;
}

.btn-purple:hover {
    background-color: #5a32a3;
    border-color: #5a32a3;
    color: white;
}
</style>
@endsection