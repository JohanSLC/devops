@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-wrench text-primary me-2"></i>
                Mantenimientos
            </h1>
            <p class="text-muted">Gestión de mantenimientos preventivos y correctivos</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <!-- Badge del rol -->
            @if(auth()->user()->isAdmin())
                <span class="badge bg-danger fs-6 me-2">
                    <i class="bi bi-shield-fill-check me-1"></i> Administrador
                </span>
                <!-- Botón crear solo para admin -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearMantenimiento">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo Mantenimiento
                </button>
            @else
                <span class="badge bg-primary fs-6">
                    <i class="bi bi-person-fill me-1"></i> Usuario
                </span>
            @endif
        </div>
    </div>

    <!-- Alerta para usuarios sin permisos -->
    @if(!auth()->user()->isAdmin())
        <div class="alert alert-info alert-dismissible fade show">
            <i class="bi bi-info-circle me-2"></i>
            <strong>Modo Solo Lectura:</strong> Solo puedes visualizar los mantenimientos. Contacta a un administrador para realizar cambios.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Mensajes -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('mantenimiento.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Descripción, técnico, equipo..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos los tipos</option>
                        <option value="Preventivo" {{ request('tipo') == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                        <option value="Correctivo" {{ request('tipo') == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
                        <option value="Predictivo" {{ request('tipo') == 'Predictivo' ? 'selected' : '' }}>Predictivo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="En Proceso" {{ request('estado') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="Completado" {{ request('estado') == 'Completado' ? 'selected' : '' }}>Completado</option>
                        <option value="Cancelado" {{ request('estado') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search me-1"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de mantenimientos -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Listado de Mantenimientos
                <span class="badge bg-primary ms-2">{{ $mantenimientos->total() }} mantenimientos</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Equipo</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha Programada</th>
                            <th>Técnico</th>
                            <th>Costo</th>
                            <th>Acciones</th>
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
                                    <span style="font-size: 13px; color: #4b5563;">
                                        {{ strlen($mantenimiento->descripcion) > 40 ? substr($mantenimiento->descripcion, 0, 40) . '...' : $mantenimiento->descripcion }}
                                    </span>
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
                                    {{ $mantenimiento->fecha_programada ? \Carbon\Carbon::parse($mantenimiento->fecha_programada)->format('d/m/Y') : 'Sin fecha' }}
                                </td>
                                <td>{{ $mantenimiento->tecnico ?? 'No asignado' }}</td>
                                <td>
                                    @if($mantenimiento->costo)
                                        <strong class="text-success">S/. {{ number_format($mantenimiento->costo, 2) }}</strong>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" 
                                                onclick="verMantenimiento({{ $mantenimiento->id }})" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        @if(auth()->user()->isAdmin())
                                            <button type="button" class="btn btn-outline-warning" 
                                                    onclick="editarMantenimiento({{ $mantenimiento->id }})" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form action="{{ route('mantenimiento.destroy', $mantenimiento) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar este mantenimiento?')"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-outline-secondary" disabled title="Solo admin">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No hay mantenimientos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $mantenimientos->links() }}
        </div>
    </div>
</div>

<!-- Modal Crear Mantenimiento (Solo Admin) -->
@if(auth()->user()->isAdmin())
<div class="modal fade" id="modalCrearMantenimiento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('mantenimiento.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Nuevo Mantenimiento
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Equipo *</label>
                            <select name="equipo_id" class="form-select" required>
                                <option value="">Seleccionar equipo...</option>
                                @foreach($equipos as $equipo)
                                    <option value="{{ $equipo->id }}">
                                        {{ $equipo->codigo }} - {{ $equipo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo *</label>
                            <select name="tipo" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                <option value="Preventivo">Preventivo</option>
                                <option value="Correctivo">Correctivo</option>
                                <option value="Predictivo">Predictivo</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha Programada</label>
                            <input type="date" name="fecha_programada" class="form-control" value="{{ now()->format('Y-m-d') }}">
                            <small class="text-muted">Si no se especifica, se usa la fecha actual</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado *</label>
                            <select name="estado" class="form-select" required>
                                <option value="Pendiente">Pendiente</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="Completado">Completado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Técnico</label>
                            <input type="text" name="tecnico" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Costo (S/.)</label>
                            <input type="number" name="costo" class="form-control" step="0.01" min="0">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Descripción *</label>
                            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Guardar Mantenimiento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}
</style>
@endsection