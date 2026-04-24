<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro - IE 20957 Cañete</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen">
    <!-- Fondo con imagen -->
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat px-4 py-8" style="background-image: url('{{ asset('images/porton.png') }}');">
        
        <!-- Logo institucional -->
        <div class="absolute top-6 right-6 z-10">
            <img src="{{ asset('images/logo.png') }}" alt="Logo IE 20957" class="w-20 h-20 object-contain">
        </div>

        <!-- Panel de Registro -->
        <div class="w-full max-w-md">
            <div class="bg-white bg-opacity-95 backdrop-blur-md rounded-2xl shadow-2xl p-8">
                
                <!-- Encabezado -->
                <div class="text-center mb-7">
                    <h1 class="text-4xl font-extrabold text-blue-900 mb-3">
                        Registro de Usuario
                    </h1>
                    <p class="text-sm text-gray-600 font-medium">
                        Crea una cuenta para acceder al sistema de inventario educativo de la IE 20957 Cañete
                    </p>
                </div>

                <!-- Formulario de Registro -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold text-gray-800 mb-2">Nombre Completo</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 font-medium @error('name') border-red-500 @enderror"
                            placeholder="Juan Pérez">
                        @error('name')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Correo -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-bold text-gray-800 mb-2">Correo Electrónico</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 font-medium @error('email') border-red-500 @enderror"
                            placeholder="usuario@ejemplo.com">
                        @error('email')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-bold text-gray-800 mb-2">Contraseña</label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 font-medium @error('password') border-red-500 @enderror"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar contraseña -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-800 mb-2">Confirmar Contraseña</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 font-medium"
                            placeholder="••••••••">
                    </div>

                    <!-- Botón Registrar -->
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Registrarse
                    </button>

                    <!-- Enlace a login -->
                    <div class="mt-5 text-center">
                        <p class="text-sm font-medium text-gray-600">
                            ¿Ya tienes una cuenta?
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-bold hover:underline">
                                Inicia sesión
                            </a>
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>