<?php
// app/Services/ReservaService.php
namespace App\Services;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Invitado;
use Illuminate\Support\Facades\Log;

class InvitadosService
{

  public function crearInvitados(array $data)
  {
    try{
      $validator = Validator::make($data, [
        'id_reserva' => 'required',
        'id_usuario' => 'required',
      ]);
  
      if ($validator->fails()) {
        throw new ValidationException($validator);
      }
      $invitado = Invitado::create($data);
    
      return  $invitado;
    }catch(\Exception $e){
      Log::info($e->getMessage());
      return response()->json(['message' => 'Error al crear la invitado'], 500);
    }
  }

  public function actualizarInvitado(int $id, array $data)
  {
    $invitado = Invitado::find($id);

    if (!$invitado) {
      return null; // O lanza una excepción NotFoundException
    }

    $validator = Validator::make($data, [
      'id_reserva' => 'required',
      'id_usuario' => 'required',
      'id_invitado' => 'required',
    ]);

    if ($validator->fails()) {
      throw new ValidationException($validator);
    }

    $invitado->update($data);

    return $invitado;
  }

  public function eliminarInvitado(int $id)
  {
      $Invitado = Invitado::find($id);

      if (!$Invitado) {
          return null; // O lanza una excepción NotFoundException
      }

      $Invitado->delete();

      return true;
  }
}
