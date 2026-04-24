@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-collection text-info me-2"></i>
                Reporte: Equipos por Categoría
            </h1>
            <p class="text-muted">Distribución y análisis de equipos agrupados por categoría</p>
        </div>
        <div>
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('reportes.equipos-por-categoria', ['formato' => 'pdf'] + request()->all()) }}" 
               class="btn btn-danger" target="_blank">
                <i class="bi bi-file-pdf me-1"></i> Exportar PDF
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.equipos-por-categoria') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Filtrar por Categoría</label>
                    <select name="categoria_id" class="form-select">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }} ({{ $cat->equipos_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
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
                    <a href="{{ route('reportes.equipos-por-categoria') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tarjetas de resumen por categoría -->
    <div class="row g-4 mb-4">
        @php
            $colores = ['primary', 'success', 'warning', 'info', 'danger', 'purple', 'dark', 'secondary'];
        @endphp

        @foreach($detallesCategorias->take(4) as $index => $detalle)
            @php
                $color = $colores[$index % count($colores)];
            @endphp
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-{{ $color }} bg-opacity-10 p-3 me-3">
                                <i class="bi bi-folder text-{{ $color }} fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-1 small">{{ $detalle['nombre'] }}</h6>
                                <h3 class="mb-0">{{ $detalle['total'] }}</h3>
                            </div>
                        </div>
                        <div class="small text-muted">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Disponibles:</span>
                                <strong class="text-success">{{ $detalle['disponibles'] }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>En uso:</span>
                                <strong class="text-info">{{ $detalle['en_uso'] }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Mantenimiento:</span>
                                <strong class="text-warning">{{ $detalle['mantenimiento'] }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Gráficos -->
    <div class="row mb-4">
        <!-- Gráfico de barras horizontales -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart-line me-2"></i>
                        Cantidad de Equipos por Categoría
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="chartBarras" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico circular -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-pie-chart me-2"></i>
                        Distribución Porcentual
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="chartPolar" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla detallada por categoría -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Análisis Detallado por Categoría
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Categoría</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Disponibles</th>
                            <th class="text-center">En Uso</th>
                            <th class="text-center">Mantenimiento</th>
                            <th class="text-center">Dados de Baja</th>
                            <th class="text-center">% del Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalGeneral = $detallesCategorias->sum('total');
                        @endphp
                        @forelse($detallesCategorias as $detalle)
                            <tr>
                                <td>
                                    <strong>{{ $detalle['nombre'] }}</strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $detalle['total'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $detalle['disponibles'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $detalle['en_uso'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">{{ $detalle['mantenimiento'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">{{ $detalle['baja'] }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $porcentaje = $totalGeneral > 0 ? ($detalle['total'] / $totalGeneral * 100) : 0;
                                    @endphp
                                    <strong>{{ number_format($porcentaje, 1) }}%</strong>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No hay categorías con equipos
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">{{ $totalGeneral }}</th>
                            <th class="text-center">{{ $detallesCategorias->sum('disponibles') }}</th>
                            <th class="text-center">{{ $detallesCategorias->sum('en_uso') }}</th>
                            <th class="text-center">{{ $detallesCategorias->sum('mantenimiento') }}</th>
                            <th class="text-center">{{ $detallesCategorias->sum('baja') }}</th>
                            <th class="text-center">100%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Listado de equipos -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Listado de Equipos
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
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos del gráfico
    const labels = {!! json_encode($chartData['labels']) !!};
    const data = {!! json_encode($chartData['data']) !!};
    
    // Generar colores dinámicos
    const generateColors = (count) => {
        const baseColors = [
            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', 
            '#8B5CF6', '#EC4899', '#14B8A6', '#F97316',
            '#6366F1', '#84CC16', '#06B6D4', '#A855F7'
        ];
        return Array(count).fill(0).map((_, i) => baseColors[i % baseColors.length]);
    };
    
    const backgroundColors = generateColors(labels.length);
    
    // GRÁFICO DE BARRAS HORIZONTALES
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
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed.x / total) * 100).toFixed(1);
                            return `Equipos: ${context.parsed.x} (${percentage}%)`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // GRÁFICO POLAR (más visual que el pie chart)
    const ctxPolar = document.getElementById('chartPolar');
    new Chart(ctxPolar, {
        type: 'polarArea',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColors.map(color => color + '90'),
                borderColor: backgroundColors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 12,
                        font: {
                            size: 11
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed.r || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            scales: {
                r: {
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

.bg-purple {
    background-color: #8B5CF6;
}

.text-purple {
    color: #8B5CF6;
}
</style>
@endsection