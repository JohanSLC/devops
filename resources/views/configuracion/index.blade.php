@php
    use Illuminate\Support\Facades\Auth;
@endphp


@extends('layouts.app')

@section('title', 'Configuración')

@section('content')
<div class="page-header">
    <h1>⚙️ Configuración del Sistema</h1> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Configuración</li>
        </ol>
    </nav>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
    <!-- Información del Colegio -->
    <div class="col-lg-8">
        <div class="table-container">
            <h5 class="mb-4" style="font-weight: 600; color: #1f2937;">
                <i class="bi bi-building me-2"></i>Información del Colegio
            </h5>
            
            <form action="#" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nombre de la Institución</label>
                        <input type="text" name="nombre_institucion" class="form-control" value="IE 20957 Cañete" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">RUC</label>
                        <input type="text" name="ruc" class="form-control" value="20123456789">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="Av. Principal 123, Cañete">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="(01) 234-5678">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="contacto@ie20957.edu.pe">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Configuración Rápida -->
    <div class="col-lg-4">
        <div class="table-container mb-4">
            <h5 class="mb-3" style="font-weight: 600; color: #1f2937;">
                <i class="bi bi-sliders me-2"></i>Configuración Rápida
            </h5>
            
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <div>
                    <strong class="d-block" style="font-size: 14px;">Notificaciones</strong>
                    <small class="text-muted">Alertas del sistema</small>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="notif" checked>
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <div>
                    <strong class="d-block" style="font-size: 14px;">Modo Oscuro</strong>
                    <small class="text-muted">Tema de la interfaz</small>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="darkMode">
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong class="d-block" style="font-size: 14px;">Backups Automáticos</strong>
                    <small class="text-muted">Respaldo diario</small>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="backup" checked>
                </div>
            </div>
        </div>

        <!-- Perfil de Usuario -->
        <div class="table-container">
            <h5 class="mb-3" style="font-weight: 600; color: #1f2937;">
                <i class="bi bi-person-circle me-2"></i>Mi Perfil
            </h5>
            
            <div class="text-center mb-3">
                <div class="stat-icon-small mx-auto mb-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <span class="text-white fw-bold" style="font-size: 32px;">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                </div>
                <h6 class="mb-1" style="font-weight: 600;">{{ Auth::user()->name }}</h6>
                <small class="text-muted">{{ Auth::user()->email }}</small>
                <div class="mt-2">
                    <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">Administrador</span>
                </div>
            </div>
            
            <button class="btn btn-outline-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#cambiarPassModal">
                <i class="bi bi-key me-1"></i> Cambiar Contraseña
            </button>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <!-- Estadísticas del Sistema -->
    <div class="col-12">
        <div class="table-container">
            <h5 class="mb-4" style="font-weight: 600; color: #1f2937;">
                <i class="bi bi-graph-up me-2"></i>Estadísticas del Sistema
            </h5>
            
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="p-3 text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white;">
                        <i class="bi bi-box-seam" style="font-size: 32px; opacity: 0.9;"></i>
                        <h3 class="mb-0 mt-2">{{ \App\Models\Equipo::count() }}</h3>
                        <small>Total Equipos</small>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="p-3 text-center" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 12px; color: white;">
                        <i class="bi bi-grid-3x3-gap" style="font-size: 32px; opacity: 0.9;"></i>
                        <h3 class="mb-0 mt-2">{{ \App\Models\Categoria::count() }}</h3>
                        <small>Categorías</small>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="p-3 text-center" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; color: white;">
                        <i class="bi bi-people" style="font-size: 32px; opacity: 0.9;"></i>
                        <h3 class="mb-0 mt-2">{{ \App\Models\User::count() }}</h3>
                        <small>Usuarios</small>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="p-3 text-center" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; color: white;">
                        <i class="bi bi-arrow-left-right" style="font-size: 32px; opacity: 0.9;"></i>
                        <h3 class="mb-0 mt-2">{{ \App\Models\Movimiento::count() }}</h3>
                        <small>Movimientos</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="cambiarPassModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title"><i class="bi bi-key me-2"></i>Cambiar Contraseña</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body" style="padding: 2rem;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contraseña Actual</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f9fafb; border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.table-container {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
</style>
@endsection