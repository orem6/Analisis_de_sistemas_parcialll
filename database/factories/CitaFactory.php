<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Doctor;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Cita> */
class CitaFactory extends Factory
{
    protected $model = Cita::class;

    public function definition(): array
    {
        $inicio = fake()->dateTimeBetween('+1 day', '+1 month');

        return [
            'paciente_id' => Paciente::factory(),
            'doctor_id' => Doctor::factory(),
            'inicio' => $inicio,
            'fin' => (clone $inicio)->modify('+30 minutes'),
            'motivo' => fake()->sentence(),
            'estado' => 'pendiente',
        ];
    }
}
