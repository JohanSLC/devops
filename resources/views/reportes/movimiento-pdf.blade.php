<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimientos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        h1 { text-align: center; font-size: 18px; }
    </style>
</head>
<body>
    <h1>Reporte de Movimientos</h1>
    <table>
        <thead>
            <tr>
                <th>Equipo</th>
                <th>Usuario</th>
                <th>Tipo</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $mov)
            <tr>
                <td>{{ $mov->equipo->nombre ?? 'Sin equipo' }}</td>
                <td>{{ $mov->usuario->name ?? 'Sin usuario' }}</td>
                <td>{{ $mov->tipo }}</td>
                <td>{{ $mov->fecha }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>