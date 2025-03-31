<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = 'salas';
    protected $primaryKey = 'id_sala';
    protected $fillable = ['nombre', 'ubicacion', 'capacidad', 'status', 'hora_inicio', 'hora_fin' , 'day'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_sala');
    }
}
