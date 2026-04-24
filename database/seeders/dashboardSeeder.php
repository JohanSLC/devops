<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Categoria;
use App\Models\EstadoEquipo;
use App\Models\Equipo;
use App\Models\Movimiento;
use App\Models\Mantenimiento;
use Illuminate\Support\Facades\Hash;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario admin si no existe (CON ROL)
        if (!User::where('email', 'admin@ie20957.edu.pe')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@ie20957.edu.pe',
                'password' => Hash::make('admin123'),
                'rol' => 'Administrador',  // ✅ AGREGADO
                'estado' => true           // ✅ AGREGADO
            ]);
            $this->command->info("✅ Usuario administrador creado");
        } else {
            // Si ya existe, asegurar que tenga rol de Administrador
            User::where('email', 'admin@ie20957.edu.pe')->update([
                'rol' => 'Administrador',
                'estado' => true
            ]);
            $this->command->info("✅ Usuario administrador actualizado");
        }

        // Crear categorías
        $categorias = [
            ['nombre' => 'Computadoras', 'descripcion' => 'Equipos de cómputo', 'codigo' => 'COMP', 'estado' => 'Activo'],
            ['nombre' => 'Proyectores', 'descripcion' => 'Equipos multimedia', 'codigo' => 'PROY', 'estado' => 'Activo'],
            ['nombre' => 'Mobiliario', 'descripcion' => 'Muebles y sillas', 'codigo' => 'MOBI', 'estado' => 'Activo'],
            ['nombre' => 'Impresoras', 'descripcion' => 'Equipos de impresión', 'codigo' => 'IMPR', 'estado' => 'Activo'],
        ];

        foreach ($categorias as $cat) {
            Categoria::firstOrCreate(['codigo' => $cat['codigo']], $cat);
        }
        $this->command->info("✅ Categorías creadas/actualizadas");

        // Crear estados de equipos (si usas esta tabla)
        $estados = [
            ['nombre' => 'Disponible'],
            ['nombre' => 'En Uso'],
            ['nombre' => 'Mantenimiento'],
            ['nombre' => 'Dado de Baja'],
        ];

        foreach ($estados as $estado) {
            EstadoEquipo::firstOrCreate($estado);
        }

        // Crear equipos de ejemplo
        $usuario = User::where('rol', 'Administrador')->first();
        $equipos = [
            [
                'codigo' => 'COMP-001',
                'nombre' => 'Laptop HP ProBook 450',
                'descripcion' => 'Laptop para docentes',
                'categoria_id' => Categoria::where('codigo', 'COMP')->first()->id,
                'marca' => 'HP',
                'modelo' => 'ProBook 450 G8',
                'serie' => 'SN123456',
                'estado' => 'Disponible',
                'fecha_adquisicion' => now()->subMonths(6),
                'precio_adquisicion' => 2500.00,
                'ubicacion' => 'Sala de Profesores',
            ],
            [
                'codigo' => 'PROY-001',
                'nombre' => 'Proyector Epson',
                'descripcion' => 'Proyector multimedia',
                'categoria_id' => Categoria::where('codigo', 'PROY')->first()->id,
                'marca' => 'Epson',
                'modelo' => 'PowerLite X41+',
                'serie' => 'EP789012',
                'estado' => 'En Uso',
                'fecha_adquisicion' => now()->subYear(),
                'precio_adquisicion' => 1800.00,
                'ubicacion' => 'Aula 101',
            ],
            [
                'codigo' => 'COMP-002',
                'nombre' => 'PC Escritorio Dell',
                'descripcion' => 'Computadora de escritorio',
                'categoria_id' => Categoria::where('codigo', 'COMP')->first()->id,
                'marca' => 'Dell',
                'modelo' => 'OptiPlex 7080',
                'serie' => 'DL345678',
                'estado' => 'Mantenimiento',
                'fecha_adquisicion' => now()->subMonths(8),
                'precio_adquisicion' => 3200.00,
                'ubicacion' => 'Laboratorio de Cómputo',
            ],
        ];

        foreach ($equipos as $equipo) {
            if (!Equipo::where('codigo', $equipo['codigo'])->exists()) {
                Equipo::create($equipo);
            }
        }
        $this->command->info("✅ Equipos de ejemplo creados");

        // Crear movimientos
        $equipoDisponible = Equipo::where('estado', 'Disponible')->first();
        if ($equipoDisponible && $usuario) {
            if (!Movimiento::where('equipo_id', $equipoDisponible->id)->exists()) {
                Movimiento::create([
                    'equipo_id' => $equipoDisponible->id,
                    'tipo' => 'Entrada',
                    'fecha' => now()->subDays(5),
                    'destino' => 'Sala de Profesores',
                    'motivo' => 'Asignación',
                    'observaciones' => 'Equipo nuevo asignado',
                    'usuario_id' => $usuario->id,
                ]);
            }
        }

        // Crear mantenimientos
        $equipoMantenimiento = Equipo::where('estado', 'Mantenimiento')->first();
        if ($equipoMantenimiento && $usuario) {
            if (!Mantenimiento::where('equipo_id', $equipoMantenimiento->id)->exists()) {
                Mantenimiento::create([
                    'equipo_id' => $equipoMantenimiento->id,
                    'tipo' => 'Correctivo',
                    'fecha_programada' => now()->addDays(2),
                    'descripcion' => 'Cambio de disco duro',
                    'costo' => 350.00,
                    'tecnico' => 'Juan Pérez',
                    'estado' => 'Pendiente',
                    'usuario_id' => $usuario->id,
                ]);
            }
        }

        $this->command->newLine();
        $this->command->info("🎉 Dashboard Seeder completado!");
    }
}