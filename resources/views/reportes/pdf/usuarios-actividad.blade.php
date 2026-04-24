<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte: Usuarios y Actividad</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            background-color: #ef4444;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            opacity: 0.9;
        }

        .info-bar {
            background-color: #fee2e2;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border-left: 4px solid #ef4444;
        }

        .info-bar table {
            width: 100%;
        }

        .info-bar td {
            padding: 3px 0;
            font-size: 10px;
        }

        .info-bar strong {
            color: #dc2626;
        }

        /* Estadísticas */
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 12px;
            text-align: center;
            border: 2px solid #e5e7eb;
            background-color: #fff;
        }

        .stat-card h3 {
            font-size: 20px;
            margin-bottom: 3px;
            color: #ef4444;
        }

        .stat-card p {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
        }

        .stat-card.primary h3 { color: #3b82f6; }
        .stat-card.danger h3 { color: #ef4444; }
        .stat-card.info h3 { color: #0ea5e9; }
        .stat-card.warning h3 { color: #f59e0b; }

        /* Tabla */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table thead {
            background-color: #ef4444;
            color: white;
        }

        .table th {
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid #ef4444;
        }

        .table th.text-center { text-align: center; }

        .table tbody tr:nth-child(even) {
            background-color: #fef2f2;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #fff;
        }

        .table td {
            padding: 8px 6px;
            border: 1px solid #e5e7eb;
            font-size: 10px;
        }

        .table td.text-center { text-align: center; }

        .table tfoot {
            background-color: #fecaca;
            font-weight: bold;
        }

        .table tfoot td {
            padding: 8px 6px;
            border: 1px solid #ef4444;
            font-size: 10px;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 600;
            color: white;
        }

        .badge.primary { background-color: #3b82f6; }
        .badge.danger { background-color: #ef4444; }
        .badge.success { background-color: #10b981; }
        .badge.info { background-color: #0ea5e9; }
        .badge.warning { background-color: #f59e0b; }
        .badge.secondary { background-color: #6b7280; }

        /* Avatar circular */
        .avatar {
            display: inline-block;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            text-align: center;
            line-height: 25px;
            color: white;
            font-weight: bold;
            font-size: 11px;
            margin-right: 5px;
            vertical-align: middle;
        }

        .avatar.admin { background-color: #ef4444; }
        .avatar.user { background-color: #3b82f6; }

        /* Resumen */
        .summary-box {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 12px;
            margin: 15px 0;
        }

        .summary-box h3 {
            font-size: 12px;
            color: #dc2626;
            margin-bottom: 8px;
        }

        .summary-box ul {
            margin-left: 20px;
        }

        .summary-box li {
            margin: 3px 0;
            font-size: 10px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #fee2e2;
            padding: 10px 20px;
            text-align: center;
            font-size: 9px;
            color: #991b1b;
            border-top: 2px solid #ef4444;
        }

        h3.section-title {
            margin: 20px 0 10px 0;
            color: #ef4444;
            font-size: 13px;
            border-bottom: 2px solid #ef4444;
            padding-bottom: 5px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>👥 Reporte: Usuarios y Actividad</h1>
        <p>Sistema de Inventario - Análisis de actividad de usuarios</p>
    </div>

    <!-- Información del reporte -->
    <div class="info-bar">
        <table>
            <tr>
                <td><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i') }}</td>
                <td style="text-align: right;"><strong>Usuario:</strong> {{ auth()->user()->name }}</td>
            </tr>
            <tr>
                <td><strong>Período:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</td>
                <td style="text-align: right;"><strong>Total Usuarios:</strong> {{ $usuarios->count() }}</td>
            </tr>
        </table>
    </div>

    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <h3>{{ $estadisticas['total_usuarios'] }}</h3>
            <p>Total Usuarios</p>
        </div>
        <div class="stat-card danger">
            <h3>{{ $estadisticas['administradores'] }}</h3>
            <p>Administradores</p>
        </div>
        <div class="stat-card info">
            <h3>{{ $estadisticas['total_movimientos'] }}</h3>
            <p>Total Movimientos</p>
        </div>
        <div class="stat-card warning">
            <h3>{{ $estadisticas['total_mantenimientos'] }}</h3>
            <p>Total Mantenimientos</p>
        </div>
    </div>

    <!-- Resumen ejecutivo -->
    <div class="summary-box">
        <h3>📋 Resumen Ejecutivo</h3>
        <ul>
            <li>Total de usuarios en el sistema: <strong>{{ $estadisticas['total_usuarios'] }}</strong></li>
            <li>Usuarios con rol de Administrador: <strong>{{ $estadisticas['administradores'] }}</strong></li>
            <li>Usuarios normales: <strong>{{ $estadisticas['usuarios_normales'] }}</strong></li>
            <li>Usuarios activos en el período: <strong>{{ $usuarios->where('total_actividad', '>', 0)->count() }}</strong></li>
            <li>Total de movimientos registrados: <strong>{{ $estadisticas['total_movimientos'] }}</strong></li>
            <li>Total de mantenimientos gestionados: <strong>{{ $estadisticas['total_mantenimientos'] }}</strong></li>
        </ul>
    </div>

    <!-- Tabla de usuarios -->
    <h3 class="section-title">📊 Detalle de Actividad por Usuario</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Movimientos</th>
                <th class="text-center">Mantenimientos</th>
                <th class="text-center">Total</th>
                <th>Última Actividad</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios->sortByDesc('total_actividad') as $usuario)
                <tr>
                    <td>
                        <span class="avatar {{ $usuario['rol'] == 'Administrador' ? 'admin' : 'user' }}">
                            {{ strtoupper(substr($usuario['nombre'], 0, 1)) }}
                        </span>
                        <strong>{{ $usuario['nombre'] }}</strong>
                    </td>
                    <td>{{ $usuario['email'] }}</td>
                    <td>
                        @if($usuario['rol'] == 'Administrador')
                            <span class="badge danger">Administrador</span>
                        @else
                            <span class="badge primary">Usuario</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($usuario['estado'] == 'Activo')
                            <span class="badge success">Activo</span>
                        @else
                            <span class="badge secondary">Inactivo</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge info">{{ $usuario['movimientos'] }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge warning">{{ $usuario['mantenimientos'] }}</span>
                    </td>
                    <td class="text-center">
                        <strong>{{ $usuario['total_actividad'] }}</strong>
                    </td>
                    <td>
                        @if($usuario['ultima_actividad'])
                            {{ \Carbon\Carbon::parse($usuario['ultima_actividad'])->format('d/m/Y') }}
                        @else
                            Sin actividad
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #6b7280;">
                        No hay usuarios registrados
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;"><strong>TOTAL:</strong></td>
                <td class="text-center">{{ $usuarios->sum('movimientos') }}</td>
                <td class="text-center">{{ $usuarios->sum('mantenimientos') }}</td>
                <td class="text-center">{{ $usuarios->sum('total_actividad') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- Análisis adicional -->
    <h3 class="section-title">📈 Análisis de Actividad</h3>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="width: 50%; padding: 10px; background-color: #fef2f2; border: 1px solid #fecaca;">
                <strong>Usuario más activo:</strong><br>
                @php
                    $masActivo = $usuarios->sortByDesc('total_actividad')->first();
                @endphp
                @if($masActivo)
                    {{ $masActivo['nombre'] }} ({{ $masActivo['total_actividad'] }} actividades)
                @else
                    Sin datos
                @endif
            </td>
            <td style="width: 50%; padding: 10px; background-color: #fef2f2; border: 1px solid #fecaca;">
                <strong>Usuarios sin actividad:</strong><br>
                {{ $usuarios->where('total_actividad', 0)->count() }} usuarios
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        Sistema de Inventario &copy; {{ date('Y') }} | 
        Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}
    </div>
</body>
</html>