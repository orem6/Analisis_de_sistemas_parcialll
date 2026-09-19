<?php

namespace Tests\Feature;

use App\Models\Cita;
use App\Models\Doctor;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CitaConflictoTest extends TestCase
{
    use RefreshDatabase;

    public function test_rechaza_una_cita_solapada_para_el_mismo_doctor(): void
    {
        $doctor = Doctor::factory()->create();
        $paciente = Paciente::factory()->create();
        Cita::factory()->for($doctor)->for($paciente)->create([
            'inicio' => '2026-09-21 09:00:00',
            'fin' => '2026-09-21 10:00:00',
        ]);

        $this->postJson('/api/citas', [
            'paciente_id' => $paciente->id,
            'doctor_id' => $doctor->id,
            'fecha' => '2026-09-21',
            'hora_inicio' => '09:30',
            'hora_fin' => '10:30',
            'motivo' => 'Consulta de seguimiento',
        ])->assertConflict();
    }

    public function test_una_cita_cancelada_no_bloquea_el_horario(): void
    {
        $doctor = Doctor::factory()->create();
        $paciente = Paciente::factory()->create();
        Cita::factory()->for($doctor)->for($paciente)->create([
            'inicio' => '2026-09-21 09:00:00',
            'fin' => '2026-09-21 10:00:00',
            'estado' => 'cancelada',
        ]);

        $this->postJson('/api/citas', [
            'paciente_id' => $paciente->id,
            'doctor_id' => $doctor->id,
            'fecha' => '2026-09-21',
            'hora_inicio' => '09:30',
            'hora_fin' => '10:30',
            'motivo' => 'Nueva consulta',
        ])->assertCreated();
    }
}
