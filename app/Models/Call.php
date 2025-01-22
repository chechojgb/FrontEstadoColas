<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $connection = 'mysql'; // Asegúrate de que la conexión es correcta
    protected $table = 'calls';  // Nombre de la tabla
    protected $primaryKey = 'id';  // Si la clave primaria no es 'id', cámbiala
    public $timestamps = false;    // Si la tabla no tiene timestamps, pon esto en false

    // Método para obtener la última llamada por el ID de usuario
    public static function getLastCallByUserId($userId)
    {
        return self::where('user_id', $userId)
                    ->orderBy('start', 'desc')  // Ordenamos por la fecha de inicio de la llamada
                    ->first();  // Devuelve solo la última llamada
    }
}
