<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Reserva extends Model
{
    use HasFactory;
    protected $table = "reservas";
    protected $primaryKey = 'id_reserva';
    protected $fillable = ['titulo', 'descripcion', 'tipo_evento', 'horario', 'ubicacion', 'id_usuario', 'id_sala'];
   
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class, 'id_sala');
    }

    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'id_reserva');
    }
}
