@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-currency-dollar text-warning me-2"></i>
                Reporte: Valor del Inventario
            </h1>
            <p class="text-muted">Valorización total del inventario y análisis financiero</p>
        </div>
        <div>
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('reportes.valor-inventario', ['formato' => 'pdf'] + request()->all()) }}" 
               class="btn btn-danger" target="_blank">
                <i class="bi bi-file-pdf me-1"></i> Exportar PDF
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.valor-inventario') }}" class="row g-3">
                <div class="col-md-3">
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
                <div class="col-md-2">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="Disponible" {{ request('estado') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="En Uso" {{ request('estado') == 'En Uso' ? 'selected' : '' }}>En Uso</option>
                        <option value="Mantenimiento" {{ request('estado') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        <option value="Dado de Baja" {{ request('estado') == 'Dado de Baja' ? 'selected' : '' }}>Dado de Baja</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('reportes.valor-inventario') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas Financieras -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-wallet2 text-primary fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1 small">Valor Total</h6>
                            <h3 class="mb-0 text-primary">S/. {{ number_format($estadisticas['valor_total'], 2) }}</h3>
                            <small class="text-muted">{{ $estadisticas['total_equipos'] }} equipos</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="bi bi-graph-up-arrow text-success fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1 small">Valor Promedio</h6>
                            <h3 class="mb-0 text-success">S/. {{ number_format($estadisticas['valor_promedio'], 2) }}</h3>
                            <small class="text-muted">Por equipo</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="bi bi-arrow-up-circle text-danger fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1 small">Valor Máximo</h6>
                            <h3 class="mb-0 text-danger">S/. {{ number_format($estadisticas['valor_maximo'], 2) }}</h3>
                            <small class="text-muted">Equipo más caro</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                            <i class="bi bi-arrow-down-circle text-info fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1 small">Valor Mínimo</h6>
                            <h3 class="mb-0 text-info">S/. {{ number_format($estadisticas['valor_minimo'], 2) }}</h3>
                            <small class="text-muted">Equipo más económico</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos de Valorización -->
    <div class="row mb-4">
        <!-- Valor por Categoría -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-pie-chart-fill me-2"></i>
                        Valor por Categoría
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="chartCategoria" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Valor por Estado -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart-fill me-2"></i>
                        Valor por Estado
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="chartEstado" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Valor por Categoría -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Valorización por Categoría
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Categoría</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Valor Total</th>
                            <th class="text-end">Valor Promedio</th>
                            <th class="text-center">% del Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $valorTotalGeneral = $valorPorCategoria->sum('valor');
                        @endphp
                        @forelse($valorPorCategoria as $item)
                            <tr>
                                <td>
                                    <i class="bi bi-folder text-warning me-2"></i>
                                    <strong>{{ $item['nombre'] }}</strong>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $item['cantidad'] }}</span>
                                </td>
                                <td class="text-end">
                                    <strong class="text-success">S/. {{ number_format($item['valor'], 2) }}</strong>
                                </td>
                                <td class="text-end">
                                    <span class="text-muted">
                                        S/. {{ number_format($item['cantidad'] > 0 ? $item['valor'] / $item['cantidad'] : 0, 2) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $porcentaje = $valorTotalGeneral > 0 ? ($item['valor'] / $valorTotalGeneral * 100) : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-warning" role="progressbar" 
                                             style="width: {{ $porcentaje }}%">
                                            {{ number_format($porcentaje, 1) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No hay datos de valorización
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-center">{{ $valorPorCategoria->sum('cantidad') }}</th>
                            <th class="text-end">S/. {{ number_format($valorTotalGeneral, 2) }}</th>
                            <th class="text-end">-</th>
                            <th class="text-center">100%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabla de Valor por Estado -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Valorización por Estado
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Estado</th>
                            <th class="text-end">Valor Total</th>
                            <th class="text-center">% del Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $valorTotalEstado = $valorPorEstado->sum();
                        @endphp
                        @forelse($valorPorEstado as $estado => $valor)
                            <tr>
                                <td>
                                    @php
                                        $badgeClass = match($estado) {
                                            'Disponible' => 'success',
                                            'En Uso' => 'info',
                                            'Mantenimiento' => 'warning',
                                            'Dado de Baja' => 'danger',
                                            default => 'secondary'
                                        };
                                        $icon = match($estado) {
                                            'Disponible' => 'check-circle',
                                            'En Uso' => 'arrow-right-circle',
                                            'Mantenimiento' => 'wrench',
                                            'Dado de Baja' => 'x-circle',
                                            default => 'circle'
                                        };
                                    @endphp
                                    <i class="bi bi-{{ $icon }} text-{{ $badgeClass }} me-2"></i>
                                    <strong>{{ $estado }}</strong>
                                </td>
                                <td class="text-end">
                                    <strong class="text-{{ $badgeClass }}">S/. {{ number_format($valor, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    @php
                                        $porcentaje = $valorTotalEstado > 0 ? ($valor / $valorTotalEstado * 100) : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-{{ $badgeClass }}" role="progressbar" 
                                             style="width: {{ $porcentaje }}%">
                                            {{ number_format($porcentaje, 1) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    No hay datos de valorización por estado
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-end">S/. {{ number_format($valorTotalEstado, 2) }}</th>
                            <th class="text-center">100%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Listado Detallado de Equipos -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Detalle de Equipos Valorizados
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
                            <th class="text-end">Precio Adquisición</th>
                            <th>Fecha Adquisición</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipos->sortByDesc('precio_adquisicion') as $equipo)
                            <tr>
                                <td>
                                    <code>{{ $equipo->codigo }}</code>
                                </td>
                                <td>
                                    <strong>{{ $equipo->nombre }}</strong>
                                    @if($equipo->marca)
                                        <br><small class="text-muted">{{ $equipo->marca }}</small>
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
                                <td class="text-end">
                                    <strong class="text-success">S/. {{ number_format($equipo->precio_adquisicion, 2) }}</strong>
                                </td>
                                <td>
                                    <i class="bi bi-calendar text-muted me-1"></i>
                                    {{ $equipo->fecha_adquisicion ? $equipo->fecha_adquisicion->format('d/m/Y') : 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No hay equipos con precio de adquisición registrado
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
    // Datos para gráficos
    const categoriaLabels = {!! json_encode($chartData['categorias']['labels']) !!};
    const categoriaData = {!! json_encode($chartData['categorias']['data']) !!};
    const estadoLabels = {!! json_encode($chartData['estados']['labels']) !!};
    const estadoData = {!! json_encode($chartData['estados']['data']) !!};

    // Colores para categorías
    const categoriaColors = [
        '#3B82F6', '#10B981', '#F59E0B', '#EF4444', 
        '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'
    ];

    // Colores para estados
    const estadoColors = {
        'Disponible': '#10B981',
        'En Uso': '#3B82F6',
        'Mantenimiento': '#F59E0B',
        'Dado de Baja': '#EF4444'
    };

    // GRÁFICO DE DONA - Valor por Categoría
    const ctxCategoria = document.getElementById('chartCategoria');
    new Chart(ctxCategoria, {
        type: 'doughnut',
        data: {
            labels: categoriaLabels,
            datasets: [{
                data: categoriaData,
                backgroundColor: categoriaColors.slice(0, categoriaLabels.length),
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
                        font: { size: 11 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: S/. ${value.toLocaleString('es-PE', {minimumFractionDigits: 2})} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // GRÁFICO DE BARRAS - Valor por Estado
    const ctxEstado = document.getElementById('chartEstado');
    const estadoBackgroundColors = estadoLabels.map(label => estadoColors[label] || '#6B7280');
    
    new Chart(ctxEstado, {
        type: 'bar',
        data: {
            labels: estadoLabels,
            datasets: [{
                label: 'Valor Total (S/.)',
                data: estadoData,
                backgroundColor: estadoBackgroundColors,
                borderWidth: 0,
                borderRadius: 8
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
                            return `Valor: S/. ${context.parsed.y.toLocaleString('es-PE', {minimumFractionDigits: 2})}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'S/. ' + value.toLocaleString('es-PE');
                        }
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

.progress {
    background-color: #e9ecef;
}

.progress-bar {
    font-size: 0.75rem;
    font-weight: 600;
}
</style>
@endsection