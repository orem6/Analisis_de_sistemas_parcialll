<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        Doctor::query()->upsert([
            ['nombre' => 'Elena', 'apellido' => 'Ruiz', 'especialidad' => 'Cardiologia', 'email' => 'elena.ruiz@example.test'],
            ['nombre' => 'Martin', 'apellido' => 'Soto', 'especialidad' => 'Pediatria', 'email' => 'martin.soto@example.test'],
            ['nombre' => 'Lucia', 'apellido' => 'Vega', 'especialidad' => 'Dermatologia', 'email' => 'lucia.vega@example.test'],
        ], ['email'], ['nombre', 'apellido', 'especialidad']);
    }
}
