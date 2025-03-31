<?php

namespace App\Http\Controllers;

use App\Services\ReservaService;
use App\Services\SalaService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\InvitadosService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservaController extends Controller
{
    protected $reservaService;
    protected $salaService;
    protected $userService;
    protected $invitadosService;
    public function __construct(ReservaService $reservaService, SalaService $salaService, UserService $userService, InvitadosService $invitadosService)
    {
        $this->reservaService = $reservaService;
        $this->salaService = $salaService;
        $this->userService = $userService;
        $this->invitadosService = $invitadosService;
    }

    public function index()
    {
       
        $reservas = $this->reservaService->obtenerReservas();
        return view('reservas.index', compact('reservas'));
    }

    public function store(Request $request)
    {
       
        $horario = Carbon::parse("{$request->day} {$request->hora_inicio}")->toDateTimeString();
        $data =
            [
                'titulo' => $request->descripcion,
                'descripcion' => $request->descripcion,
                'tipo_evento' => $request->tipo_evento,
                'horario' => $horario,
                'ubicacion' => $request->ubicacion,
                'id_usuario' => Auth::user()->id,
                'id_sala' => $request->id_sala,
                'usuarios_reunion' => json_decode($request->usuariosReunion , 1),
            ];

        $reserva = $this->reservaService->crearReserva($data);
        
    
        return redirect()->route('reservas.index');
    }

    public function create()
    {
        $data['usuarios'] = $this->userService->obtenerUsuarios();
        $data['salas'] = $this->salaService->obtenerSalas();
        return view('reservas.create', compact('data'));
    }

    public function edit(int $id)
    {
        $reserva = $this->reservaService->obtenerReserva($id);
        if (!$reserva) {
            return back()->with('danger', 'Reserva no encontrada');
        }

        $data['usuarios'] = $this->userService->obtenerUsuarios();
        $data['salas'] = $this->salaService->obtenerSalas();
        return view('reservas.edit', compact('reserva', 'data'));
    }

    public function update(Request $request, int $id)
    {
        try {
            
            $horario = Carbon::parse("{$request->day} {$request->hora_inicio}")->toDateTimeString();
            $data =
                [
                    'titulo' => $request->descripcion,
                    'descripcion' => $request->descripcion,
                    'tipo_evento' => $request->tipo_evento,
                    'horario' => $horario,
                    'ubicacion' => $request->ubicacion,
                    'id_usuario' => $request->id_usuario,
                    'id_sala' => $request->id_sala,
                ];
            Log::info($data);
            $reserva = $this->reservaService->actualizarReserva($id, $data);
            if (!$reserva) {
                return response()->json(['message' => 'Reserva no encontrada'], 404);
            }
            return response()->json($reserva, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['message' => 'Error al actualizar la reserva'], 500);
        }
    }

    public function destroy(int $id)
    {
        $result = $this->reservaService->eliminarReserva($id);
        if (!$result) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }
        return response()->json(['message' => 'Reserva eliminada correctamente'], 200);
    }

    public function show(int $id)
    {
        $reserva = $this->reservaService->obtenerReserva($id);
        if (!$reserva) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }
        return response()->json($reserva, 200);
    }
}
