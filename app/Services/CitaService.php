<?php

namespace App\Services;

use App\Models\Cita;
use Illuminate\Database\Eloquent\Collection;

class CitaService
{
    public function listar(array $filtros = []): Collection
    {
        return Cita::query()
            ->with(['paciente', 'doctor'])
            ->when($filtros['doctor_id'] ?? null, fn ($query, $doctorId) => $query->where('doctor_id', $doctorId))
            ->when($filtros['paciente_id'] ?? null, fn ($query, $pacienteId) => $query->where('paciente_id', $pacienteId))
            ->when($filtros['desde'] ?? null, fn ($query, $desde) => $query->where('inicio', '>=', $desde))
            ->when($filtros['hasta'] ?? null, fn ($query, $hasta) => $query->where('fin', '<=', $hasta))
            ->orderBy('inicio')
            ->get();
    }

    public function crear(array $datos): Cita
    {
        $datos['estado'] ??= 'pendiente';

        return Cita::create($datos)->load(['paciente', 'doctor']);
    }

    public function actualizar(Cita $cita, array $datos): Cita
    {
        $cita->update($datos);

        return $cita->fresh(['paciente', 'doctor']);
    }

    public function cambiarEstado(Cita $cita, string $estado): Cita
    {
        return $this->actualizar($cita, ['estado' => $estado]);
    }
}
