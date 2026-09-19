<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListCitasRequest;
use App\Http\Requests\StoreCitaRequest;
use App\Http\Requests\UpdateCitaRequest;
use App\Http\Requests\UpdateEstadoCitaRequest;
use App\Models\Cita;
use App\Services\CitaService;
use Illuminate\Http\JsonResponse;

class CitaController extends Controller
{
    public function __construct(private CitaService $citas) {}

    public function index(ListCitasRequest $request): JsonResponse
    {
        return response()->json(['data' => $this->citas->listar($request->validated())]);
    }

    public function store(StoreCitaRequest $request): JsonResponse
    {
        $cita = $this->citas->crear($request->citaData());

        return response()->json(['data' => $cita], 201);
    }

    public function show(Cita $cita): JsonResponse
    {
        return response()->json(['data' => $cita->load(['paciente', 'doctor'])]);
    }

    public function update(UpdateCitaRequest $request, Cita $cita): JsonResponse
    {
        return response()->json(['data' => $this->citas->actualizar($cita, $request->citaData())]);
    }

    public function updateEstado(UpdateEstadoCitaRequest $request, Cita $cita): JsonResponse
    {
        return response()->json(['data' => $this->citas->cambiarEstado($cita, $request->validated('estado'))]);
    }
}
