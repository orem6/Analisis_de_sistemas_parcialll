<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Paciente> */
class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellido' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->numerify('555-####'),
        ];
    }
}
