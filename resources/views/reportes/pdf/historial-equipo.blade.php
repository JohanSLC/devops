<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Equipo</title>
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
            background-color: #8B5CF6;
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
            color: #8B5CF6;
        }

        /* Información del equipo */
        .equipo-info {
            background-color: #f9fafb;
            border-left: 4px solid #8B5CF6;
            padding: 15px;
            margin-bottom: 20px;
        }

        .equipo-info h2 {
            font-size: 16px;
            color: #8B5CF6;
            margin-bottom: 10px;
        }

        .equipo-info table {
            width: 100%;
        }

        .equipo-info td {
            padding: 5px 0;
            font-size: 10px;
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
            color: #8B5CF6;
        }

        .stat-card p {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
        }

        /* Timeline */
        .timeline-item {
            margin-bottom: 15px;
            padding-left: 30px;
            position: relative;
            page-break-inside: avoid;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: -15px;
            width: 2px;
            background-color: #e5e7eb;
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-marker {
            position: absolute;
            left: 0;
            top: 5px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #e5e7eb;
        }

        .timeline-marker.movimiento { background-color: #3b82f6; }
        .timeline-marker.mantenimiento { background-color: #f59e0b; }

        .timeline-content {
            background-color: #f9fafb;
            padding: 10px;
            border-radius: 4px;
            border-left: 3px solid #8B5CF6;
        }

        .timeline-content .tipo {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 600;
            color: white;
            margin-bottom: 5px;
        }

        .tipo.movimiento { background-color: #3b82f6; }
        .tipo.mantenimiento { background-color: #f59e0b; }

        .timeline-content h4 {
            font-size: 11px;
            margin-bottom: 3px;
            color: #1f2937;
        }

        .timeline-content p {
            font-size: 10px;
            color: #6b7280;
            margin: 3px 0;
        }

        .timeline-content .meta {
            font-size: 9px;
            color: #9ca3af;
            margin-top: 5px;
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

        .badge.success { background-color: #10b981; }
        .badge.info { background-color: #0ea5e9; }
        .badge.warning { background-color: #f59e0b; }
        .badge.danger { background-color: #ef4444; }
        .badge.secondary { background-color: #6b7280; }
        .badge.purple { background-color: #8B5CF6; }

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
            border-top: 2px solid #8B5CF6;
        }

        .page-break {
            page-break-after: always;
        }

        h3.section-title {
            margin: 20px 0 10px 0;
            color: #8B5CF6;
            font-size: 13px;
            border-bottom: 2px solid #8B5CF6;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>⏱️ Historial de Equipo</h1>
        <p>Sistema de Inventario - Línea de tiempo completa de eventos</p>
    </div>

    <!-- Información del reporte -->
    <div class="info-bar">
        <table>
            <tr>
                <td><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i') }}</td>
                <td style="text-align: right;"><strong>Usuario:</strong> {{ auth()->user()->name }}</td>
            </tr>
            <tr>
                <td><strong>Equipo:</strong> {{ $equipo->codigo }} - {{ $equipo->nombre }}</td>
                <td style="text-align: right;"><strong>Estado:</strong> {{ $equipo->estado }}</td>
            </tr>
        </table>
    </div>

    <!-- Información del equipo -->
    <div class="equipo-info">
        <h2>📦 Información del Equipo</h2>
        <table>
            <tr>
                <td style="width: 25%;"><strong>Código:</strong></td>
                <td style="width: 25%;">{{ $equipo->codigo }}</td>
                <td style="width: 25%;"><strong>Categoría:</strong></td>
                <td style="width: 25%;">{{ $equipo->categoria->nombre }}</td>
            </tr>
            <tr>
                <td><strong>Nombre:</strong></td>
                <td colspan="3">{{ $equipo->nombre }}</td>
            </tr>
            <tr>
                <td><strong>Marca/Modelo:</strong></td>
                <td>{{ $equipo->marca ?? 'N/A' }} {{ $equipo->modelo ?? '' }}</td>
                <td><strong>Serie:</strong></td>
                <td>{{ $equipo->serie ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Estado:</strong></td>
                <td>
                    @php
                        $badgeClass = match($equipo->estado) {
                            'Disponible' => 'success',
                            'En Uso' => 'info',
                            'Mantenimiento' => 'warning',
                            'Dado de Baja' => 'danger',
                            default => 'secondary'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $equipo->estado }}</span>
                </td>
                <td><strong>Ubicación:</strong></td>
                <td>{{ $equipo->ubicacion ?? 'No especificada' }}</td>
            </tr>
        </table>
    </div>

    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ $estadisticas['total_movimientos'] }}</h3>
            <p>Movimientos</p>
        </div>
        <div class="stat-card">
            <h3>{{ $estadisticas['total_mantenimientos'] }}</h3>
            <p>Mantenimientos</p>
        </div>
        <div class="stat-card">
            <h3>S/. {{ number_format($estadisticas['costo_mantenimientos'], 2) }}</h3>
            <p>Costo Total</p>
        </div>
        <div class="stat-card">
            <h3>
                @if($estadisticas['ultimo_movimiento'])
                    {{ \Carbon\Carbon::parse($estadisticas['ultimo_movimiento'])->format('d/m/Y') }}
                @else
                    Sin datos
                @endif
            </h3>
            <p>Última Actividad</p>
        </div>
    </div>

    <!-- Línea de tiempo -->
    <h3 class="section-title">📅 Línea de Tiempo de Eventos</h3>

    @if($historial->count() > 0)
        @foreach($historial as $evento)
            <div class="timeline-item">
                <div class="timeline-marker {{ $evento['tipo'] }}"></div>
                <div class="timeline-content">
                    <span class="tipo {{ $evento['tipo'] }}">{{ strtoupper($evento['tipo']) }}</span>
                    <h4>{{ $evento['descripcion'] }}</h4>
                    <p>{{ $evento['detalle'] }}</p>
                    <div class="meta">
                        📅 {{ \Carbon\Carbon::parse($evento['fecha'])->format('d/m/Y') }} | 
                        👤 {{ $evento['usuario'] }}
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p style="text-align: center; padding: 30px; color: #6b7280;">
            No hay eventos registrados en el historial de este equipo
        </p>
    @endif

    <!-- Footer -->
    <div class="footer">
        Sistema de Inventario &copy; {{ date('Y') }} | 
        Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}
    </div>
</body>
</html>