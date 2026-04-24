<x-app-layout>
    <x-slot name="header">
        Mantenimiento
    </x-slot>

    <div class="flex h-screen">
    <aside class="w-56 bg-blue-900 text-white"> ... </aside>
    <main class="flex-1 overflow-y-auto p-6 bg-gray-100">


            <!-- Encabezado -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Módulo de Mantenimiento</h3>
                    <p class="text-sm text-gray-500 mt-1">Administra las tareas de mantenimiento del sistema</p>
                </div>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nueva Tarea
                </button>
            </div>

            <!-- Buscador -->
            <div class="mb-4 flex items-center space-x-3">
                <input type="text" placeholder="Buscar tareas..." 
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <select class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Todos</option>
                    <option>Completado</option>
                    <option>Pendiente</option>
                    <option>En Progreso</option>
                </select>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Responsable</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Ejemplo de varias filas -->
                        @for ($i = 1; $i <= 10; $i++)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">MT-00{{ $i }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Tarea de mantenimiento número {{ $i }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $i % 2 == 0 ? 'Juan Pérez' : 'María García' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($i % 3 == 0)
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Completado</span>
                                @elseif($i % 3 == 1)
                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">Pendiente</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">En Progreso</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">31/10/2025</td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">Ver</button>
                                <button class="text-green-600 hover:text-green-900 mr-3">Editar</button>
                                <button class="text-red-600 hover:text-red-900">Eliminar</button>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- Paginación simulada -->
            <div class="flex justify-between items-center mt-6">
                <p class="text-sm text-gray-500">Mostrando 1 a 10 de 50 tareas</p>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-100">Anterior</button>
                    <button class="px-3 py-1 border rounded-lg text-sm bg-blue-600 text-white">1</button>
                    <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-100">2</button>
                    <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-100">3</button>
                    <button class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-100">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>