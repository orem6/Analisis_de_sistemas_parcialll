<?php

namespace App\Http\Requests;

class UpdateCitaRequest extends StoreCitaRequest
{
    public function rules(): array
    {
        return $this->citaRules();
    }
}
