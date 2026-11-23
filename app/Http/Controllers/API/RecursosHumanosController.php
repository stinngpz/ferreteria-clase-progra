<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\EmpleadoResource;

class RecursosHumanosController extends Controller
{
    /**
     * GET /api/recursos-humanos
     * Devuelve el listado paginado del personal.
     */
    public function index(): JsonResponse
    {
        $empleados = Empleado::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data'   => EmpleadoResource::collection($empleados),
            'pagination' => [
                'total'        => $empleados->total(),
                'per_page'     => $empleados->perPage(),
                'current_page' => $empleados->currentPage(),
                'last_page'    => $empleados->lastPage(),
            ]
        ], 200);
    }

    /**
     * POST /api/recursos-humanos
     * Registra un nuevo empleado tras validar los datos.
     */
    public function store(Request $request): JsonResponse
    {
        $validados = $request->validate(Empleado::reglas());

        $empleado = Empleado::create($validados);

        return response()->json([
            'status'  => 'created',
            'message' => 'Empleado registrado exitosamente en Recursos Humanos',
            'data'    => new EmpleadoResource($empleado)
        ], 201);
    }

    /**
     * GET /api/recursos-humanos/{id}
     * Consulta el detalle de un empleado por su ID.
     */
    public function show(string $id): JsonResponse
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'status'  => 'error',
                'message' => "El empleado con ID #{$id} no existe en Recursos Humanos"
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => new EmpleadoResource($empleado)
        ], 200);
    }

    /**
     * PUT /api/recursos-humanos/{id}
     * Actualiza los datos del empleado.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Empleado no encontrado para actualizar'
            ], 404);
        }

        // Se pasa el id para que la regla unique no choque con el mismo empleado
        $validados = $request->validate(Empleado::reglas($empleado->id));

        $empleado->update($validados);

        return response()->json([
            'status'  => 'updated',
            'message' => 'Empleado actualizado correctamente',
            'data'    => new EmpleadoResource($empleado)
        ], 200);
    }

    /**
     * DELETE /api/recursos-humanos/{id}
     * Da de baja al empleado del sistema.
     */
    public function destroy(string $id): JsonResponse
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'status'  => 'error',
                'message' => 'El empleado a eliminar no existe en Recursos Humanos'
            ], 404);
        }

        $empleado->delete();

        return response()->json([
            'status'  => 'deleted',
            'message' => 'Empleado dado de baja exitosamente'
        ], 200);
    }
}