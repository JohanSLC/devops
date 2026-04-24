<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mantenimientos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        h1 { text-align: center; font-size: 18px; }
    </style>
</head>
<body>
    <h1>Reporte de Mantenimientos</h1>
    <table>
        <thead>
            <tr>
                <th>Equipo</th>
                <th>Usuario</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Fecha Programada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mantenimientos as $m)
            <tr>
                <td>{{ $m->equipo->nombre ?? 'Sin equipo' }}</td>
                <td>{{ $m->usuario->name ?? 'Sin usuario' }}</td>
                <td>{{ $m->tipo }}</td>
                <td>{{ $m->estado }}</td>
                <td>{{ $m->fecha_programada }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>