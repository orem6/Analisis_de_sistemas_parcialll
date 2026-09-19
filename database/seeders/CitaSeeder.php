<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Doctor;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class CitaSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = Paciente::query()->orderBy('id')->get();
        $doctores = Doctor::query()->orderBy('id')->get();

        Cita::query()->upsert([
            ['paciente_id' => $pacientes[0]->id, 'doctor_id' => $doctores[0]->id, 'inicio' => '2026-09-21 09:00:00', 'fin' => '2026-09-21 09:30:00', 'motivo' => 'Control anual', 'estado' => 'confirmada'],
            ['paciente_id' => $pacientes[1]->id, 'doctor_id' => $doctores[1]->id, 'inicio' => '2026-09-21 10:00:00', 'fin' => '2026-09-21 10:30:00', 'motivo' => 'Consulta pediatrica', 'estado' => 'pendiente'],
            ['paciente_id' => $pacientes[2]->id, 'doctor_id' => $doctores[2]->id, 'inicio' => '2026-09-22 11:00:00', 'fin' => '2026-09-22 11:30:00', 'motivo' => 'Revision dermatologica', 'estado' => 'atendida'],
        ], ['doctor_id', 'inicio'], ['paciente_id', 'fin', 'motivo', 'estado']);
    }
}
