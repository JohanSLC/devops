<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Mantenimientos</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 10px; color: #333; }
        
        .header {
            background-color: #374151;
            color: white;
            padding: 15px;
            margin-bottom: 15px;
        }
        .header h1 { font-size: 18px; margin-bottom: 3px; }
        .header p { font-size: 10px; opacity: 0.9; }
        
        .info-bar {
            background-color: #f3f4f6;
            padding: 8px;
            margin-bottom: 12px;
            border-radius: 3px;
        }
        .info-bar table { width: 100%; }
        .info-bar td { padding: 2px 0; font-size: 9px; }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }
        .stat-card h3 { font-size: 18px; color: #374151; margin-bottom: 2px; }
        .stat-card p { font-size: 8px; color: #6b7280; }
        
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.main-table thead {
            background-color: #374151;
            color: white;
        }
        table.main-table th {
            padding: 6px 4px;
            font-size: 9px;
            font-weight: 600;
            text-align: left;
        }
        table.main-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        table.main-table td {
            padding: 6px 4px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 9px;
        }
        table.main-table tfoot {
            background-color: #e5e7eb;
            font-weight: bold;
        }
        table.main-table tfoot td {
            padding: 6px 4px;
            font-size: 10px;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: 600;
            color: white;
        }
        .badge.primary { background-color: #3b82f6; }
        .badge.info { background-color: #0ea5e9; }
        .badge.warning { background-color: #f59e0b; }
        .badge.success { background-color: #10b981; }
        .badge.danger { background-color: #ef4444; }
        .badge.secondary { background-color: #6b7280; }
        
        .code {
            background-color: #f3f4f6;
            padding: 2px 4px;
            border-radius: 2px;
            font-family: 'Courier New', monospace;
            font-size: 8px;
        }
        
        .summary-section {
            margin-top: 15px;
            page-break-inside: avoid;
        }
        
        .summary-section h3 {
            font-size: 11px;
            color: #374151;
            margin-bottom: 8px;
            border-bottom: 2px solid #374151;
            padding-bottom: 3px;
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        
        .summary-table td {
            padding: 5px;
            border: 1px solid #e5e7eb;
            font-size: 9px;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #f3f4f6;
            padding: 8px 15px;
            text-align: center;
            font-size: 8px;
            color: #6b7280;
            border-top: 2px solid #374151;
        }
        
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔧 Reporte de Mantenimientos</h1>
        <p>Historial de mantenimientos preventivos y correctivos</p>
    </div>

    <div class="info-bar">
        <table>
            <tr>
                <td><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}</td>
                <td class="text-end"><strong>Usuario:</strong> {{ auth()->user()->name }}</td>
            </tr>
            <tr>
                <td><strong>Total mantenimientos:</strong> {{ $mantenimientos->count() }}</td>
                <td class="text-end"><strong>Período:</strong> {{ request('fecha_inicio') && request('fecha_fin') ? 'Filtrado' : 'Todos' }}</td>
            </tr>
        </table>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ $mantenimientos->count() }}</h3>
            <p>Total</p>
        </div>
        <div class="stat-card">
            <h3>{{ $mantenimientos->where('estado', 'Pendiente')->count() }}</h3>
            <p>Pendientes</p>
        </div>
        <div class="stat-card">
            <h3>{{ $mantenimientos->where('estado', 'Completado')->count() }}</h3>
            <p>Completados</p>
        </div>
        <div class="stat-card">
            <h3>S/. {{ number_format($mantenimientos->sum('costo'), 2) }}</h3>
            <p>Costo Total</p>
        </div>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 18%;">Equipo</th>
                <th style="width: 10%;">Tipo</th>
                <th style="width: 30%;">Descripción</th>
                <th style="width: 10%;">Estado</th>
                <th style="width: 10%;">Fecha Prog.</th>
                <th style="width: 12%;">Técnico</th>
                <th style="width: 10%;" class="text-end">Costo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mantenimientos as $mantenimiento)
                <tr>
                    <td>
                        <strong>{{ $mantenimiento->equipo->nombre }}</strong><br>
                        <span class="code">{{ $mantenimiento->equipo->codigo }}</span>
                    </td>
                    <td>
                        @php
                            $tipoBadge = match($mantenimiento->tipo) {
                                'Preventivo' => 'info',
                                'Correctivo' => 'warning',
                                'Predictivo' => 'primary',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge {{ $tipoBadge }}">{{ $mantenimiento->tipo }}</span>
                    </td>
                    <td style="font-size: 8px;">
                        {{ strlen($mantenimiento->descripcion) > 80 ? substr($mantenimiento->descripcion, 0, 80) . '...' : $mantenimiento->descripcion }}
                    </td>
                    <td>
                        @php
                            $estadoBadge = match($mantenimiento->estado) {
                                'Pendiente' => 'warning',
                                'En Proceso' => 'info',
                                'Completado' => 'success',
                                'Cancelado' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge {{ $estadoBadge }}">{{ $mantenimiento->estado }}</span>
                    </td>
                    <td>
                        {{ $mantenimiento->fecha_programada ? \Carbon\Carbon::parse($mantenimiento->fecha_programada)->format('d/m/Y') : '-' }}
                    </td>
                    <td>{{ $mantenimiento->tecnico ?? 'No asignado' }}</td>
                    <td class="text-end">
                        @if($mantenimiento->costo)
                            <strong>S/. {{ number_format($mantenimiento->costo, 2) }}</strong>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 30px;">No hay mantenimientos</td>
                </tr>
            @endforelse
        </tbody>
        @if($mantenimientos->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="6" class="text-end">TOTAL:</td>
                    <td class="text-end">S/. {{ number_format($mantenimientos->sum('costo'), 2) }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    @if($mantenimientos->count() > 0)
        <div class="summary-section">
            <h3>📊 Resumen por Tipo</h3>
            <table class="summary-table">
                <tr>
                    <td style="width: 40%;"><span class="badge info">Preventivo</span></td>
                    <td style="width: 30%;" class="text-center">{{ $mantenimientos->where('tipo', 'Preventivo')->count() }} mantenimientos</td>
                    <td style="width: 30%;" class="text-end"><strong>S/. {{ number_format($mantenimientos->where('tipo', 'Preventivo')->sum('costo'), 2) }}</strong></td>
                </tr>
                <tr>
                    <td><span class="badge warning">Correctivo</span></td>
                    <td class="text-center">{{ $mantenimientos->where('tipo', 'Correctivo')->count() }} mantenimientos</td>
                    <td class="text-end"><strong>S/. {{ number_format($mantenimientos->where('tipo', 'Correctivo')->sum('costo'), 2) }}</strong></td>
                </tr>
                <tr>
                    <td><span class="badge primary">Predictivo</span></td>
                    <td class="text-center">{{ $mantenimientos->where('tipo', 'Predictivo')->count() }} mantenimientos</td>
                    <td class="text-end"><strong>S/. {{ number_format($mantenimientos->where('tipo', 'Predictivo')->sum('costo'), 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="summary-section">
            <h3>📈 Resumen por Estado</h3>
            <table class="summary-table">
                <tr>
                    <td style="width: 50%;"><span class="badge warning">Pendiente</span></td>
                    <td style="width: 50%;" class="text-end">{{ $mantenimientos->where('estado', 'Pendiente')->count() }} mantenimientos</td>
                </tr>
                <tr>
                    <td><span class="badge info">En Proceso</span></td>
                    <td class="text-end">{{ $mantenimientos->where('estado', 'En Proceso')->count() }} mantenimientos</td>
                </tr>
                <tr>
                    <td><span class="badge success">Completado</span></td>
                    <td class="text-end">{{ $mantenimientos->where('estado', 'Completado')->count() }} mantenimientos</td>
                </tr>
                <tr>
                    <td><span class="badge danger">Cancelado</span></td>
                    <td class="text-end">{{ $mantenimientos->where('estado', 'Cancelado')->count() }} mantenimientos</td>
                </tr>
            </table>
        </div>
    @endif

    <div class="footer">
        Sistema de Inventario © {{ date('Y') }} | Generado: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>