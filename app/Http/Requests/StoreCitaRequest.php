<?php

namespace App\Http\Requests;

use App\Models\Cita;

class StoreCitaRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return $this->citaRules() + ['estado' => ['sometimes', 'in:'.implode(',', Cita::ESTADOS)]];
    }

    public function citaData(): array
    {
        $data = $this->validated();
        $data['inicio'] = $data['fecha'].' '.$data['hora_inicio'];
        $data['fin'] = $data['fecha'].' '.$data['hora_fin'];
        unset($data['fecha'], $data['hora_inicio'], $data['hora_fin']);

        return $data;
    }

    protected function citaRules(): array
    {
        return [
            'paciente_id' => ['required', 'integer', 'exists:pacientes,id'],
            'doctor_id' => ['required', 'integer', 'exists:doctores,id'],
            'fecha' => ['required', 'date_format:Y-m-d'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'motivo' => ['required', 'string', 'max:1000'],
        ];
    }
}
