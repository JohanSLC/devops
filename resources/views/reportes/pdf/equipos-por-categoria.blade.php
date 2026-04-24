<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte: Equipos por Categoría</title>
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
            background-color: #0ea5e9;
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
            color: #0ea5e9;
        }

        /* Tabla de resumen por categoría */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .summary-table thead {
            background-color: #0ea5e9;
            color: white;
        }

        .summary-table th {
            padding: 8px 6px;
            text-align: center;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid #0ea5e9;
        }

        .summary-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .summary-table td {
            padding: 8px 6px;
            border: 1px solid #e5e7eb;
            font-size: 10px;
            text-align: center;
        }

        .summary-table tfoot {
            background-color: #e0f2fe;
            font-weight: bold;
        }

        .summary-table tfoot td {
            padding: 8px 6px;
            border: 1px solid #0ea5e9;
        }

        /* Tabla de equipos */
        .equipos-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .equipos-table thead {
            background-color: #1e3a8a;
            color: white;
        }

        .equipos-table th {
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
        }

        .equipos-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .equipos-table td {
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

        .badge.primary { background-color: #3b82f6; }
        .badge.success { background-color: #10b981; }
        .badge.info { background-color: #0ea5e9; }
        .badge.warning { background-color: #f59e0b; }
        .badge.danger { background-color: #ef4444; }
        .badge.secondary { background-color: #6b7280; }

        .code {
            background-color: #f3f4f6;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 9px;
        }

        /* Box de resumen */
        .summary-box {
            background-color: #dbeafe;
            border-left: 4px solid #0ea5e9;
            padding: 12px;
            margin: 15px 0;
        }

        .summary-box h3 {
            font-size: 12px;
            color: #0ea5e9;
            margin-bottom: 8px;
        }

        .summary-box .stats-grid {
            display: table;
            width: 100%;
        }

        .summary-box .stat-item {
            display: table-cell;
            width: 25%;
            padding: 5px;
            text-align: center;
        }

        .summary-box .stat-item h4 {
            font-size: 18px;
            color: #0ea5e9;
            margin-bottom: 2px;
        }

        .summary-box .stat-item p {
            font-size: 9px;
            color: #6b7280;
        }

        /* Sección de categoría */
        .categoria-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .categoria-header {
            background-color: #e0f2fe;
            padding: 8px 10px;
            margin-bottom: 8px;
            border-left: 4px solid #0ea5e9;
        }

        .categoria-header h4 {
            font-size: 12px;
            color: #0369a1;
            display: inline-block;
        }

        .categoria-header .stats {
            float: right;
            font-size: 10px;
            color: #6b7280;
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
            border-top: 2px solid #0ea5e9;
        }

        .page-break {
            page-break-after: always;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📊 Reporte: Equipos por Categoría</h1>
        <p>Sistema de Inventario - Análisis de equipos agrupados por categoría</p>
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
                <td style="text-align: right;"><strong>Total de categorías:</strong> {{ $detallesCategorias->count() }}</td>
            </tr>
        </table>
    </div>

    <!-- Resumen ejecutivo -->
    <div class="summary-box">
        <h3>📋 Resumen Ejecutivo</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <h4>{{ $detallesCategorias->count() }}</h4>
                <p>CATEGORÍAS</p>
            </div>
            <div class="stat-item">
                <h4>{{ $detallesCategorias->sum('total') }}</h4>
                <p>TOTAL EQUIPOS</p>
            </div>
            <div class="stat-item">
                <h4>{{ $detallesCategorias->sum('disponibles') }}</h4>
                <p>DISPONIBLES</p>
            </div>
            <div class="stat-item">
                <h4>{{ $detallesCategorias->sum('mantenimiento') }}</h4>
                <p>MANTENIMIENTO</p>
            </div>
        </div>
    </div>

    <!-- Tabla resumen por categoría -->
    <h3 style="margin: 20px 0 10px 0; color: #0ea5e9; font-size: 13px;">
        📊 Análisis por Categoría
    </h3>

    <table class="summary-table">
        <thead>
            <tr>
                <th style="text-align: left;">Categoría</th>
                <th>Total</th>
                <th>Disponibles</th>
                <th>En Uso</th>
                <th>Mantenimiento</th>
                <th>Dados de Baja</th>
                <th>% del Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalGeneral = $detallesCategorias->sum('total');
            @endphp
            @foreach($detallesCategorias as $detalle)
                <tr>
                    <td style="text-align: left;">
                        <strong>{{ $detalle['nombre'] }}</strong>
                    </td>
                    <td>
                        <span class="badge primary">{{ $detalle['total'] }}</span>
                    </td>
                    <td>
                        <span class="badge success">{{ $detalle['disponibles'] }}</span>
                    </td>
                    <td>
                        <span class="badge info">{{ $detalle['en_uso'] }}</span>
                    </td>
                    <td>
                        <span class="badge warning">{{ $detalle['mantenimiento'] }}</span>
                    </td>
                    <td>
                        <span class="badge danger">{{ $detalle['baja'] }}</span>
                    </td>
                    <td>
                        @php
                            $porcentaje = $totalGeneral > 0 ? ($detalle['total'] / $totalGeneral * 100) : 0;
                        @endphp
                        <strong>{{ number_format($porcentaje, 1) }}%</strong>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="text-align: left;">TOTAL</td>
                <td>{{ $totalGeneral }}</td>
                <td>{{ $detallesCategorias->sum('disponibles') }}</td>
                <td>{{ $detallesCategorias->sum('en_uso') }}</td>
                <td>{{ $detallesCategorias->sum('mantenimiento') }}</td>
                <td>{{ $detallesCategorias->sum('baja') }}</td>
                <td>100%</td>
            </tr>
        </tfoot>
    </table>

    <div class="page-break"></div>

    <!-- Listado detallado de equipos -->
    <h3 style="margin: 20px 0 10px 0; color: #0ea5e9; font-size: 13px;">
        📦 Listado Detallado de Equipos
    </h3>

    <table class="equipos-table">
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
                        <span class="badge secondary">
                            {{ $equipo->categoria->nombre }}
                        </span>
                    </td>
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