<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RecuperarAdmin extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔄 Recuperando acceso de administrador...');

        // Actualizar TODOS los usuarios existentes para asignarles rol
        $this->command->info('📝 Actualizando usuarios existentes...');
        
        User::whereNull('rol')->orWhere('rol', '')->update([
            'rol' => 'Usuario',
            'estado' => true
        ]);

        // Buscar si ya existe el admin
        $admin = User::where('email', 'admin@ie20957.edu.pe')->first();

        if ($admin) {
            // Si existe, solo actualizar su rol a Administrador
            $admin->update([
                'rol' => 'Administrador',  // ✅ Corregido: era 'role', ahora es 'rol'
                'estado' => true
            ]);
            $this->command->info("✅ Usuario administrador actualizado: {$admin->email}");
        } else {
            // Si no existe, crearlo
            User::create([
                'name' => 'Administrador',
                'email' => 'johan@gmail.com',
                'password' => Hash::make('12345678'),
                'rol' => 'Administrador',  // ✅ Corregido: era 'role', ahora es 'rol'
                'estado' => true
            ]);
            $this->command->info("✅ Usuario administrador creado: johan@gmail.com");
        }

        // Convertir tu usuario actual en Administrador también
        $tuUsuario = User::where('email', 'johan@gmail.com')->first();  // ⚠️ Cambia esto por tu email real
        
        if ($tuUsuario) {
            $tuUsuario->update([
                'rol' => 'Administrador',
                'estado' => true
            ]);
            $this->command->info("✅ Tu usuario también es administrador: {$tuUsuario->email}");
        }

        $this->command->newLine();
        $this->command->info("🎉 ¡Proceso completado!");
        $this->command->info("📊 Resumen:");
        $this->command->info("   - Administradores: " . User::where('rol', 'Administrador')->count());
        $this->command->info("   - Usuarios: " . User::where('rol', 'Usuario')->count());
        $this->command->newLine();
        $this->command->info("🔐 Credenciales de administrador:");
        $this->command->info("   Email: admin@ie20957.edu.pe");
        $this->command->info("   Contraseña: admin123");
    }
}