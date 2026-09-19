<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Doctor> */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellido' => fake()->lastName(),
            'especialidad' => fake()->randomElement(['Cardiologia', 'Pediatria', 'Dermatologia']),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
