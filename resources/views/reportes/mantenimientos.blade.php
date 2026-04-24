@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-wrench text-dark me-2"></i>
                Reporte: Mantenimientos
            </h1>
            <p class="text-muted">Historial de mantenimientos preventivos y correctivos</p>
        </div>
        <div>
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('reportes.mantenimientos', ['formato' => 'pdf'] + request()->all()) }}" 
               class="btn btn-danger" target="_blank">
                <i class="bi bi-file-pdf me-1"></i> Exportar PDF
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.mantenimientos') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control" 
                           value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Fin</label>
                    <input type="date" name="fecha_fin" class="form-control" 
                           value="{{ request('fecha_fin') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos</option>
                        <option value="Preventivo" {{ request('tipo') == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                        <option value="Correctivo" {{ request('tipo') == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
                        <option value="Predictivo" {{ request('tipo') == 'Predictivo' ? 'selected' : '' }}>Predictivo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="En Proceso" {{ request('estado') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="Completado" {{ request('estado') == 'Completado' ? 'selected' : '' }}>Completado</option>
                        <option value="Cancelado" {{ request('estado') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-tools text-dark fs-1 mb-2"></i>
                    <h3 class="mb-1">{{ $mantenimientos->count() }}</h3>
                    <p class="text-muted mb-0 small">Total Mantenimientos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-clock-history text-warning fs-1 mb-2"></i>
                    <h3 class="mb-1">{{ $mantenimientos->where('estado', 'Pendiente')->count() }}</h3>
                    <p class="text-muted mb-0 small">Pendientes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle text-success fs-1 mb-2"></i>
                    <h3 class="mb-1">{{ $mantenimientos->where('estado', 'Completado')->count() }}</h3>
                    <p class="text-muted mb-0 small">Completados</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-currency-dollar text-success fs-1 mb-2"></i>
                    <h3 class="mb-1">S/. {{ number_format($mantenimientos->sum('costo'), 2) }}</h3>
                    <p class="text-muted mb-0 small">Costo Total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Mantenimientos -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Historial de Mantenimientos
                <span class="badge bg-dark ms-2">{{ $mantenimientos->count() }} registros</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 15%;">Equipo</th>
                            <th style="width: 10%;">Tipo</th>
                            <th style="width: 25%;">Descripción</th>
                            <th style="width: 10%;">Estado</th>
                            <th style="width: 10%;">Fecha Prog.</th>
                            <th style="width: 10%;">Fecha Real.</th>
                            <th style="width: 10%;">Técnico</th>
                            <th style="width: 10%;" class="text-end">Costo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mantenimientos as $mantenimiento)
                            <tr>
                                <td>
                                    <strong>{{ $mantenimiento->equipo->nombre }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        <code>{{ $mantenimiento->equipo->codigo }}</code>
                                    </small>
                                </td>
                                <td>
                                    @php
                                        $tipoBadge = match($mantenimiento->tipo) {
                                            'Preventivo' => 'info',
                                            'Correctivo' => 'warning',
                                            'Predictivo' => 'primary',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $tipoBadge }}">
                                        {{ $mantenimiento->tipo }}
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        {{ strlen($mantenimiento->descripcion) > 60 ? substr($mantenimiento->descripcion, 0, 60) . '...' : $mantenimiento->descripcion }}
                                    </small>
                                </td>
                                <td>
                                    @php
                                        $estadoBadge = match($mantenimiento->estado) {
                                            'Pendiente' => 'warning',
                                            'En Proceso' => 'info',
                                            'Completado' => 'success',
                                            'Cancelado' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $estadoBadge }}">
                                        {{ $mantenimiento->estado }}
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-calendar text-muted me-1"></i>
                                    {{ $mantenimiento->fecha_programada ? \Carbon\Carbon::parse($mantenimiento->fecha_programada)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    @if($mantenimiento->fecha_realizada)
                                        <i class="bi bi-calendar-check text-success me-1"></i>
                                        {{ \Carbon\Carbon::parse($mantenimiento->fecha_realizada)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($mantenimiento->tecnico)
                                        <i class="bi bi-person text-muted me-1"></i>
                                        {{ $mantenimiento->tecnico }}
                                    @else
                                        <span class="text-muted">No asignado</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($mantenimiento->costo)
                                        <strong class="text-success">S/. {{ number_format($mantenimiento->costo, 2) }}</strong>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    <p class="mb-0">No hay mantenimientos registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($mantenimientos->count() > 0)
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="7" class="text-end">COSTO TOTAL:</th>
                                <th class="text-end">
                                    <strong class="text-success">
                                        S/. {{ number_format($mantenimientos->sum('costo'), 2) }}
                                    </strong>
                                </th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Resumen por Tipo y Estado -->
    @if($mantenimientos->count() > 0)
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0">
                            <i class="bi bi-pie-chart me-2"></i>
                            Por Tipo de Mantenimiento
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-0">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="badge bg-info">Preventivo</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ $mantenimientos->where('tipo', 'Preventivo')->count() }}</strong> mantenimientos
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">S/. {{ number_format($mantenimientos->where('tipo', 'Preventivo')->sum('costo'), 2) }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge bg-warning">Correctivo</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ $mantenimientos->where('tipo', 'Correctivo')->count() }}</strong> mantenimientos
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">S/. {{ number_format($mantenimientos->where('tipo', 'Correctivo')->sum('costo'), 2) }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">Predictivo</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ $mantenimientos->where('tipo', 'Predictivo')->count() }}</strong> mantenimientos
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">S/. {{ number_format($mantenimientos->where('tipo', 'Predictivo')->sum('costo'), 2) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0">
                            <i class="bi bi-bar-chart me-2"></i>
                            Por Estado
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-0">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="badge bg-warning">Pendiente</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ $mantenimientos->where('estado', 'Pendiente')->count() }}</strong> mantenimientos
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge bg-info">En Proceso</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ $mantenimientos->where('estado', 'En Proceso')->count() }}</strong> mantenimientos
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge bg-success">Completado</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ $mantenimientos->where('estado', 'Completado')->count() }}</strong> mantenimientos
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge bg-danger">Cancelado</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ $mantenimientos->where('estado', 'Cancelado')->count() }}</strong> mantenimientos
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}
</style>
@endsection