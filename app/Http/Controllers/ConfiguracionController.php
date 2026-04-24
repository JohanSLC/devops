<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ConfiguracionController extends Controller
{
    public function index()
    {
        return view('configuracion.index');
    }

    public function backup()
    {
        try {
            Artisan::call('backup:run');
            return back()->with('success', 'Respaldo creado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear respaldo: ' . $e->getMessage());
        }
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return back()->with('success', 'Caché limpiado exitosamente');
    }
}