@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-box-seam text-primary me-2"></i>
                Reporte: Inventario General
            </h1>
            <p class="text-muted">Listado completo de todos los equipos del sistema</p>
        </div>
        <div>
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('reportes.inventario-general', ['formato' => 'pdf'] + request()->all()) }}" 
               class="btn btn-danger" target="_blank">
                <i class="bi bi-file-pdf me-1"></i> Exportar PDF
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.inventario-general') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="Disponible" {{ request('estado') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="En Uso" {{ request('estado') == 'En Uso' ? 'selected' : '' }}>En Uso</option>
                        <option value="Mantenimiento" {{ request('estado') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        <option value="Dado de Baja" {{ request('estado') == 'Dado de Baja' ? 'selected' : '' }}>Dado de Baja</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('reportes.inventario-general') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumen rápido -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam text-primary fs-1 mb-2"></i>
                    <h3 class="mb-1">{{ $equipos->count() }}</h3>
                    <p class="text-muted mb-0 small">Total Equipos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle text-success fs-1 mb-2"></i>
                    <h3 class="mb-1">{{ $equipos->where('estado', 'Disponible')->count() }}</h3>
                    <p class="text-muted mb-0 small">Disponibles</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-right-circle text-info fs-1 mb-2"></i>
                    <h3 class="mb-1">{{ $equipos->where('estado', 'En Uso')->count() }}</h3>
                    <p class="text-muted mb-0 small">En Uso</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-wrench text-warning fs-1 mb-2"></i>
                    <h3 class="mb-1">{{ $equipos->where('estado', 'Mantenimiento')->count() }}</h3>
                    <p class="text-muted mb-0 small">Mantenimiento</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Inventario -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Listado Completo de Equipos
                <span class="badge bg-primary ms-2">{{ $equipos->count() }} equipos</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 10%;">Código</th>
                            <th style="width: 20%;">Nombre</th>
                            <th style="width: 12%;">Categoría</th>
                            <th style="width: 10%;">Estado</th>
                            <th style="width: 15%;">Marca/Modelo</th>
                            <th style="width: 10%;">Serie</th>
                            <th style="width: 13%;">Ubicación</th>
                            <th style="width: 10%;" class="text-end">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipos as $equipo)
                            <tr>
                                <td>
                                    <code>{{ $equipo->codigo }}</code>
                                </td>
                                <td>
                                    <strong>{{ $equipo->nombre }}</strong>
                                    @if($equipo->descripcion)
                                        <br><small class="text-muted">
                                            {{ strlen($equipo->descripcion) > 50 ? substr($equipo->descripcion, 0, 50) . '...' : $equipo->descripcion }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $equipo->categoria->nombre }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($equipo->estado) {
                                            'Disponible' => 'success',
                                            'En Uso' => 'info',
                                            'Mantenimiento' => 'warning',
                                            'Dado de Baja' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">
                                        {{ $equipo->estado }}
                                    </span>
                                </td>
                                <td>
                                    {{ $equipo->marca ?? 'N/A' }}
                                    @if($equipo->modelo)
                                        <br><small class="text-muted">{{ $equipo->modelo }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($equipo->serie)
                                        <code style="font-size: 0.85rem;">{{ $equipo->serie }}</code>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="bi bi-geo-alt text-muted me-1"></i>
                                    {{ $equipo->ubicacion ?? 'Sin ubicación' }}
                                </td>
                                <td class="text-end">
                                    @if($equipo->precio_adquisicion)
                                        <strong class="text-success">S/. {{ number_format($equipo->precio_adquisicion, 2) }}</strong>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    <p class="mb-0">No hay equipos registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($equipos->count() > 0)
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="7" class="text-end">TOTAL INVENTARIO:</th>
                                <th class="text-end">
                                    <strong class="text-primary">
                                        S/. {{ number_format($equipos->sum('precio_adquisicion'), 2) }}
                                    </strong>
                                </th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Resumen por categoría -->
    @if($equipos->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-pie-chart me-2"></i>
                            Resumen por Categoría
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Categoría</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Disponibles</th>
                                        <th class="text-center">En Uso</th>
                                        <th class="text-center">Mantenimiento</th>
                                        <th class="text-end">Valor Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($equipos->groupBy('categoria_id') as $categoriaId => $equiposCategoria)
                                        <tr>
                                            <td>
                                                <strong>{{ $equiposCategoria->first()->categoria->nombre }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $equiposCategoria->count() }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success">{{ $equiposCategoria->where('estado', 'Disponible')->count() }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $equiposCategoria->where('estado', 'En Uso')->count() }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning">{{ $equiposCategoria->where('estado', 'Mantenimiento')->count() }}</span>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-success">S/. {{ number_format($equiposCategoria->sum('precio_adquisicion'), 2) }}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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