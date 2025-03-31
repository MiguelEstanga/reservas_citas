<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function crearUsuario(array $data)
    {
        $user = new User();
        $user->nombre = $data['nombre'];
        $user->apellido = $data['apellido'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }

    public function obtenerUsuarios()
    {
        return User::all();
    }

    public function obtenerUsuario(int $id)
    {
        return User::find($id);
    }

    public function actualizarUsuario(int $id, array $data)
    {
        $user = User::find($id);
        $user->name = $data['name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        //$user->password = Hash::make($data['password']);
        $user->unidad = $data['unidad'];
        $user->save();
        return $user;
    }

    public function eliminarUsuario(int $id)
    {
        $user = User::find($id);
        $user->delete();
        return true;
    }
}