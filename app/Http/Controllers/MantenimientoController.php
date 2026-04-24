<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Equipo;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = Mantenimiento::with(['equipo', 'equipo.categoria']);

        // Filtro de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('descripcion', 'like', "%{$search}%")
                  ->orWhere('tecnico', 'like', "%{$search}%")
                  ->orWhereHas('equipo', function($eq) use ($search) {
                      $eq->where('nombre', 'like', "%{$search}%")
                         ->orWhere('codigo', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $mantenimientos = $query->latest()->paginate(10);
        $equipos = Equipo::orderBy('nombre')->get();

        return view('mantenimiento.index', compact('mantenimientos', 'equipos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'tipo' => 'required|in:Preventivo,Correctivo,Predictivo',
            'fecha_programada' => 'nullable|date',
            'fecha_realizada' => 'nullable|date',
            'descripcion' => 'required',
            'observaciones' => 'nullable',
            'costo' => 'nullable|numeric|min:0',
            'tecnico' => 'nullable|string|max:255',
            'estado' => 'required|in:Pendiente,En Proceso,Completado,Cancelado'
        ], [
            'equipo_id.required' => 'Debes seleccionar un equipo',
            'equipo_id.exists' => 'El equipo seleccionado no existe',
            'tipo.required' => 'El tipo de mantenimiento es obligatorio',
            'descripcion.required' => 'La descripción es obligatoria',
            'estado.required' => 'El estado es obligatorio',
            'costo.numeric' => 'El costo debe ser un número válido',
            'costo.min' => 'El costo no puede ser negativo'
        ]);

        // Si no viene fecha_programada, usar la fecha actual
        if (empty($validated['fecha_programada'])) {
            $validated['fecha_programada'] = now()->format('Y-m-d');
        }

        // Asignar usuario actual
        $validated['usuario_id'] = auth()->id();

        Mantenimiento::create($validated);

        return redirect()->route('mantenimiento.index')
            ->with('success', 'Mantenimiento registrado exitosamente');
    }

    public function show(Mantenimiento $mantenimiento)
    {
        $mantenimiento->load(['equipo', 'equipo.categoria']);
        return response()->json($mantenimiento);
    }

    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        $validated = $request->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'tipo' => 'required|in:Preventivo,Correctivo,Predictivo',
            'fecha_programada' => 'nullable|date',
            'fecha_realizada' => 'nullable|date',
            'descripcion' => 'required',
            'observaciones' => 'nullable',
            'costo' => 'nullable|numeric|min:0',
            'tecnico' => 'nullable|string|max:255',
            'estado' => 'required|in:Pendiente,En Proceso,Completado,Cancelado'
        ]);

        // Si no viene fecha_programada, mantener la actual
        if (empty($validated['fecha_programada'])) {
            $validated['fecha_programada'] = $mantenimiento->fecha_programada ?? now()->format('Y-m-d');
        }

        $mantenimiento->update($validated);

        return redirect()->route('mantenimiento.index')
            ->with('success', 'Mantenimiento actualizado exitosamente');
    }

    public function destroy(Mantenimiento $mantenimiento)
    {
        $mantenimiento->delete();
        
        return redirect()->route('mantenimiento.index')
            ->with('success', 'Mantenimiento eliminado exitosamente');
    }
}