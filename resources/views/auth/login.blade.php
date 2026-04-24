@php
    use Illuminate\Support\Facades\Route;
@endphp

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
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat px-4 py-8" style="background-image: url('{{ asset("images/porton.png") }}')">
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
    <div class="relative">
        <input 
            id="password" 
            type="password" 
            name="password" 
            required 
            autocomplete="current-password"
            class="w-full px-4 py-2.5 pr-12 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 font-medium @error('password') border-red-500 @enderror"
            placeholder="••••••••"
        >
        <button 
            type="button" 
            onclick="togglePassword()" 
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
        >
            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>
    </div>
    @error('password')
        <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
    @enderror
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />';
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
    }
}
</script>

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