<aside class="w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white flex-shrink-0 hidden md:flex flex-col">
    <div class="p-4 border-b border-blue-700">
        <div class="flex items-center space-x-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <div>
                <h2 class="text-lg font-bold">Sistema Inventario</h2>
                <p class="text-xs text-blue-300">Colegio J.B. Sepúlveda</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm hover:bg-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-700 border-l-4 border-blue-400' : 'border-l-4 border-transparent' }}">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('inventario.index') }}" class="flex items-center px-4 py-2.5 text-sm hover:bg-blue-700 {{ request()->routeIs('inventario.*') ? 'bg-blue-700 border-l-4 border-blue-400' : 'border-l-4 border-transparent' }}">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            Inventario
        </a>

        <a href="{{ route('categorias.index') }}" class="flex items-center px-4 py-2.5 text-sm hover:bg-blue-700 {{ request()->routeIs('categorias.*') ? 'bg-blue-700 border-l-4 border-blue-400' : 'border-l-4 border-transparent' }}">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Categorías
        </a>

        <a href="{{ route('reportes.index') }}" class="flex items-center px-4 py-2.5 text-sm hover:bg-blue-700 {{ request()->routeIs('reportes.*') ? 'bg-blue-700 border-l-4 border-blue-400' : 'border-l-4 border-transparent' }}">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Reportes
        </a>

        <div class="px-4 py-2 text-xs font-semibold text-blue-300 uppercase tracking-wider mt-4">
            Administración
        </div>

        <a href="{{ route('usuarios.index') }}" class="flex items-center px-4 py-2.5 text-sm hover:bg-blue-700 {{ request()->routeIs('usuarios.*') ? 'bg-blue-700 border-l-4 border-blue-400' : 'border-l-4 border-transparent' }}">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Usuarios
        </a>

        <a href="{{ route('mantenimiento.index') }}" class="flex items-center px-4 py-2.5 text-sm hover:bg-blue-700 {{ request()->routeIs('mantenimiento.*') ? 'bg-blue-700 border-l-4 border-blue-400' : 'border-l-4 border-transparent' }}">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Mantenimiento
        </a>

        <div class="px-4 py-2 text-xs font-semibold text-blue-300 uppercase tracking-wider mt-4">
            Sistema
        </div>

        <a href="{{ route('configuracion.index') }}" class="flex items-center px-4 py-2.5 text-sm hover:bg-blue-700 {{ request()->routeIs('configuracion.*') ? 'bg-blue-700 border-l-4 border-blue-400' : 'border-l-4 border-transparent' }}">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
            </svg>
            Configuración
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm hover:bg-blue-700 border-l-4 border-transparent text-left">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Cerrar Sesión
            </button>
        </form>
    </nav>
</aside>