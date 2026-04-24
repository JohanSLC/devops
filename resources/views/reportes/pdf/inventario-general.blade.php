<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario General</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 10px; color: #333; }
        
        .header {
            background-color: #1e3a8a;
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
        .stat-card h3 { font-size: 18px; color: #1e3a8a; margin-bottom: 2px; }
        .stat-card p { font-size: 8px; color: #6b7280; }
        
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.main-table thead {
            background-color: #1e3a8a;
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
            background-color: #dbeafe;
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
        .badge.success { background-color: #10b981; }
        .badge.info { background-color: #3b82f6; }
        .badge.warning { background-color: #f59e0b; }
        .badge.danger { background-color: #ef4444; }
        .badge.secondary { background-color: #6b7280; }
        
        .code {
            background-color: #f3f4f6;
            padding: 2px 4px;
            border-radius: 2px;
            font-family: 'Courier New', monospace;
            font-size: 8px;
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
            border-top: 2px solid #1e3a8a;
        }
        
        .text-end { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📦 Inventario General</h1>
        <p>Listado completo de equipos del sistema</p>
    </div>

    <div class="info-bar">
        <table>
            <tr>
                <td><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}</td>
                <td class="text-end"><strong>Usuario:</strong> {{ auth()->user()->name }}</td>
            </tr>
            <tr>
                <td><strong>Total equipos:</strong> {{ $equipos->count() }}</td>
                <td class="text-end"><strong>Filtros:</strong> {{ request('categoria_id') || request('estado') ? 'Aplicados' : 'Ninguno' }}</td>
            </tr>
        </table>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ $equipos->count() }}</h3>
            <p>Total Equipos</p>
        </div>
        <div class="stat-card">
            <h3>{{ $equipos->where('estado', 'Disponible')->count() }}</h3>
            <p>Disponibles</p>
        </div>
        <div class="stat-card">
            <h3>{{ $equipos->where('estado', 'En Uso')->count() }}</h3>
            <p>En Uso</p>
        </div>
        <div class="stat-card">
            <h3>{{ $equipos->where('estado', 'Mantenimiento')->count() }}</h3>
            <p>Mantenimiento</p>
        </div>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 10%;">Código</th>
                <th style="width: 22%;">Nombre</th>
                <th style="width: 12%;">Categoría</th>
                <th style="width: 10%;">Estado</th>
                <th style="width: 15%;">Marca/Modelo</th>
                <th style="width: 12%;">Ubicación</th>
                <th style="width: 12%;" class="text-end">Precio</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos as $equipo)
                <tr>
                    <td><span class="code">{{ $equipo->codigo }}</span></td>
                    <td><strong>{{ $equipo->nombre }}</strong></td>
                    <td><span class="badge secondary">{{ $equipo->categoria->nombre }}</span></td>
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
                    <td>
                        {{ $equipo->marca ?? 'N/A' }}
                        @if($equipo->modelo)<br><span style="font-size: 8px; color: #6b7280;">{{ $equipo->modelo }}</span>@endif
                    </td>
                    <td>{{ $equipo->ubicacion ?? '-' }}</td>
                    <td class="text-end">
                        @if($equipo->precio_adquisicion)
                            <strong>S/. {{ number_format($equipo->precio_adquisicion, 2) }}</strong>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 30px;">No hay equipos</td>
                </tr>
            @endforelse
        </tbody>
        @if($equipos->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="6" class="text-end">TOTAL:</td>
                    <td class="text-end">S/. {{ number_format($equipos->sum('precio_adquisicion'), 2) }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer">
        Sistema de Inventario © {{ date('Y') }} | Generado: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>