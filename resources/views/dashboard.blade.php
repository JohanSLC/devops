@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>📊 Dashboard</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Inicio</li>
        </ol>
    </nav>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                📦
            </div>
            <h6 class="text-muted mb-1" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Equipos</h6>
            <h2 class="mb-1" style="font-size: 32px; font-weight: 700; color: #1f2937;">{{ $totalEquipos ?? 0 }}</h2>
            <small class="text-success">
                <i class="bi bi-arrow-up"></i> 12% vs mes anterior
            </small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                ✅
            </div>
            <h6 class="text-muted mb-1" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Disponibles</h6>
            <h2 class="mb-1" style="font-size: 32px; font-weight: 700; color: #1f2937;">{{ $equiposDisponibles ?? 0 }}</h2>
            <small class="text-muted">
                {{ ($totalEquipos ?? 0) > 0 ? round((($equiposDisponibles ?? 0) / ($totalEquipos ?? 1)) * 100) : 0 }}% del total
            </small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                🔧
            </div>
            <h6 class="text-muted mb-1" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">En Mantenimiento</h6>
            <h2 class="mb-1" style="font-size: 32px; font-weight: 700; color: #1f2937;">{{ $equiposMantenimiento ?? 0 }}</h2>
            <small class="text-warning">
                <i class="bi bi-exclamation-triangle"></i> {{ $mantenimientosPendientes ?? 0 }} pendientes
            </small>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                ⚠️
            </div>
            <h6 class="text-muted mb-1" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Alertas</h6>
            <h2 class="mb-1" style="font-size: 32px; font-weight: 700; color: #1f2937;">{{ $alertasTotal ?? 0 }}</h2>
            <small class="{{ ($alertasTotal ?? 0) > 0 ? 'text-danger' : 'text-success' }}">
                {{ ($alertasTotal ?? 0) > 0 ? '⚠️ Requiere atención' : '✓ Todo OK' }}
            </small>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row g-3 mb-4">
    <!-- Recent Movements -->
    <div class="col-lg-8">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0" style="font-weight: 600; color: #1f2937;">
                    <i class="bi bi-clock-history me-2"></i>Movimientos Recientes
                </h5>
                <a href="{{ route('inventario.index') }}" class="btn btn-sm btn-outline-primary">
                    Ver todos <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            @if(isset($movimientosRecientes) && $movimientosRecientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280;">Equipo</th>
                                <th style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280;">Tipo</th>
                                <th style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280;">Destino</th>
                                <th style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movimientosRecientes as $movimiento)
                            <tr>
                                <td>
                                    <strong style="color: #1f2937;">{{ $movimiento->equipo->nombre ?? 'N/A' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $movimiento->equipo->codigo ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ ($movimiento->tipo ?? '') == 'Entrada' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $movimiento->tipo ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ $movimiento->destino ?? 'N/A' }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ isset($movimiento->fecha) ? \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y') : 'N/A' }}
                                    </small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 48px; color: #d1d5db;"></i>
                    <p class="text-muted mt-3">No hay movimientos registrados</p>
                    <a href="{{ route('inventario.index') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Registrar movimiento
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Alerts Panel -->
    <div class="col-lg-4">
        <div class="table-container">
            <h5 class="mb-3" style="font-weight: 600; color: #1f2937;">
                <i class="bi bi-bell me-2"></i>Alertas y Notificaciones
            </h5>

            @php
                $mantenimientosPendientesValue = $mantenimientosPendientes ?? 0;
                $equiposMantenimientoValue = $equiposMantenimiento ?? 0;
            @endphp

            @if($mantenimientosPendientesValue > 0)
                <div class="alert alert-warning d-flex align-items-start" role="alert" style="border-left: 4px solid #f59e0b;">
                    <i class="bi bi-exclamation-triangle-fill me-2 mt-1" style="font-size: 20px;"></i>
                    <div>
                        <strong>Mantenimientos Pendientes</strong>
                        <p class="mb-0 small">Hay {{ $mantenimientosPendientesValue }} equipos con mantenimiento programado</p>
                    </div>
                </div>
            @endif

            @if($equiposMantenimientoValue > 0)
                <div class="alert alert-info d-flex align-items-start" role="alert" style="border-left: 4px solid #3b82f6;">
                    <i class="bi bi-tools me-2 mt-1" style="font-size: 20px;"></i>
                    <div>
                        <strong>Equipos en Reparación</strong>
                        <p class="mb-0 small">{{ $equiposMantenimientoValue }} equipos actualmente en mantenimiento</p>
                    </div>
                </div>
            @endif

            @if($mantenimientosPendientesValue == 0 && $equiposMantenimientoValue == 0)
                <div class="alert alert-success d-flex align-items-start" role="alert" style="border-left: 4px solid #10b981;">
                    <i class="bi bi-check-circle-fill me-2 mt-1" style="font-size: 20px;"></i>
                    <div>
                        <strong>Todo en Orden</strong>
                        <p class="mb-0 small">No hay alertas pendientes en este momento</p>
                    </div>
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('mantenimiento.index') }}" class="btn btn-outline-primary w-100 btn-sm">
                    <i class="bi bi-wrench me-1"></i> Ver Mantenimientos
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Categories Overview -->
<div class="row">
    <div class="col-12">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0" style="font-weight: 600; color: #1f2937;">
                    <i class="bi bi-grid-3x3-gap me-2"></i>Equipos por Categoría
                </h5>
                <a href="{{ route('categorias.index') }}" class="btn btn-sm btn-outline-primary">
                    Gestionar categorías <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            @if(isset($equiposPorCategoria) && $equiposPorCategoria->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280;">Categoría</th>
                                <th style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280;">Código</th>
                                <th style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280;">Total Equipos</th>
                                <th style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280;">Disponibles</th>
                                <th style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280;">En Uso</th>
                                <th style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: #6b7280;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equiposPorCategoria as $categoria)
                            <tr>
                                <td><strong style="color: #1f2937;">{{ $categoria->nombre ?? 'N/A' }}</strong></td>
                                <td><code style="background: #f3f4f6; padding: 4px 8px; border-radius: 4px; font-size: 12px;">{{ $categoria->codigo ?? 'N/A' }}</code></td>
                                <td><strong>{{ $categoria->equipos_count ?? 0 }}</strong></td>
                                <td>
                                    <span class="badge bg-success">{{ $categoria->disponibles ?? 0 }}</span>
                                </td>
                                <td>{{ ($categoria->equipos_count ?? 0) - ($categoria->disponibles ?? 0) }}</td>
                                <td>
                                    @if(($categoria->disponibles ?? 0) > 0)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Activo
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>Sin stock
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-folder-x" style="font-size: 48px; color: #d1d5db;"></i>
                    <p class="text-muted mt-3">No hay categorías registradas</p>
                    <a href="{{ route('categorias.index') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Crear categoría
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Estilos adicionales específicos del dashboard */
.stat-card {
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.table-container {
    border: 1px solid #e5e7eb;
}

.table > :not(caption) > * > * {
    padding: 12px;
}

.alert {
    border: none;
    border-radius: 8px;
}

code {
    color: #667eea;
}

.badge {
    font-weight: 600;
    padding: 6px 12px;
}
</style>
@endsection