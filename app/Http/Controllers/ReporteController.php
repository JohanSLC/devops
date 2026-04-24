<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Categoria;
use App\Models\Movimiento;
use App\Models\Mantenimiento;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    // Vista principal de reportes
    public function index()
    {
        $categorias = Categoria::all();
        $equipos = Equipo::all();
        
        return view('reportes.index', compact('categorias', 'equipos'));
    }

    // ==================== REPORTE: INVENTARIO GENERAL ====================
    public function inventarioGeneral(Request $request)
    {
        $query = Equipo::with('categoria');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $equipos = $query->get();
        $categorias = Categoria::all();

        // Exportar PDF
        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.inventario-general', compact('equipos'));
            return $pdf->download('inventario-general-' . now()->format('Y-m-d') . '.pdf');
        }

        // Exportar Excel (necesitarás crear el Export)
        if ($request->formato === 'excel') {
            // return Excel::download(new EquiposExport($equipos), 'inventario-general.xlsx');
        }

        return view('reportes.inventario-general', compact('equipos', 'categorias'));
    }

    // ==================== REPORTE: EQUIPOS POR ESTADO ====================
    public function equiposPorEstado(Request $request)
    {
        // Obtener conteo por estado
        $estadisticas = Equipo::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();

        // Obtener equipos con filtro opcional
        $query = Equipo::with('categoria');
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $equipos = $query->orderBy('estado')->get();

        // Preparar datos para gráfico
        $chartData = [
            'labels' => $estadisticas->pluck('estado')->toArray(),
            'data' => $estadisticas->pluck('total')->toArray(),
            'colors' => [
                'Disponible' => '#10B981',
                'En Uso' => '#3B82F6',
                'Mantenimiento' => '#F59E0B',
                'Dado de Baja' => '#EF4444'
            ]
        ];

        // Exportar PDF
        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.equipos-por-estado', compact('equipos', 'estadisticas'));
            return $pdf->download('equipos-por-estado-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('reportes.equipos-por-estado', compact('equipos', 'estadisticas', 'chartData'));
    }

    // ==================== REPORTE: EQUIPOS POR CATEGORÍA ====================
    public function equiposPorCategoria(Request $request)
    {
        // Estadísticas por categoría
        $categorias = Categoria::withCount(['equipos' => function($query) use ($request) {
                if ($request->filled('estado')) {
                    $query->where('estado', $request->estado);
                }
            }])
            ->having('equipos_count', '>', 0)
            ->get();

        // Equipos detallados
        $query = Equipo::with('categoria');
        
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $equipos = $query->orderBy('categoria_id')->get();

        // Datos para gráfico
        $chartData = [
            'labels' => $categorias->pluck('nombre')->toArray(),
            'data' => $categorias->pluck('equipos_count')->toArray()
        ];

        // Estadísticas adicionales por categoría
        $detallesCategorias = Categoria::with('equipos')
            ->get()
            ->map(function($categoria) {
                return [
                    'nombre' => $categoria->nombre,
                    'total' => $categoria->equipos->count(),
                    'disponibles' => $categoria->equipos->where('estado', 'Disponible')->count(),
                    'en_uso' => $categoria->equipos->where('estado', 'En Uso')->count(),
                    'mantenimiento' => $categoria->equipos->where('estado', 'Mantenimiento')->count(),
                    'baja' => $categoria->equipos->where('estado', 'Dado de Baja')->count(),
                ];
            });

        // Exportar PDF
        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.equipos-por-categoria', 
                compact('categorias', 'equipos', 'detallesCategorias'));
            return $pdf->download('equipos-por-categoria-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('reportes.equipos-por-categoria', 
            compact('categorias', 'equipos', 'chartData', 'detallesCategorias'));
    }

    // ==================== REPORTE: VALOR DEL INVENTARIO ====================
    public function valorInventario(Request $request)
    {
        $query = Equipo::with('categoria');

        // Filtros
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_adquisicion', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_adquisicion', '<=', $request->fecha_hasta);
        }

        $equipos = $query->whereNotNull('precio_adquisicion')->get();

        // Calcular totales
        $valorTotal = $equipos->sum('precio_adquisicion');
        $valorPorEstado = $equipos->groupBy('estado')->map(function($items) {
            return $items->sum('precio_adquisicion');
        });

        // Valor por categoría
        $valorPorCategoria = Categoria::with(['equipos' => function($query) use ($request) {
                $query->whereNotNull('precio_adquisicion');
                if ($request->filled('estado')) {
                    $query->where('estado', $request->estado);
                }
            }])
            ->get()
            ->map(function($categoria) {
                return [
                    'nombre' => $categoria->nombre,
                    'cantidad' => $categoria->equipos->count(),
                    'valor' => $categoria->equipos->sum('precio_adquisicion')
                ];
            })
            ->filter(function($item) {
                return $item['cantidad'] > 0;
            });

        // Estadísticas
        $estadisticas = [
            'total_equipos' => $equipos->count(),
            'valor_total' => $valorTotal,
            'valor_promedio' => $equipos->count() > 0 ? $valorTotal / $equipos->count() : 0,
            'valor_minimo' => $equipos->min('precio_adquisicion') ?? 0,
            'valor_maximo' => $equipos->max('precio_adquisicion') ?? 0,
        ];

        // Datos para gráficos
        $chartData = [
            'categorias' => [
                'labels' => $valorPorCategoria->pluck('nombre')->toArray(),
                'data' => $valorPorCategoria->pluck('valor')->toArray()
            ],
            'estados' => [
                'labels' => $valorPorEstado->keys()->toArray(),
                'data' => $valorPorEstado->values()->toArray()
            ]
        ];

        $categorias = Categoria::all();

        // Exportar PDF
        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.valor-inventario', 
                compact('equipos', 'estadisticas', 'valorPorCategoria', 'valorPorEstado'));
            return $pdf->download('valor-inventario-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('reportes.valor-inventario', 
            compact('equipos', 'estadisticas', 'valorPorCategoria', 'valorPorEstado', 'chartData', 'categorias'));
    }

    // ==================== REPORTE: HISTORIAL DE EQUIPO ====================
    public function historialEquipo(Request $request, $equipoId = null)
    {
        if ($equipoId) {
            $equipo = Equipo::with([
                'categoria',
                'movimientos' => function($query) {
                    $query->with('usuario')->orderBy('fecha', 'desc');
                },
                'mantenimientos' => function($query) {
                    $query->orderBy('fecha_programada', 'desc');
                }
            ])->findOrFail($equipoId);

            // Línea de tiempo combinada
            $historial = collect()
                ->merge($equipo->movimientos->map(function($mov) {
                    return [
                        'tipo' => 'movimiento',
                        'fecha' => $mov->fecha,
                        'descripcion' => "Movimiento: {$mov->tipo}",
                        'detalle' => $mov->motivo ?? $mov->observaciones,
                        'usuario' => $mov->usuario->name ?? 'N/A',
                        'icono' => $this->getMovimientoIcon($mov->tipo),
                        'color' => $this->getMovimientoColor($mov->tipo)
                    ];
                }))
                ->merge($equipo->mantenimientos->map(function($mant) {
                    return [
                        'tipo' => 'mantenimiento',
                        'fecha' => $mant->fecha_programada,
                        'descripcion' => "Mantenimiento: {$mant->tipo}",
                        'detalle' => $mant->descripcion,
                        'usuario' => $mant->tecnico ?? 'N/A',
                        'icono' => 'wrench',
                        'color' => $this->getMantenimientoColor($mant->estado)
                    ];
                }))
                ->sortByDesc('fecha')
                ->values();

            // Estadísticas del equipo
            $estadisticas = [
                'total_movimientos' => $equipo->movimientos->count(),
                'total_mantenimientos' => $equipo->mantenimientos->count(),
                'costo_mantenimientos' => $equipo->mantenimientos->sum('costo'),
                'ultimo_movimiento' => $equipo->movimientos->first()?->fecha,
                'ultimo_mantenimiento' => $equipo->mantenimientos->first()?->fecha_programada,
            ];

            // Exportar PDF
            if ($request->formato === 'pdf') {
                $pdf = Pdf::loadView('reportes.pdf.historial-equipo', 
                    compact('equipo', 'historial', 'estadisticas'));
                return $pdf->download('historial-' . $equipo->codigo . '-' . now()->format('Y-m-d') . '.pdf');
            }

            return view('reportes.historial-equipo', compact('equipo', 'historial', 'estadisticas'));
        }

        // Vista de selección de equipo
        $equipos = Equipo::with('categoria')->orderBy('codigo')->get();
        return view('reportes.historial-equipo', compact('equipos'));
    }

    // ==================== REPORTE: USUARIOS Y ACTIVIDAD ====================
    public function usuariosActividad(Request $request)
    {
        // Filtros de fecha
        $fechaInicio = $request->filled('fecha_inicio') 
            ? $request->fecha_inicio 
            : now()->subMonth()->format('Y-m-d');
        
        $fechaFin = $request->filled('fecha_fin') 
            ? $request->fecha_fin 
            : now()->format('Y-m-d');

        // Usuarios con estadísticas
        $usuarios = User::withCount([
            'movimientos as movimientos_count' => function($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
            }
        ])->get()->map(function($usuario) use ($fechaInicio, $fechaFin) {
            // Mantenimientos asociados (por usuario_id en mantenimientos)
            $mantenimientos = Mantenimiento::where('usuario_id', $usuario->id)
                ->whereBetween('fecha_programada', [$fechaInicio, $fechaFin])
                ->count();

            return [
                'id' => $usuario->id,
                'nombre' => $usuario->name,
                'email' => $usuario->email,
                'rol' => $usuario->rol,
                'estado' => $usuario->estado ? 'Activo' : 'Inactivo',
                'movimientos' => $usuario->movimientos_count,
                'mantenimientos' => $mantenimientos,
                'total_actividad' => $usuario->movimientos_count + $mantenimientos,
                'ultima_actividad' => Movimiento::where('usuario_id', $usuario->id)
                    ->latest('fecha')
                    ->first()?->fecha
            ];
        });

        // Estadísticas generales
        $estadisticas = [
            'total_usuarios' => $usuarios->count(),
            'administradores' => $usuarios->where('rol', 'Administrador')->count(),
            'usuarios_normales' => $usuarios->where('rol', 'Usuario')->count(),
            'usuarios_activos' => $usuarios->where('estado', 'Activo')->count(),
            'total_movimientos' => $usuarios->sum('movimientos'),
            'total_mantenimientos' => $usuarios->sum('mantenimientos'),
        ];

        // Datos para gráfico de actividad
        $chartData = [
            'usuarios' => $usuarios->pluck('nombre')->toArray(),
            'movimientos' => $usuarios->pluck('movimientos')->toArray(),
            'mantenimientos' => $usuarios->pluck('mantenimientos')->toArray(),
        ];

        // Exportar PDF
        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.usuarios-actividad', 
                compact('usuarios', 'estadisticas', 'fechaInicio', 'fechaFin'));
            return $pdf->download('usuarios-actividad-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('reportes.usuarios-actividad', 
            compact('usuarios', 'estadisticas', 'chartData', 'fechaInicio', 'fechaFin'));
    }

    // ==================== REPORTES EXISTENTES ====================
    
    public function movimientos(Request $request)
    {
        $query = Movimiento::with(['equipo', 'usuario']);

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $movimientos = $query->latest()->get();

        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.movimientos', compact('movimientos'));
            return $pdf->download('movimientos-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('reportes.movimientos', compact('movimientos'));
    }

    public function mantenimientos(Request $request)
    {
        $query = Mantenimiento::with(['equipo', 'usuario']);

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_programada', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_programada', '<=', $request->fecha_fin);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $mantenimientos = $query->latest()->get();

        if ($request->formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.mantenimientos', compact('mantenimientos'));
            return $pdf->download('mantenimientos-' . now()->format('Y-m-d') . '.pdf');
        }

        return view('reportes.mantenimientos', compact('mantenimientos'));
    }

    // ==================== MÉTODOS AUXILIARES ====================

    private function getMovimientoIcon($tipo)
    {
        return match($tipo) {
            'Entrada' => 'arrow-down-circle',
            'Salida' => 'arrow-up-circle',
            'Transferencia' => 'arrow-right-left',
            'Mantenimiento' => 'wrench',
            'Dado de Baja' => 'x-circle',
            default => 'circle'
        };
    }

    private function getMovimientoColor($tipo)
    {
        return match($tipo) {
            'Entrada' => 'success',
            'Salida' => 'info',
            'Transferencia' => 'warning',
            'Mantenimiento' => 'primary',
            'Dado de Baja' => 'danger',
            default => 'secondary'
        };
    }

    private function getMantenimientoColor($estado)
    {
        return match($estado) {
            'Pendiente' => 'warning',
            'En Proceso' => 'info',
            'Completado' => 'success',
            'Cancelado' => 'danger',
            default => 'secondary'
        };
    }
}