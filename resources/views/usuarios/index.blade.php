@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-people text-danger me-2"></i>
                Gestión de Usuarios
            </h1>
            <p class="text-muted">Administración de usuarios del sistema</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <span class="badge bg-danger fs-6 me-2">
                <i class="bi bi-shield-fill-check me-1"></i> Administrador
            </span>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
                <i class="bi bi-person-plus me-1"></i> Nuevo Usuario
            </button>
        </div>
    </div>

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

    <!-- Estadísticas rápidas -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-people text-primary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Total Usuarios</h6>
                            <h3 class="mb-0">{{ $usuarios->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="bi bi-shield-check text-danger fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Administradores</h6>
                            <h3 class="mb-0">{{ $usuarios->where('rol', 'Administrador')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                            <i class="bi bi-person text-info fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 small">Usuarios</h6>
                            <h3 class="mb-0">{{ $usuarios->where('rol', 'Usuario')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Listado de Usuarios
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td><strong>#{{ $usuario->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                             style="width: 35px; height: 35px; font-size: 14px;">
                                            {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $usuario->name }}</strong>
                                            @if($usuario->id == auth()->id())
                                                <span class="badge bg-success ms-1">Tú</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="bi bi-envelope text-muted me-1"></i>
                                    {{ $usuario->email }}
                                </td>
                                <td>
                                    @if($usuario->isAdmin())
                                        <span class="badge bg-danger">
                                            <i class="bi bi-shield-fill-check me-1"></i>Administrador
                                        </span>
                                    @else
                                        <span class="badge bg-primary">
                                            <i class="bi bi-person-fill me-1"></i>Usuario
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($usuario->estado)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Activo
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle me-1"></i>Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ $usuario->created_at->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <!-- Ver detalles -->
                                        <button type="button" class="btn btn-outline-primary" 
                                                onclick="verUsuario({{ $usuario->id }})" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        @if($usuario->id != auth()->id())
                                            <!-- Editar -->
                                            <button type="button" class="btn btn-outline-warning" 
                                                    onclick="editarUsuario({{ $usuario->id }})" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Eliminar -->
                                            <form action="{{ route('usuarios.destroy', $usuario) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-outline-secondary" disabled title="No puedes editarte a ti mismo">
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
                                    No hay usuarios registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus me-2"></i>Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña *</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                        <small class="text-muted">Mínimo 8 caracteres</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Contraseña *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol *</label>
                        <select name="rol" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <option value="Usuario">Usuario (Solo lectura)</option>
                            <option value="Administrador">Administrador (Control total)</option>
                        </select>
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Los usuarios solo pueden visualizar. Los administradores pueden editar todo.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}
</style>
@endsection