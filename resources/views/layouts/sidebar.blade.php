<aside class="sidebar" style="width: 250px; background: #1e293b; color: white; height: 100vh; position: fixed; left: 0; top: 0; overflow-y: auto;">
    <div class="p-4 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
        <h4 class="mb-0" style="color: white;">Sistema Inventario</h4>
        <small style="color: #94a3b8;">IE 20957 Cañete</small>
    </div>
    
    <nav class="mt-3">
        <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="display: flex; align-items: center; padding: 12px 20px; color: #cbd5e1; text-decoration: none; transition: all 0.3s;">
            <i class="bi bi-speedometer2 me-3"></i> Dashboard
        </a>
        
        <a href="{{ route('inventario.index') }}" class="nav-link {{ request()->routeIs('inventario.*') ? 'active' : '' }}" style="display: flex; align-items: center; padding: 12px 20px; color: #cbd5e1; text-decoration: none; transition: all 0.3s;">
            <i class="bi bi-box-seam me-3"></i> Inventario
        </a>
        
        <a href="{{ route('categorias.index') }}" class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}" style="display: flex; align-items: center; padding: 12px 20px; color: #cbd5e1; text-decoration: none; transition: all 0.3s;">
            <i class="bi bi-grid-3x3-gap me-3"></i> Categorías
        </a>
        
        <a href="#" class="nav-link" style="display: flex; align-items: center; padding: 12px 20px; color: #cbd5e1; text-decoration: none; transition: all 0.3s;">
            <i class="bi bi-people me-3"></i> Usuarios
        </a>
        
        <a href="#" class="nav-link" style="display: flex; align-items: center; padding: 12px 20px; color: #cbd5e1; text-decoration: none; transition: all 0.3s;">
            <i class="bi bi-wrench me-3"></i> Mantenimiento
        </a>
        
        <a href="#" class="nav-link" style="display: flex; align-items: center; padding: 12px 20px; color: #cbd5e1; text-decoration: none; transition: all 0.3s;">
            <i class="bi bi-file-text me-3"></i> Reportes
        </a>
        
        <a href="#" class="nav-link" style="display: flex; align-items: center; padding: 12px 20px; color: #cbd5e1; text-decoration: none; transition: all 0.3s;">
            <i class="bi bi-gear me-3"></i> Configuración
        </a>
    </nav>
    
    <div style="position: absolute; bottom: 0; width: 100%; padding: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100 btn-sm">
                <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
            </button>
        </form>
    </div>
    
    <style>
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white !important;
        }
        .nav-link.active {
            background: #3b82f6;
            color: white !important;
        }
    </style>
</aside>