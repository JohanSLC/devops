<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Movimiento;
use App\Models\Mantenimiento;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEquipos = Equipo::count();
        $totalCategorias = Categoria::count();
        $totalUsuarios = User::count();
        $equiposDisponibles = Equipo::where('estado', 'Disponible')->count();
        $equiposEnUso = Equipo::where('estado', 'En Uso')->count();
        $equiposMantenimiento = Equipo::where('estado', 'Mantenimiento')->count();

        $equiposPorCategoria = Categoria::withCount('equipos')
            ->with(['equipos' => function($query) {
                $query->where('estado', 'Disponible');
            }])
            ->having('equipos_count', '>', 0)
            ->get()
            ->map(function($categoria) {
                $categoria->disponibles = $categoria->equipos->count();
                return $categoria;
            });

        $movimientosRecientes = Movimiento::with(['equipo', 'usuario'])
            ->latest()
            ->take(5)
            ->get();

        // CORREGIDO: Usar count() en lugar de get()
        $mantenimientosPendientes = Mantenimiento::where('estado', 'Pendiente')->count();

        $equiposPorEstado = Equipo::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();

        // Calcular alertas
        $alertasTotal = $mantenimientosPendientes + $equiposMantenimiento;

        return view('dashboard', compact(
            'totalEquipos',
            'equiposDisponibles',
            'equiposMantenimiento',
            'mantenimientosPendientes',
            'alertasTotal',
            'movimientosRecientes',
            'equiposPorCategoria'
        ));
    }
}