<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte: Valor del Inventario</title>
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
            background-color: #f59e0b;
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
            background-color: #fef3c7;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border-left: 4px solid #f59e0b;
        }

        .info-bar table {
            width: 100%;
        }

        .info-bar td {
            padding: 3px 0;
            font-size: 10px;
        }

        .info-bar strong {
            color: #d97706;
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
            padding: 12px;
            text-align: center;
            border: 2px solid #e5e7eb;
            background-color: #fff;
        }

        .stat-card h4 {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .stat-card h2 {
            font-size: 20px;
            margin-bottom: 3px;
            color: #f59e0b;
            font-weight: bold;
        }

        .stat-card p {
            font-size: 9px;
            color: #9ca3af;
        }

        .stat-card.total { border-color: #3b82f6; }
        .stat-card.total h2 { color: #3b82f6; }
        
        .stat-card.promedio { border-color: #10b981; }
        .stat-card.promedio h2 { color: #10b981; }
        
        .stat-card.maximo { border-color: #ef4444; }
        .stat-card.maximo h2 { color: #ef4444; }
        
        .stat-card.minimo { border-color: #0ea5e9; }
        .stat-card.minimo h2 { color: #0ea5e9; }

        /* Tablas */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table thead {
            background-color: #f59e0b;
            color: white;
        }

        .table th {
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid #f59e0b;
        }

        .table th.text-center { text-align: center; }
        .table th.text-end { text-align: right; }

        .table tbody tr:nth-child(even) {
            background-color: #fef3c7;
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
        .table td.text-end { text-align: right; }

        .table tfoot {
            background-color: #fed7aa;
            font-weight: bold;
        }

        .table tfoot td {
            padding: 8px 6px;
            border: 1px solid #f59e0b;
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

        /* Barra de progreso */
        .progress-bar {
            background-color: #e5e7eb;
            height: 12px;
            border-radius: 3px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            background-color: #f59e0b;
            height: 100%;
            display: inline-block;
        }

        .progress-text {
            position: absolute;
            width: 100%;
            text-align: center;
            line-height: 12px;
            font-size: 8px;
            font-weight: bold;
            color: #fff;
            top: 0;
        }

        /* Resumen ejecutivo */
        .summary-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            margin: 15px 0;
        }

        .summary-box h3 {
            font-size: 12px;
            color: #d97706;
            margin-bottom: 8px;
        }

        .summary-box ul {
            margin-left: 20px;
        }

        .summary-box li {
            margin: 3px 0;
            font-size: 10px;
        }

        /* Secciones */
        h3.section-title {
            margin: 20px 0 10px 0;
            color: #f59e0b;
            font-size: 13px;
            border-bottom: 2px solid #f59e0b;
            padding-bottom: 5px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #fef3c7;
            padding: 10px 20px;
            text-align: center;
            font-size: 9px;
            color: #92400e;
            border-top: 2px solid #f59e0b;
        }

        .page-break {
            page-break-after: always;
        }

        .text-right {
            text-align: right;
        }

        .icon {
            font-weight: bold;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>💰 Reporte: Valor del Inventario</h1>
        <p>Sistema de Inventario - Valorización total y análisis financiero</p>
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
                <td style="text-align: right;">
                    <strong>Filtros aplicados:</strong> 
                    @if(request('categoria_id') || request('estado'))
                        {{ request('categoria_id') ? 'Categoría, ' : '' }}{{ request('estado') ?? 'Todos' }}
                    @else
                        Ninguno
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Estadísticas principales -->
    <div class="stats-grid">
        <div class="stat-card total">
            <h4>Valor Total</h4>
            <h2>S/. {{ number_format($estadisticas['valor_total'], 2) }}</h2>
            <p>{{ $estadisticas['total_equipos'] }} equipos</p>
        </div>
        <div class="stat-card promedio">
            <h4>Valor Promedio</h4>
            <h2>S/. {{ number_format($estadisticas['valor_promedio'], 2) }}</h2>
            <p>Por equipo</p>
        </div>
        <div class="stat-card maximo">
            <h4>Valor Máximo</h4>
            <h2>S/. {{ number_format($estadisticas['valor_maximo'], 2) }}</h2>
            <p>Equipo más caro</p>
        </div>
        <div class="stat-card minimo">
            <h4>Valor Mínimo</h4>
            <h2>S/. {{ number_format($estadisticas['valor_minimo'], 2) }}</h2>
            <p>Equipo más económico</p>
        </div>
    </div>

    <!-- Resumen ejecutivo -->
    <div class="summary-box">
        <h3>📋 Resumen Ejecutivo</h3>
        <ul>
            <li>Valor total del inventario: <strong>S/. {{ number_format($estadisticas['valor_total'], 2) }}</strong></li>
            <li>Equipos valorizados: <strong>{{ $estadisticas['total_equipos'] }} unidades</strong></li>
            <li>Valor promedio por equipo: <strong>S/. {{ number_format($estadisticas['valor_promedio'], 2) }}</strong></li>
            <li>Rango de precios: <strong>S/. {{ number_format($estadisticas['valor_minimo'], 2) }} - S/. {{ number_format($estadisticas['valor_maximo'], 2) }}</strong></li>
        </ul>
    </div>

    <!-- Valorización por Categoría -->
    <h3 class="section-title">📊 Valorización por Categoría</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Categoría</th>
                <th class="text-center">Cantidad</th>
                <th class="text-end">Valor Total</th>
                <th class="text-end">Valor Promedio</th>
                <th class="text-center">% del Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $valorTotalGeneral = $valorPorCategoria->sum('valor');
            @endphp
            @forelse($valorPorCategoria as $item)
                <tr>
                    <td>
                        <strong>{{ $item['nombre'] }}</strong>
                    </td>
                    <td class="text-center">
                        <span class="badge primary">{{ $item['cantidad'] }}</span>
                    </td>
                    <td class="text-end">
                        <strong>S/. {{ number_format($item['valor'], 2) }}</strong>
                    </td>
                    <td class="text-end">
                        S/. {{ number_format($item['cantidad'] > 0 ? $item['valor'] / $item['cantidad'] : 0, 2) }}
                    </td>
                    <td class="text-center">
                        @php
                            $porcentaje = $valorTotalGeneral > 0 ? ($item['valor'] / $valorTotalGeneral * 100) : 0;
                        @endphp
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $porcentaje }}%"></div>
                            <div class="progress-text">{{ number_format($porcentaje, 1) }}%</div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">
                        No hay datos de valorización por categoría
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td>TOTAL</td>
                <td class="text-center">{{ $valorPorCategoria->sum('cantidad') }}</td>
                <td class="text-end">S/. {{ number_format($valorTotalGeneral, 2) }}</td>
                <td class="text-end">-</td>
                <td class="text-center">100%</td>
            </tr>
        </tfoot>
    </table>

    <!-- Valorización por Estado -->
    <h3 class="section-title">📊 Valorización por Estado</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Estado</th>
                <th class="text-end">Valor Total</th>
                <th class="text-center">% del Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $valorTotalEstado = $valorPorEstado->sum();
            @endphp
            @forelse($valorPorEstado as $estado => $valor)
                <tr>
                    <td>
                        @php
                            $badgeClass = match($estado) {
                                'Disponible' => 'success',
                                'En Uso' => 'info',
                                'Mantenimiento' => 'warning',
                                'Dado de Baja' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $estado }}</span>
                    </td>
                    <td class="text-end">
                        <strong>S/. {{ number_format($valor, 2) }}</strong>
                    </td>
                    <td class="text-center">
                        @php
                            $porcentaje = $valorTotalEstado > 0 ? ($valor / $valorTotalEstado * 100) : 0;
                        @endphp
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $porcentaje }}%"></div>
                            <div class="progress-text">{{ number_format($porcentaje, 1) }}%</div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 20px;">
                        No hay datos de valorización por estado
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td>TOTAL</td>
                <td class="text-end">S/. {{ number_format($valorTotalEstado, 2) }}</td>
                <td class="text-center">100%</td>
            </tr>
        </tfoot>
    </table>

    <div class="page-break"></div>

    <!-- Listado detallado de equipos -->
    <h3 class="section-title">📦 Detalle de Equipos Valorizados</h3>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 12%;">Código</th>
                <th style="width: 28%;">Nombre</th>
                <th style="width: 15%;">Categoría</th>
                <th style="width: 12%;">Estado</th>
                <th class="text-end" style="width: 15%;">Precio</th>
                <th style="width: 18%;">Fecha Adq.</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos->sortByDesc('precio_adquisicion') as $equipo)
                <tr>
                    <td>
                        <span class="code">{{ $equipo->codigo }}</span>
                    </td>
                    <td>
                        <strong>{{ $equipo->nombre }}</strong>
                        @if($equipo->marca)
                            <br><span style="color: #6b7280; font-size: 9px;">{{ $equipo->marca }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge secondary">{{ $equipo->categoria->nombre }}</span>
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
                        <span class="badge {{ $badgeClass }}">{{ $equipo->estado }}</span>
                    </td>
                    <td class="text-end">
                        <strong>S/. {{ number_format($equipo->precio_adquisicion, 2) }}</strong>
                    </td>
                    <td>
                        {{ $equipo->fecha_adquisicion ? $equipo->fecha_adquisicion->format('d/m/Y') : 'N/A' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                        No hay equipos con precio de adquisición registrado
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