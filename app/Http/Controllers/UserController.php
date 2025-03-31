<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $usuarios = $this->userService->obtenerUsuarios();
        return view('usuario.index', compact('usuarios'));
    }

    public function edit(int $id)
    {
        $usuario = $this->userService->obtenerUsuario($id);
        if(!$usuario){
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        return view('usuario.edit', compact('usuario'));
    }

    public function update(Request $request, int $id)
    {
        try {
            $usuario = $this->userService->obtenerUsuario($id);
            if(!$usuario){
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }
            $this->userService->actualizarUsuario( $id , $request->all()) ;
            return back()->with('message', 'Usuario actualizado correctamente');
        }catch(Exception $e){
            Log::error($e->getMessage());
            return back()->with('danger', 'Error al actualizar el usuario');
        }
    }

    public function destroy(int $id)
    {
       $eliminar = $this->userService->eliminarUsuario($id);
       if(!$eliminar){
           return response()->json(['message' => 'Usuario no encontrado'], 404);
       }
       return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }
}