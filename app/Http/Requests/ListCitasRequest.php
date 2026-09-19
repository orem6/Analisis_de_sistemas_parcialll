<?php

namespace App\Http\Requests;

class ListCitasRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'doctor_id' => ['sometimes', 'integer', 'exists:doctores,id'],
            'paciente_id' => ['sometimes', 'integer', 'exists:pacientes,id'],
            'desde' => ['sometimes', 'date'],
            'hasta' => ['sometimes', 'date', 'after_or_equal:desde'],
        ];
    }
}
