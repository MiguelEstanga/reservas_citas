<?php
// app/Services/SalaService.php

namespace App\Services;

use App\Models\Sala;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SalaService
{
    public function obtenerSala(int $id)
    {
        return Sala::find($id);
    }

    public function obtenerSalas()
    {
        return Sala::all();
    }
    public function crearSala(array $data)
    {
        $validator = Validator::make($data, [
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'day' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Sala::create($data);
    }

    public function actualizarSala(int $id, array $data)
    {
        $sala = Sala::find($id);

        if (!$sala) {
            return null; // O lanza una excepción NotFoundException
        }

        $validator = Validator::make($data, [
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'hora_inicio' => 'required|date_format:H:i:s',
            'hora_fin' => 'required|date_format:H:i:s|after:hora_inicio',
            'status' => 'in:habilitada,inhabilitada',
            'day' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $sala->update($data);

        return $sala;
    }

    public function eliminarSala(int $id)
    {
        try {
            $sala = Sala::find($id);

            if (!$sala) {
                return null; // O lanza una excepción NotFoundException
            }

            $sala->delete();

            return true;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la sala'], 500);
        }
    }
}
