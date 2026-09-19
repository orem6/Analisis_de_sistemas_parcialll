<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\JsonResponse;

class PacienteController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => Paciente::query()->orderBy('apellido')->get()]);
    }
}
