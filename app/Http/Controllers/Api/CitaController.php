<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Services\CitaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function __construct(private CitaService $citas) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json(['data' => $this->citas->listar($request->query())]);
    }

    public function store(Request $request): JsonResponse
    {
        $cita = $this->citas->crear($request->only(['paciente_id', 'doctor_id', 'inicio', 'fin', 'motivo', 'estado']));

        return response()->json(['data' => $cita], 201);
    }

    public function show(Cita $cita): JsonResponse
    {
        return response()->json(['data' => $cita->load(['paciente', 'doctor'])]);
    }

    public function update(Request $request, Cita $cita): JsonResponse
    {
        return response()->json(['data' => $this->citas->actualizar($cita, $request->only([
            'paciente_id', 'doctor_id', 'inicio', 'fin', 'motivo', 'estado',
        ]))]);
    }

    public function updateEstado(Request $request, Cita $cita): JsonResponse
    {
        return response()->json(['data' => $this->citas->cambiarEstado($cita, (string) $request->input('estado'))]);
    }
}
