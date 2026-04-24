@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header con Badge de Rol -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-folder text-warning me-2"></i>
                Categorías
            </h1>
            <p class="text-muted">Gestión de categorías del inventario</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <!-- Badge del rol -->
            @if(auth()->user()->isAdmin())
                <span class="badge bg-danger fs-6 me-2">
                    <i class="bi bi-shield-fill-check me-1"></i> Administrador
                </span>
                <!-- Botón crear solo para admin -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearCategoria">
                    <i class="bi bi-plus-circle me-1"></i> Nueva Categoría
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
            <strong>Modo Solo Lectura:</strong> Solo puedes visualizar las categorías. Contacta a un administrador para realizar cambios.
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
            <form method="GET" action="{{ route('categorias.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Nombre, código, descripción..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Inactivo" {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search me-1"></i> Buscar
                    </button>
                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de categorías -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Listado de Categorías
                <span class="badge bg-primary ms-2">{{ $categorias->total() }} categorías</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Equipos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr>
                                <td><code>{{ $categoria->codigo }}</code></td>
                                <td><strong>{{ $categoria->nombre }}</strong></td>
                                <td>
                                    <small class="text-muted">
                                        {{ $categoria->descripcion ? \Illuminate\Support\Str::limit($categoria->descripcion, 50) : 'Sin descripción' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $categoria->estado == 'Activo' ? 'success' : 'secondary' }}">
                                        {{ $categoria->estado }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $categoria->equipos_count }} equipos</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <!-- Ver - Todos pueden ver -->
                                        <button type="button" class="btn btn-outline-primary" 
                                                onclick="verCategoria({{ $categoria->id }})" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        @if(auth()->user()->isAdmin())
                                            <!-- Editar - Solo admin -->
                                            <button type="button" class="btn btn-outline-warning" 
                                                    onclick="editarCategoria({{ $categoria->id }})" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Cambiar estado - Solo admin -->
                                            <button type="button" class="btn btn-outline-info" 
                                                    onclick="cambiarEstado({{ $categoria->id }})" title="Cambiar estado">
                                                <i class="bi bi-toggle-on"></i>
                                            </button>

                                            <!-- Eliminar - Solo admin -->
                                            <form action="{{ route('categorias.destroy', $categoria) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?')"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Botón bloqueado para usuarios -->
                                            <button type="button" class="btn btn-outline-secondary" disabled title="Solo admin">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No hay categorías registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $categorias->links() }}
        </div>
    </div>
</div>

<!-- Modal Crear Categoría (Solo Admin) -->
@if(auth()->user()->isAdmin())
<div class="modal fade" id="modalCrearCategoria" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Nueva Categoría
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado *</label>
                        <select name="estado" class="form-select" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function cambiarEstado(id) {
    if(confirm('¿Deseas cambiar el estado de esta categoría?')) {
        fetch(`/categorias/${id}/cambiar-estado`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }
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