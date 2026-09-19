<?php

namespace App\Http\Requests;

use App\Models\Cita;

class UpdateEstadoCitaRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return ['estado' => ['required', 'string', 'in:'.implode(',', Cita::ESTADOS)]];
    }
}
