@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-people text-danger me-2"></i>
                Reporte: Usuarios y Actividad
            </h1>
            <p class="text-muted">Análisis de actividad de usuarios en el sistema</p>
        </div>
        <div>
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('reportes.usuarios-actividad', ['formato' => 'pdf'] + request()->all()) }}" 
               class="btn btn-danger" target="_blank">
                <i class="bi bi-file-pdf me-1"></i> Exportar PDF
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.usuarios-actividad') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_inicio" class="form-control" 
                           value="{{ $fechaInicio }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_fin" class="form-control" 
                           value="{{ $fechaFin }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('reportes.usuarios-actividad') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-people text-primary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Total Usuarios</h6>
                            <h3 class="mb-0">{{ $estadisticas['total_usuarios'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="bi bi-shield-check text-danger fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Administradores</h6>
                            <h3 class="mb-0">{{ $estadisticas['administradores'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                            <i class="bi bi-arrow-left-right text-info fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Total Movimientos</h6>
                            <h3 class="mb-0">{{ $estadisticas['total_movimientos'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="bi bi-wrench text-warning fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Total Mantenimientos</h6>
                            <h3 class="mb-0">{{ $estadisticas['total_mantenimientos'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Actividad -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart me-2"></i>
                        Actividad por Usuario
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="chartActividad" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Detalle de Actividad por Usuario
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Movimientos</th>
                            <th class="text-center">Mantenimientos</th>
                            <th class="text-center">Total Actividad</th>
                            <th>Última Actividad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios->sortByDesc('total_actividad') as $usuario)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-{{ $usuario['rol'] == 'Administrador' ? 'danger' : 'primary' }} text-white d-flex align-items-center justify-content-center me-2" 
                                             style="width: 35px; height: 35px; font-size: 14px;">
                                            {{ strtoupper(substr($usuario['nombre'], 0, 1)) }}
                                        </div>
                                        <strong>{{ $usuario['nombre'] }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <i class="bi bi-envelope text-muted me-1"></i>
                                    {{ $usuario['email'] }}
                                </td>
                                <td>
                                    @if($usuario['rol'] == 'Administrador')
                                        <span class="badge bg-danger">
                                            <i class="bi bi-shield-fill-check me-1"></i>Administrador
                                        </span>
                                    @else
                                        <span class="badge bg-primary">
                                            <i class="bi bi-person-fill me-1"></i>Usuario
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($usuario['estado'] == 'Activo')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Activo
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle me-1"></i>Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $usuario['movimientos'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning">{{ $usuario['mantenimientos'] }}</span>
                                </td>
                                <td class="text-center">
                                    <strong class="text-primary">{{ $usuario['total_actividad'] }}</strong>
                                </td>
                                <td>
                                    @if($usuario['ultima_actividad'])
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($usuario['ultima_actividad'])->format('d/m/Y') }}
                                        </small>
                                    @else
                                        <small class="text-muted">Sin actividad</small>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No hay usuarios registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">TOTAL:</th>
                            <th class="text-center">{{ $usuarios->sum('movimientos') }}</th>
                            <th class="text-center">{{ $usuarios->sum('mantenimientos') }}</th>
                            <th class="text-center">{{ $usuarios->sum('total_actividad') }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Información del período -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body bg-light">
            <div class="row text-center">
                <div class="col-md-6">
                    <small class="text-muted d-block">Período del Reporte</small>
                    <strong>{{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</strong>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Usuarios Activos en el Período</small>
                    <strong>{{ $usuarios->where('total_actividad', '>', 0)->count() }} de {{ $usuarios->count() }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const usuarios = {!! json_encode($chartData['usuarios']) !!};
    const movimientos = {!! json_encode($chartData['movimientos']) !!};
    const mantenimientos = {!! json_encode($chartData['mantenimientos']) !!};

    const ctx = document.getElementById('chartActividad');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: usuarios,
            datasets: [
                {
                    label: 'Movimientos',
                    data: movimientos,
                    backgroundColor: '#0ea5e9',
                    borderWidth: 0,
                    borderRadius: 5
                },
                {
                    label: 'Mantenimientos',
                    data: mantenimientos,
                    backgroundColor: '#f59e0b',
                    borderWidth: 0,
                    borderRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        padding: 15,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        footer: function(context) {
                            let sum = 0;
                            context.forEach(item => {
                                sum += item.parsed.y;
                            });
                            return 'Total: ' + sum;
                        }
                    }
                }
            },
            scales: {
                x: {
                    stacked: false,
                    grid: {
                        display: false
                    }
                },
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
</style>
@endsection