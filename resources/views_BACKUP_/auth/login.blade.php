<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - IE 20957 Cañete</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen">
    <!-- Contenedor principal con imagen de fondo -->
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat px-4 py-8" style="background-image: url('{{ asset('images/porton.png') }}');">
           <!-- Logo flotante en la parte superior derecha del fondo -->
    <div class="absolute top-6 right-6 z-10">
        <img src="{{ asset('images/logo.png') }}" alt="Logo IE 20957" class="w-20 h-20 object-contain">
    </div>
        <!-- Panel de Login -->
        <div class="w-full max-w-md">
            <div class="bg-white bg-opacity-95 backdrop-blur-md rounded-2xl shadow-2xl p-8">
                
                <!-- Encabezado -->
                <div class="text-center mb-7">
                    <h1 class="text-4xl font-extrabold text-blue-900 mb-3">
                        Sistema de Inventarios de la IE 20957 Cañete
                    </h1>
                    <p class="text-sm text-gray-600 font-medium">
                        Acceso al sistema de gestión de inventario educativo de la IE 20957 Cañete
                    </p>
                </div>

                <!-- Mensajes de error de sesión -->
                @if (session('status'))
                    <div class="mb-4 text-sm font-semibold text-green-700 bg-green-100 p-3 rounded-lg border border-green-300">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Formulario de Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Campo Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-bold text-gray-800 mb-2">
                            Correo Electrónico
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 font-medium @error('email') border-red-500 @enderror"
                            placeholder="usuario@ejemplo.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-bold text-gray-800 mb-2">
                            Contraseña
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 font-medium @error('password') border-red-500 @enderror"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Recordarme y Olvidaste contraseña -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            >
                            <label for="remember_me" class="ml-2 block text-sm font-semibold text-gray-700">
                                Recordarme
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <!-- Botón Iniciar Sesión -->
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Iniciar Sesión
                    </button>

                    <!-- Enlace Registro -->
                    @if (Route::has('register'))
                        <div class="mt-5 text-center">
                            <p class="text-sm font-medium text-gray-600">
                                ¿No tienes una cuenta? 
                                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-bold hover:underline">
                                    Regístrate
                                </a>
                            </p>
                        </div>
                    @endif
                </form>

            </div>
        </div>

    </div>
</body>
</html>