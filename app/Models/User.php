<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    protected $connection = 'mysql'; // Asegúrate de que la conexión es correcta
    protected $table = 'usersv2';  // Nombre de la tabla
    protected $primaryKey = 'id';  // Si la clave primaria no es 'id', cámbiala
    public $timestamps = false;    // Si la tabla no tiene timestamps, pon esto en false

    // Método para obtener el nombre del usuario por extensión
    public static function getUserByExtension($extension)
    {
        return self::where('extension', $extension)->first();  // Devuelve el primer resultado
    }
}
