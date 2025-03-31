<?php

// app/Services/ReservaService.php
namespace App\Services;

use App\Models\Reserva;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\InvitadosService;
use Exception;
use Illuminate\Support\Facades\Auth;

class ReservaService
{
    protected $invitadosService;
    public function __construct(InvitadosService $invitadosService)
    {
        $this->invitadosService = $invitadosService;
    }
    public function crearReserva(array $data)
    {
        try {
            $validator = Validator::make($data, [
                'titulo' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'tipo_evento' => 'required',
                'horario' => 'required|date',
                'ubicacion' => 'required|string|max:255',
                'id_usuario' => 'required|exists:users,id',
                'id_sala' => 'required|exists:salas,id_sala',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            $invitados = [];
            $reserva = Reserva::create($data);
            if(! $reserva){
                return response()->json(['message' => 'Error al crear la reserva'], 500);
            }
            foreach ($data['usuarios_reunion'] as $usuario_reunion) {
                Log::info($usuario_reunion);
                $invitados[] = $this->invitadosService->crearInvitados([
                    'id_reserva' => $reserva->id_reserva,
                    'id_usuario' => $usuario_reunion['id'],
                   
                ]);
            }
            $invitados = $this->invitadosService->crearInvitados($invitados);
            return response()->json([
                'reserva' => $reserva,
                'invitados' => $invitados,
            ], 201);
            
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['message' => 'Error al crear la reserva'], 500);
        }
    }

    public function actualizarReserva(int $id, array $data)
    {
        $reserva = Reserva::find($id);
        if (!$reserva) {
            return null; // O lanza una excepción NotFoundException
        }
        /**
        $validator = Validator::make($data, [
            'titulo' => 'required',
            'descripcion' => 'required|string',
            'tipo_evento' => 'required',
            'horario' => 'required|date',
            'ubicacion' => 'required|string|max:255',
            'id_usuario' => 'required|exists:users,id',
            'id_sala' => 'required|exists:salas,id_sala',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        } */

        try {
            $reserva->update($data);

            return $reserva;
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

  

    public function eliminarReserva(int $id)
    {
        $reserva = Reserva::find($id);
        if (!$reserva) {
            return null;
        }
        DB::beginTransaction();
        try {
            $this->invitadosService->eliminarInvitado($reserva->id_reserva);
            $reserva->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e->getMessage());
            // Manejar el error (por ejemplo, registrarlo o lanzar una excepción)
            return false;
        }
    }

    public function obtenerReserva(int $id)
    {
        return Reserva::find($id);
    }

    public function obtenerReservas()
    {
        return Reserva::all();
    }
}
