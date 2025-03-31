<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InvitadosService;
use Illuminate\Validation\ValidationException;

class InvitadoController extends Controller
{
    protected $invitadosService;
    public function __construct(InvitadosService $invitadosService)
    {
        $this->invitadosService = $invitadosService;
    }

    public function store(Request $request)
    {
        try {
            $invitado = $this->invitadosService->crearInvitados($request->all());
            return response()->json($invitado, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la reserva'], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $invitado = $this->invitadosService->actualizarInvitado($id, $request->all());
            if(!$invitado) {
                return response()->json(['message' => 'Reserva no encontrada'], 404);
            }
            return response()->json($invitado, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la reserva'], 500);
        }
    }

    public function destroy(int $id)
    {
        $result = $this->invitadosService->eliminarInvitado($id);
        if(!$result){
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }
        return response()->json(['message' => 'Reserva eliminada correctamente'], 200);
    }
}
