<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Invitado extends Model
{
    use HasFactory;
    protected $table = "invitados";
    protected $primaryKey = 'id_invitados';
    protected $fillable = ['id_reserva', 'id_usuario' , 'id_invitados'];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
