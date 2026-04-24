@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-diagram-3 text-success me-2"></i>
                Reporte: Equipos por Estado
            </h1>
            <p class="text-muted">Distribución de equipos según su estado actual</p>
        </div>
        <div>
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('reportes.equipos-por-estado', ['formato' => 'pdf'] + request()->all()) }}" 
               class="btn btn-danger" target="_blank">
                <i class="bi bi-file-pdf me-1"></i> Exportar PDF
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.equipos-por-estado') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Filtrar por Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="Disponible" {{ request('estado') == 'Disponible' ? 'selected' : '' }}>
                            Disponible
                        </option>
                        <option value="En Uso" {{ request('estado') == 'En Uso' ? 'selected' : '' }}>
                            En Uso
                        </option>
                        <option value="Mantenimiento" {{ request('estado') == 'Mantenimiento' ? 'selected' : '' }}>
                            Mantenimiento
                        </option>
                        <option value="Dado de Baja" {{ request('estado') == 'Dado de Baja' ? 'selected' : '' }}>
                            Dado de Baja
                        </option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('reportes.equipos-por-estado') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="row g-4 mb-4">
        @php
            $colores = [
                'Disponible' => ['bg' => 'success', 'icon' => 'check-circle'],
                'En Uso' => ['bg' => 'info', 'icon' => 'arrow-right-circle'],
                'Mantenimiento' => ['bg' => 'warning', 'icon' => 'wrench'],
                'Dado de Baja' => ['bg' => 'danger', 'icon' => 'x-circle']
            ];
        @endphp

        @foreach($estadisticas as $stat)
            @php
                $config = $colores[$stat->estado] ?? ['bg' => 'secondary', 'icon' => 'circle'];
                $porcentaje = $equipos->count() > 0 ? ($stat->total / $equipos->count() * 100) : 0;
            @endphp
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-{{ $config['bg'] }} bg-opacity-10 p-3 me-3">
                                <i class="bi bi-{{ $config['icon'] }} text-{{ $config['bg'] }} fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-1">{{ $stat->estado }}</h6>
                                <h3 class="mb-0">{{ $stat->total }}</h3>
                                <small class="text-muted">{{ number_format($porcentaje, 1) }}% del total</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Gráfico -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-pie-chart me-2"></i>
                        Distribución por Estado
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="chartEstados" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart me-2"></i>
                        Cantidad por Estado
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="chartBarras" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Equipos -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Detalle de Equipos
                <span class="badge bg-primary ms-2">{{ $equipos->count() }} equipos</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Marca/Modelo</th>
                            <th>Ubicación</th>
                            <th>Acciones</th>
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
                                    <i class="bi bi-geo-alt text-muted me-1"></i>
                                    {{ $equipo->ubicacion ?? 'Sin ubicación' }}
                                </td>
                                <td>
                                    <a href="{{ route('inventario.show', $equipo) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No hay equipos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h4 class="text-primary mb-1">{{ $equipos->count() }}</h4>
                            <p class="text-muted mb-0 small">Total de Equipos</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-success mb-1">
                                {{ $estadisticas->where('estado', 'Disponible')->first()->total ?? 0 }}
                            </h4>
                            <p class="text-muted mb-0 small">Disponibles</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-info mb-1">
                                {{ $estadisticas->where('estado', 'En Uso')->first()->total ?? 0 }}
                            </h4>
                            <p class="text-muted mb-0 small">En Uso</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-warning mb-1">
                                {{ $estadisticas->where('estado', 'Mantenimiento')->first()->total ?? 0 }}
                            </h4>
                            <p class="text-muted mb-0 small">En Mantenimiento</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos del gráfico
    const labels = {!! json_encode($chartData['labels']) !!};
    const data = {!! json_encode($chartData['data']) !!};
    const colors = {
        'Disponible': '#10B981',
        'En Uso': '#3B82F6',
        'Mantenimiento': '#F59E0B',
        'Dado de Baja': '#EF4444'
    };
    
    const backgroundColors = labels.map(label => colors[label] || '#6B7280');
    
    // GRÁFICO DE DONA (recomendado para estados)
    const ctxDona = document.getElementById('chartEstados');
    new Chart(ctxDona, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // GRÁFICO DE BARRAS
    const ctxBarras = document.getElementById('chartBarras');
    new Chart(ctxBarras, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad de Equipos',
                data: data,
                backgroundColor: backgroundColors,
                borderWidth: 0,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Equipos: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush

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