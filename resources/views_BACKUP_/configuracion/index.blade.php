<x-app-layout>
    <x-slot name="header">
        Configuración
    </x-slot>

   <div class="flex h-screen">
    <aside class="w-56 bg-blue-900 text-white"> ... </aside>
    <main class="flex-1 overflow-y-auto p-6 bg-gray-100">


            <!-- Encabezado -->
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900">Configuración del Sistema</h3>
                <p class="text-sm text-gray-500 mt-1">Ajusta las preferencias y parámetros generales</p>
            </div>

            <!-- Formulario de configuración -->
            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre de la Institución</label>
                    <input type="text" value="Colegio La Sepultura" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Correo de contacto</label>
                    <input type="email" value="contacto@colegio.edu" 
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Color principal del sistema</label>
                    <select class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Azul Marino</option>
                        <option>Verde</option>
                        <option>Gris</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>