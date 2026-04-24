@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header con Badge de Rol -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-box-seam text-primary me-2"></i>
                Inventario de Equipos
            </h1>
            <p class="text-muted">Gestión y control de equipos del sistema</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <!-- Badge del rol del usuario -->
            @if(auth()->user()->isAdmin())
                <span class="badge bg-danger fs-6 me-2">
                    <i class="bi bi-shield-fill-check me-1"></i> Administrador
                </span>
            @else
                <span class="badge bg-primary fs-6 me-2">
                    <i class="bi bi-person-fill me-1"></i> Usuario
                </span>
            @endif

            <!-- Botón crear solo para administradores -->
            @if(auth()->user()->isAdmin())
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearEquipo">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo Equipo
                </button>
            @endif
        </div>
    </div>

    <!-- Alertas de permisos -->
    @if(!auth()->user()->isAdmin())
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            <strong>Modo de Solo Lectura:</strong> Tienes permisos de visualización. Contacta a un administrador para realizar cambios.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Mensajes de éxito/error -->
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

    <!-- Filtros de búsqueda -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('inventario.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Código, nombre, marca..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria" class="form-select">
                        <option value="">Todas</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="Disponible" {{ request('estado') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="En Uso" {{ request('estado') == 'En Uso' ? 'selected' : '' }}>En Uso</option>
                        <option value="Mantenimiento" {{ request('estado') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        <option value="Dado de Baja" {{ request('estado') == 'Dado de Baja' ? 'selected' : '' }}>Dado de Baja</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de equipos -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Listado de Equipos
                <span class="badge bg-primary ms-2">{{ $equipos->total() }} equipos</span>
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
                                <td><code>{{ $equipo->codigo }}</code></td>
                                <td><strong>{{ $equipo->nombre }}</strong></td>
                                <td>
                                    <span class="badge bg-secondary">{{ $equipo->categoria->nombre }}</span>
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
                                    <span class="badge bg-{{ $badgeClass }}">{{ $equipo->estado }}</span>
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
                                    <div class="btn-group btn-group-sm">
                                        <!-- Ver - Todos pueden ver -->
                                        <button type="button" class="btn btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalVerEquipo"
                                                onclick="verEquipo({{ $equipo->id }})" 
                                                title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <!-- Editar - Solo admin -->
                                        @if(auth()->user()->isAdmin())
                                            <button type="button" class="btn btn-outline-warning" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditarEquipo"
                                                    onclick="cargarEquipo({{ $equipo->id }})" 
                                                    title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Eliminar - Solo admin -->
                                            <form action="{{ route('inventario.destroy', $equipo) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar este equipo?')"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Botones deshabilitados para usuarios normales -->
                                            <button type="button" class="btn btn-outline-secondary" disabled title="Solo admin">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        @endif
                                    </div>
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
        <div class="card-footer bg-white">
            {{ $equipos->links() }}
        </div>
    </div>
</div>

<!-- Modal Ver Detalles del Equipo (Todos los usuarios) -->
<div class="modal fade" id="modalVerEquipo" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-eye me-2"></i>Detalles del Equipo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <!-- Columna izquierda - Información básica -->
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <h6 class="text-primary mb-3">
                                    <i class="bi bi-info-circle me-2"></i>Información General
                                </h6>
                                
                                <div class="mb-3">
                                    <label class="text-muted small">Código</label>
                                    <div class="fw-bold" id="ver_codigo">-</div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Nombre</label>
                                    <div class="fw-bold" id="ver_nombre">-</div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Categoría</label>
                                    <div id="ver_categoria">-</div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Estado</label>
                                    <div id="ver_estado_badge">-</div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small">Descripción</label>
                                    <div id="ver_descripcion">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna derecha - Especificaciones técnicas -->
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <h6 class="text-primary mb-3">
                                    <i class="bi bi-gear me-2"></i>Especificaciones Técnicas
                                </h6>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="text-muted small">Marca</label>
                                        <div class="fw-bold" id="ver_marca">-</div>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="text-muted small">Modelo</label>
                                        <div class="fw-bold" id="ver_modelo">-</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="text-muted small">Serie</label>
                                        <div id="ver_serie">-</div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="text-muted small">
                                            <i class="bi bi-geo-alt me-1"></i>Ubicación
                                        </label>
                                        <div id="ver_ubicacion">-</div>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="text-muted small">
                                            <i class="bi bi-calendar me-1"></i>Fecha Adquisición
                                        </label>
                                        <div id="ver_fecha_adquisicion">-</div>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="text-muted small">
                                            <i class="bi bi-currency-dollar me-1"></i>Precio Adquisición
                                        </label>
                                        <div class="fw-bold text-success" id="ver_precio_adquisicion">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="text-primary mb-3">
                                    <i class="bi bi-chat-left-text me-2"></i>Observaciones
                                </h6>
                                <div id="ver_observaciones" class="text-muted">Sin observaciones</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del sistema -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-0" style="background-color: #f8f9fa;">
                            <div class="card-body py-2">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <small class="text-muted">Creado el:</small>
                                        <div class="small" id="ver_created_at">-</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Última actualización:</small>
                                        <div class="small" id="ver_updated_at">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Cerrar
                </button>
                @if(auth()->user()->isAdmin())
                    <button type="button" class="btn btn-warning" onclick="editarDesdeVer()" data-bs-dismiss="modal">
                        <i class="bi bi-pencil me-1"></i>Editar Equipo
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Equipo (Solo Admin) -->
@if(auth()->user()->isAdmin())
<div class="modal fade" id="modalCrearEquipo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('inventario.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Nuevo Equipo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Código *</label>
                            <input type="text" name="codigo" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Categoría *</label>
                            <select name="categoria_id" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado *</label>
                            <select name="estado" class="form-select" required>
                                <option value="Disponible">Disponible</option>
                                <option value="En Uso">En Uso</option>
                                <option value="Mantenimiento">Mantenimiento</option>
                                <option value="Dado de Baja">Dado de Baja</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Marca</label>
                            <input type="text" name="marca" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Modelo</label>
                            <input type="text" name="modelo" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Guardar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Equipo (Solo Admin) -->
<div class="modal fade" id="modalEditarEquipo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditarEquipo" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil me-2"></i>Editar Equipo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Código *</label>
                            <input type="text" name="codigo" id="edit_codigo" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Categoría *</label>
                            <select name="categoria_id" id="edit_categoria_id" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado *</label>
                            <select name="estado" id="edit_estado" class="form-select" required>
                                <option value="Disponible">Disponible</option>
                                <option value="En Uso">En Uso</option>
                                <option value="Mantenimiento">Mantenimiento</option>
                                <option value="Dado de Baja">Dado de Baja</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Marca</label>
                            <input type="text" name="marca" id="edit_marca" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Modelo</label>
                            <input type="text" name="modelo" id="edit_modelo" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Serie</label>
                            <input type="text" name="serie" id="edit_serie" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ubicación</label>
                            <input type="text" name="ubicacion" id="edit_ubicacion" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de Adquisición</label>
                            <input type="date" name="fecha_adquisicion" id="edit_fecha_adquisicion" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Precio de Adquisición</label>
                            <input type="number" step="0.01" name="precio_adquisicion" id="edit_precio_adquisicion" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observaciones" id="edit_observaciones" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save me-1"></i>Actualizar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let equipoActualId = null;

function verEquipo(equipoId) {
    equipoActualId = equipoId;
    
    fetch(`/inventario/${equipoId}`)
        .then(response => response.json())
        .then(equipo => {
            // Información general
            document.getElementById('ver_codigo').textContent = equipo.codigo || '-';
            document.getElementById('ver_nombre').textContent = equipo.nombre || '-';
            document.getElementById('ver_categoria').innerHTML = equipo.categoria 
                ? `<span class="badge bg-secondary">${equipo.categoria.nombre}</span>` 
                : '-';
            
            // Badge de estado con color
            const estadoColors = {
                'Disponible': 'success',
                'En Uso': 'info',
                'Mantenimiento': 'warning',
                'Dado de Baja': 'danger'
            };
            const colorEstado = estadoColors[equipo.estado] || 'secondary';
            document.getElementById('ver_estado_badge').innerHTML = equipo.estado 
                ? `<span class="badge bg-${colorEstado}">${equipo.estado}</span>` 
                : '-';
            
            document.getElementById('ver_descripcion').textContent = equipo.descripcion || 'Sin descripción';
            
            // Especificaciones técnicas
            document.getElementById('ver_marca').textContent = equipo.marca || '-';
            document.getElementById('ver_modelo').textContent = equipo.modelo || '-';
            document.getElementById('ver_serie').innerHTML = equipo.serie 
                ? `<code style="background-color: #e9ecef; padding: 2px 6px; border-radius: 4px;">${equipo.serie}</code>` 
                : '-';
            document.getElementById('ver_ubicacion').innerHTML = equipo.ubicacion 
                ? `<i class="bi bi-geo-alt-fill text-primary me-1"></i>${equipo.ubicacion}` 
                : '-';
            
            // Fecha y precio
            document.getElementById('ver_fecha_adquisicion').textContent = equipo.fecha_adquisicion 
                ? new Date(equipo.fecha_adquisicion).toLocaleDateString('es-PE') 
                : '-';
            document.getElementById('ver_precio_adquisicion').textContent = equipo.precio_adquisicion 
                ? `S/. ${parseFloat(equipo.precio_adquisicion).toFixed(2)}` 
                : '-';
            
            // Observaciones
            document.getElementById('ver_observaciones').textContent = equipo.observaciones || 'Sin observaciones';
            
            // Fechas del sistema
            document.getElementById('ver_created_at').textContent = equipo.created_at 
                ? new Date(equipo.created_at).toLocaleString('es-PE') 
                : '-';
            document.getElementById('ver_updated_at').textContent = equipo.updated_at 
                ? new Date(equipo.updated_at).toLocaleString('es-PE') 
                : '-';
        })
        .catch(error => {
            console.error('Error al cargar el equipo:', error);
            alert('Error al cargar los datos del equipo');
        });
}

function editarDesdeVer() {
    if (equipoActualId) {
        // Abrir modal de edición
        const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarEquipo'));
        modalEditar.show();
        cargarEquipo(equipoActualId);
    }
}

function cargarEquipo(equipoId) {
    equipoActualId = equipoId;
    
    // Hacer petición AJAX para obtener los datos del equipo
    fetch(`/inventario/${equipoId}`)
        .then(response => response.json())
        .then(equipo => {
            // Llenar el formulario con los datos
            document.getElementById('edit_codigo').value = equipo.codigo || '';
            document.getElementById('edit_nombre').value = equipo.nombre || '';
            document.getElementById('edit_categoria_id').value = equipo.categoria_id || '';
            document.getElementById('edit_estado').value = equipo.estado || '';
            document.getElementById('edit_marca').value = equipo.marca || '';
            document.getElementById('edit_modelo').value = equipo.modelo || '';
            document.getElementById('edit_serie').value = equipo.serie || '';
            document.getElementById('edit_ubicacion').value = equipo.ubicacion || '';
            document.getElementById('edit_fecha_adquisicion').value = equipo.fecha_adquisicion || '';
            document.getElementById('edit_precio_adquisicion').value = equipo.precio_adquisicion || '';
            document.getElementById('edit_descripcion').value = equipo.descripcion || '';
            document.getElementById('edit_observaciones').value = equipo.observaciones || '';
            
            // Actualizar la acción del formulario
            document.getElementById('formEditarEquipo').action = `/inventario/${equipoId}`;
        })
        .catch(error => {
            console.error('Error al cargar el equipo:', error);
            alert('Error al cargar los datos del equipo');
        });
}
</script>
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