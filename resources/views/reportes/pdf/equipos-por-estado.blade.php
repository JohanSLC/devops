<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte: Equipos por Estado</title>
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
            background-color: #1e3a8a;
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
            background-color: #f3f4f6;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .info-bar table {
            width: 100%;
        }

        .info-bar td {
            padding: 3px 0;
            font-size: 10px;
        }

        .info-bar strong {
            color: #1e3a8a;
        }

        /* Tarjetas de estadísticas */
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .stat-card h3 {
            font-size: 24px;
            margin-bottom: 3px;
            color: #1e3a8a;
        }

        .stat-card p {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
        }

        .stat-card.disponible h3 { color: #10b981; }
        .stat-card.en-uso h3 { color: #3b82f6; }
        .stat-card.mantenimiento h3 { color: #f59e0b; }
        .stat-card.baja h3 { color: #ef4444; }

        /* Tabla principal */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.main-table thead {
            background-color: #1e3a8a;
            color: white;
        }

        table.main-table th {
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
        }

        table.main-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        table.main-table tbody tr:hover {
            background-color: #f3f4f6;
        }

        table.main-table td {
            padding: 8px 6px;
            border-bottom: 1px solid #e5e7eb;
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

        .badge.disponible { background-color: #10b981; }
        .badge.en-uso { background-color: #3b82f6; }
        .badge.mantenimiento { background-color: #f59e0b; }
        .badge.baja { background-color: #ef4444; }
        .badge.categoria { background-color: #6b7280; }

        .code {
            background-color: #f3f4f6;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 9px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #f3f4f6;
            padding: 10px 20px;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            border-top: 2px solid #1e3a8a;
        }

        .page-break {
            page-break-after: always;
        }

        /* Resumen */
        .summary-box {
            background-color: #eff6ff;
            border-left: 4px solid #1e3a8a;
            padding: 12px;
            margin: 15px 0;
        }

        .summary-box h3 {
            font-size: 12px;
            color: #1e3a8a;
            margin-bottom: 8px;
        }

        .summary-box ul {
            margin-left: 20px;
        }

        .summary-box li {
            margin: 3px 0;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📊 Reporte: Equipos por Estado</h1>
        <p>Sistema de Inventario - Distribución de equipos según estado</p>
    </div>

    <!-- Información del reporte -->
    <div class="info-bar">
        <table>
            <tr>
                <td><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i') }}</td>
                <td style="text-align: right;"><strong>Usuario:</strong> {{ auth()->user()->name }}</td>
            </tr>
            <tr>
                <td><strong>Total de equipos:</strong> {{ $equipos->count() }}</td>
                <td style="text-align: right;"><strong>Filtro aplicado:</strong> {{ request('estado') ?? 'Todos' }}</td>
            </tr>
        </table>
    </div>

    <!-- Estadísticas en tarjetas -->
    <div class="stats-grid">
        @foreach($estadisticas as $stat)
            @php
                $clase = match($stat->estado) {
                    'Disponible' => 'disponible',
                    'En Uso' => 'en-uso',
                    'Mantenimiento' => 'mantenimiento',
                    'Dado de Baja' => 'baja',
                    default => ''
                };
                $porcentaje = $equipos->count() > 0 ? ($stat->total / $equipos->count() * 100) : 0;
            @endphp
            <div class="stat-card {{ $clase }}">
                <h3>{{ $stat->total }}</h3>
                <p>{{ $stat->estado }}</p>
                <p style="color: #1e3a8a; font-weight: bold;">{{ number_format($porcentaje, 1) }}%</p>
            </div>
        @endforeach
    </div>

    <!-- Resumen -->
    <div class="summary-box">
        <h3>📋 Resumen del Reporte</h3>
        <ul>
            <li>Total de equipos registrados: <strong>{{ $equipos->count() }}</strong></li>
            <li>Equipos disponibles: <strong>{{ $estadisticas->where('estado', 'Disponible')->first()->total ?? 0 }}</strong></li>
            <li>Equipos en uso: <strong>{{ $estadisticas->where('estado', 'En Uso')->first()->total ?? 0 }}</strong></li>
            <li>Equipos en mantenimiento: <strong>{{ $estadisticas->where('estado', 'Mantenimiento')->first()->total ?? 0 }}</strong></li>
            <li>Equipos dados de baja: <strong>{{ $estadisticas->where('estado', 'Dado de Baja')->first()->total ?? 0 }}</strong></li>
        </ul>
    </div>

    <!-- Tabla de equipos -->
    <h3 style="margin: 20px 0 10px 0; color: #1e3a8a; font-size: 13px;">
        📦 Detalle de Equipos
    </h3>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 12%;">Código</th>
                <th style="width: 25%;">Nombre</th>
                <th style="width: 15%;">Categoría</th>
                <th style="width: 12%;">Estado</th>
                <th style="width: 18%;">Marca/Modelo</th>
                <th style="width: 18%;">Ubicación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos as $equipo)
                <tr>
                    <td>
                        <span class="code">{{ $equipo->codigo }}</span>
                    </td>
                    <td>
                        <strong>{{ $equipo->nombre }}</strong>
                    </td>
                    <td>
                        <span class="badge categoria">
                            {{ $equipo->categoria->nombre }}
                        </span>
                    </td>
                    <td>
                        @php
                            $badgeClass = match($equipo->estado) {
                                'Disponible' => 'disponible',
                                'En Uso' => 'en-uso',
                                'Mantenimiento' => 'mantenimiento',
                                'Dado de Baja' => 'baja',
                                default => ''
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ $equipo->estado }}
                        </span>
                    </td>
                    <td>
                        {{ $equipo->marca ?? 'N/A' }}<br>
                        <span style="color: #6b7280; font-size: 9px;">{{ $equipo->modelo ?? '' }}</span>
                    </td>
                    <td>
                        {{ $equipo->ubicacion ?? 'Sin ubicación' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                        No hay equipos registrados
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Sistema de Inventario &copy; {{ date('Y') }} | 
        Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}
    </div>
</body>
</html>