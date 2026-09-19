<?php

namespace Database\Seeders;

use App\Models\Paciente;
use Illuminate\Database\Seeder;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        Paciente::query()->upsert([
            ['nombre' => 'Ana', 'apellido' => 'Lopez', 'email' => 'ana.lopez@example.test', 'telefono' => '555-0101'],
            ['nombre' => 'Bruno', 'apellido' => 'Diaz', 'email' => 'bruno.diaz@example.test', 'telefono' => '555-0102'],
            ['nombre' => 'Carla', 'apellido' => 'Mendez', 'email' => 'carla.mendez@example.test', 'telefono' => '555-0103'],
        ], ['email'], ['nombre', 'apellido', 'telefono']);
    }
}
