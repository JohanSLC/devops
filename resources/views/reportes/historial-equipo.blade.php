@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-clock-history text-purple me-2"></i>
                Reporte: Historial de Equipo
            </h1>
            <p class="text-muted">Línea de tiempo completa de movimientos y mantenimientos</p>
        </div>
        <div>
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            @if(isset($equipo))
                <a href="{{ route('reportes.historial-equipo', ['equipo' => $equipo->id, 'formato' => 'pdf']) }}" 
                   class="btn btn-danger" target="_blank">
                    <i class="bi bi-file-pdf me-1"></i> Exportar PDF
                </a>
            @endif
        </div>
    </div>

    @if(!isset($equipo))
        <!-- Selección de Equipo -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <i class="bi bi-search display-1 text-purple"></i>
                        </div>
                        <h4 class="mb-3">Selecciona un Equipo</h4>
                        <p class="text-muted mb-4">Elige el equipo del cual deseas ver el historial completo</p>
                        
                        <form method="GET" action="{{ route('reportes.historial-equipo') }}" class="row g-3">
                            <div class="col-md-10 mx-auto">
                                <select name="equipo" class="form-select form-select-lg" required onchange="this.form.submit()">
                                    <option value="">-- Seleccionar Equipo --</option>
                                    @foreach($equipos as $eq)
                                        <option value="{{ $eq->id }}">
                                            {{ $eq->codigo }} - {{ $eq->nombre }} ({{ $eq->categoria->nombre }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Equipos destacados -->
                <div class="row mt-4 g-3">
                    @foreach($equipos->take(6) as $eq)
                        <div class="col-md-4">
                            <a href="{{ route('reportes.historial-equipo', $eq->id) }}" 
                               class="card border-0 shadow-sm text-decoration-none hover-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-purple bg-opacity-10 p-3 me-3">
                                            <i class="bi bi-laptop text-purple fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark">{{ $eq->nombre }}</h6>
                                            <small class="text-muted">{{ $eq->codigo }}</small>
                                        </div>
                                        <i class="bi bi-chevron-right text-muted"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <!-- Información del Equipo -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        @if($equipo->foto)
                            <img src="{{ asset('storage/' . $equipo->foto) }}" class="img-fluid rounded" 
                                 style="max-height: 100px;">
                        @else
                            <div class="rounded-circle bg-purple bg-opacity-10 d-inline-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px;">
                                <i class="bi bi-laptop text-purple" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <h4 class="mb-2">{{ $equipo->nombre }}</h4>
                        <div class="d-flex gap-3 flex-wrap">
                            <span class="badge bg-secondary">{{ $equipo->codigo }}</span>
                            <span class="badge bg-info">{{ $equipo->categoria->nombre }}</span>
                            @php
                                $estadoBadge = match($equipo->estado) {
                                    'Disponible' => 'success',
                                    'En Uso' => 'info',
                                    'Mantenimiento' => 'warning',
                                    'Dado de Baja' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $estadoBadge }}">{{ $equipo->estado }}</span>
                        </div>
                        <p class="text-muted mt-2 mb-0">
                            @if($equipo->marca)
                                <i class="bi bi-tag me-1"></i>{{ $equipo->marca }} 
                                @if($equipo->modelo)
                                    - {{ $equipo->modelo }}
                                @endif
                            @endif
                        </p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-end">
                            <small class="text-muted d-block">Ubicación</small>
                            <strong>{{ $equipo->ubicacion ?? 'No especificada' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-left-right text-primary fs-1 mb-2"></i>
                        <h3 class="mb-1">{{ $estadisticas['total_movimientos'] }}</h3>
                        <p class="text-muted mb-0 small">Movimientos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-wrench text-warning fs-1 mb-2"></i>
                        <h3 class="mb-1">{{ $estadisticas['total_mantenimientos'] }}</h3>
                        <p class="text-muted mb-0 small">Mantenimientos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-currency-dollar text-success fs-1 mb-2"></i>
                        <h3 class="mb-1">S/. {{ number_format($estadisticas['costo_mantenimientos'], 2) }}</h3>
                        <p class="text-muted mb-0 small">Costo Total</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-event text-info fs-1 mb-2"></i>
                        <h3 class="mb-1">
                            @if($estadisticas['ultimo_movimiento'])
                                {{ \Carbon\Carbon::parse($estadisticas['ultimo_movimiento'])->format('d/m/Y') }}
                            @else
                                Sin registros
                            @endif
                        </h3>
                        <p class="text-muted mb-0 small">Última Actividad</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline de Historial -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    Línea de Tiempo
                    <span class="badge bg-primary ms-2">{{ $historial->count() }} eventos</span>
                </h5>
            </div>
            <div class="card-body">
                @if($historial->count() > 0)
                    <div class="timeline">
                        @foreach($historial as $evento)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-{{ $evento['color'] }}">
                                    <i class="bi bi-{{ $evento['icono'] }} text-white"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="card border-start border-{{ $evento['color'] }} border-4">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <span class="badge bg-{{ $evento['color'] }} mb-2">
                                                        {{ ucfirst($evento['tipo']) }}
                                                    </span>
                                                    <h6 class="mb-1">{{ $evento['descripcion'] }}</h6>
                                                    <p class="text-muted mb-2">{{ $evento['detalle'] }}</p>
                                                </div>
                                                <div class="text-end">
                                                    <small class="text-muted d-block">
                                                        <i class="bi bi-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($evento['fecha'])->format('d/m/Y') }}
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="bi bi-person me-1"></i>
                                                        {{ $evento['usuario'] }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <p class="mb-0">No hay eventos registrados en el historial de este equipo</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<style>
.timeline {
    position: relative;
    padding-left: 40px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #e5e7eb 0%, #e5e7eb 100%);
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -28px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 0 4px #fff, 0 0 0 6px #e5e7eb;
    z-index: 1;
}

.timeline-content {
    padding-left: 20px;
}

.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.bg-purple {
    background-color: #8B5CF6;
}

.text-purple {
    color: #8B5CF6;
}

.border-purple {
    border-color: #8B5CF6 !important;
}
</style>
@endsection