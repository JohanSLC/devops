<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema Inventario') }} - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
        }
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            position: relative;
        }
        .logo-container {
            position: absolute;
            top: -50px;
            right: 30px;
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-container img {
            max-width: 80%;
            max-height: 80%;
        }
        h2 {
            color: #1e3a8a;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 30px;
        }
        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-control {
            border: 1px solid #e5e7eb;
            padding: 12px 16px;
            font-size: 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 4px rgba(30,64,175,0.1);
        }
        .btn-primary {
            background: #1e40af;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: #1e3a8a;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(30,64,175,0.3);
        }
        .form-check-input:checked {
            background-color: #1e40af;
            border-color: #1e40af;
        }
        .link-primary {
            color: #1e40af;
            text-decoration: none;
            font-weight: 500;
        }
        .link-primary:hover {
            color: #1e3a8a;
            text-decoration: underline;
        }
        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }
        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            color: #9ca3af;
            font-size: 13px;
        }
        .alert {
            border-radius: 8px;
            font-size: 14px;
            padding: 12px 16px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-container">
                <i class="bi bi-shield-check" style="font-size: 48px; color: #1e40af;"></i>
            </div>
            
            <h2>Sistema de<br>Inventarios de la IE<br>20957 Cañete</h2>
            <p class="subtitle">Acceso al sistema de gestión de inventario educativo de la IE 20957 Cañete</p>
            
            @if(session('status'))
            <div class="alert alert-success mb-3">
                <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>
                @foreach($errors->all() as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>