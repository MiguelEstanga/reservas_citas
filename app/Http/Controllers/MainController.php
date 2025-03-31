<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReservaService;

class MainController extends Controller
{
    protected $reservaService;
    public function __construct(ReservaService $reservaService)
    {
        $this->reservaService = $reservaService;
    }
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 4;
        $reservas = $this->reservaService->obtenerReservas();
        $eventosFormateados = [];
        foreach ($reservas as $reserva) {
            $eventosFormateados[] = [
                'id' => $reserva->id_reserva,
                'title' => $reserva->titulo, // Asegúrate de que el título es apropiado
                'start' => $reserva->horario, // FullCalendar entiende este formato
                'description' => $reserva->descripcion, // Opcional
                'ubicacion' => $reserva->ubicacion, // opcional
                'tipo_evento' => $reserva->tipo_evento, //opcional
                // Agrega más campos si es necesario
            ];
        }

        $paginatedEvents = array_slice($eventosFormateados ?? [], ($page - 1) * $perPage, $perPage);
        $totalEvents = count($eventosFormateados);
        $totalPages = ceil($totalEvents / $perPage);

        return view('inicio.index', [
            'eventos' => $paginatedEvents,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'allEvents' => $eventosFormateados, // Pasar todos los eventos para FullCalendar
        ]);
    }
}
