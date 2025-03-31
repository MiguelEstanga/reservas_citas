<?php
// app/Http/Controllers/SalaController.php
namespace App\Http\Controllers;

use App\Services\SalaService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
class SalaController extends Controller
{
    protected $salaService;

    public function __construct(SalaService $salaService)
    {
        $this->salaService = $salaService;
    }

    public function index(){
        $salas = $this->salaService->obtenerSalas();
        return view('salas.index', compact('salas'));
    }
    
    public function show(int $id)
    {
        $sala = $this->salaService->obtenerSala($id);
        if(!$sala){
            return response()->json(['message' => 'Sala no encontrada'], 404);
        }
        return response()->json($sala, 200);
    }
    public function create()
    {
        return view('salas.create');
    }

    public function store(Request $request)
    {
        try {
           // return $request->all();
            $sala = $this->salaService->crearSala($request->all());
            return response()->json('Sala creada correctamente', 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['message' => 'Error al crear la sala'], 500); // 500 Internal Server Error
        }
    }

    public function edit(int $id)
    {
        $sala = $this->salaService->obtenerSala($id);
        if(!$sala){
            return back()->with('danger', 'La sala no existe'); 
        }
        return view('salas.edit', compact('sala'));
    }

    public function update(Request $request, int $id)
    {
        try {
            $sala = $this->salaService->actualizarSala($id, $request->all());
            if(!$sala) {
                return response()->json(['message' => 'Sala no encontrada'], 404);
            }
            return response()->json('Sala actualizada correctamente', 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la sala'], 500);
        }
    }

    public function destroy(int $id)
    {
        $result = $this->salaService->eliminarSala($id);
        if(!$result){
            return response()->json(['message' => 'Sala no encontrada'], 404);
        }
        return response()->json(['message' => 'Sala eliminada correctamente'], 200);
    }
}