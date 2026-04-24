<x-app-layout>
    <div class="flex h-screen bg-gray-100 overflow-hidden">
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('layouts.header', ['title' => 'Gestión de Usuarios', 'subtitle' => 'Administra los usuarios del sistema'])

            <main class="flex-1 overflow-y-auto bg-gray-100 p-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Search and Actions -->
                    <div class="bg-white rounded-lg shadow mb-6 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                            <div class="flex-1 max-w-md">
                                <div class="relative">
                                    <input type="text" placeholder="Buscar usuarios..." 
                                           class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <select class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Todos los roles</option>
                                    <option value="admin">Administrador</option>
                                    <option value="profesor">Profesor</option>
                                    <option value="coordinador">Coordinador</option>
                                </select>
                                <button onclick="openUserModal()" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Nuevo Usuario
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Users Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- User Card 1 -->
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                            <div class="p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                        JD
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Juan Pérez</h3>
                                        <p class="text-sm text-gray-600">juan.perez@colegio.edu</p>
                                        <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                            Administrador
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        +51 987 654 321
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Último acceso: Hoy, 10:30 AM
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button onclick="viewUser(1)" class="flex-1 px-3 py-2 text-sm text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">
                                        Ver
                                    </button>
                                    <button onclick="editUser(1)" class="flex-1 px-3 py-2 text-sm text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 transition">
                                        Editar
                                    </button>
                                    <button onclick="deleteUser(1)" class="px-3 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- User Card 2 -->
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                            <div class="p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-green-800 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                        MG
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">María González</h3>
                                        <p class="text-sm text-gray-600">maria.gonzalez@colegio.edu</p>
                                        <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                            Profesor
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        +51 987 123 456
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Último acceso: Ayer, 4:15 PM
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button onclick="viewUser(2)" class="flex-1 px-3 py-2 text-sm text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">
                                        Ver
                                    </button>
                                    <button onclick="editUser(2)" class="flex-1 px-3 py-2 text-sm text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 transition">
                                        Editar
                                    </button>
                                    <button onclick="deleteUser(2)" class="px-3 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- User Card 3 -->
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                            <div class="p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-orange-600 to-orange-800 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                        CR
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Carlos Rodríguez</h3>
                                        <p class="text-sm text-gray-600">carlos.rodriguez@colegio.edu</p>
                                        <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            Coordinador
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        +51 987 789 012
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Último acceso: 28 Oct, 9:00 AM
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button onclick="viewUser(3)" class="flex-1 px-3 py-2 text-sm text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">
                                        Ver
                                    </button>
                                    <button onclick="editUser(3)" class="flex-1 px-3 py-2 text-sm text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 transition">
                                        Editar
                                    </button>
                                    <button onclick="deleteUser(3)" class="px-3 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add/Edit User Modal -->
    <div id="userModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800" id="userModalTitle">Nuevo Usuario</h3>
                <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form id="userForm" class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo *</label>
                        <input type="text" name="nombre" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Juan Pérez" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" name="email" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="usuario@colegio.edu" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="tel" name="telefono" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="+51 987 654 321">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rol *</label>
                        <select name="rol" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Seleccionar</option>
                            <option value="admin">Administrador</option>
                            <option value="profesor">Profesor</option>
                            <option value="coordinador">Coordinador</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña *</label>
                        <input type="password" name="password" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="••••••••" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña *</label>
                        <input type="password" name="password_confirmation" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="activo" id="activo" class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500" checked>
                    <label for="activo" class="ml-2 text-sm text-gray-700">Usuario activo</label>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeUserModal()" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View User Modal -->
    <div id="viewUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Detalles del Usuario</h3>
                <button onclick="closeViewUserModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-200">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        JD
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-gray-900">Juan Pérez</h4>
                        <p class="text-sm text-gray-600">juan.perez@colegio.edu</p>
                        <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                            Administrador
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Teléfono</p>
                        <p class="text-sm font-semibold text-gray-900">+51 987 654 321</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Estado</p>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Activo</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Fecha de registro</p>
                        <p class="text-sm text-gray-700">15 de Marzo, 2024</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Último acceso</p>
                        <p class="text-sm text-gray-700">Hoy, 10:30 AM</p>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                    <button onclick="closeViewUserModal()" class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cerrar
                    </button>
                    <button onclick="closeViewUserModal(); editUser(1)" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Editar Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openUserModal() {
            document.getElementById('userModalTitle').textContent = 'Nuevo Usuario';
            document.getElementById('userForm').reset();
            document.getElementById('userModal').classList.remove('hidden');
        }

        function editUser(id) {
            document.getElementById('userModalTitle').textContent = 'Editar Usuario';
            document.getElementById('userModal').classList.remove('hidden');
        }

        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
        }

        function viewUser(id) {
            document.getElementById('viewUserModal').classList.remove('hidden');
        }

        function closeViewUserModal() {
            document.getElementById('viewUserModal').classList.add('hidden');
        }

        function deleteUser(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                alert('Usuario eliminado exitosamente');
            }
        }

        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const password = document.querySelector('[name="password"]').value;
            const confirmPassword = document.querySelector('[name="password_confirmation"]').value;
            
            if (password !== confirmPassword) {
                alert('Las contraseñas no coinciden');
                return;
            }
            
            alert('Usuario guardado exitosamente');
            closeUserModal();
        });
    </script>
</x-app-layout>