<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = "personas";
    protected $primaryKey = "id";
    protected $fillable = ['user_id', 'nombre', 'ap_paterno', 'ap_materno', 'ci','genero', 'email', 'photo', 'tipo_pers', 'estado'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function docente()
    {
        return $this->hasOne(Docente::class, 'id_persona');
    }

    public function numTelefono()
    {
        return $this->hasOne(NumTelefono::class, 'id_persona');
    }
    public function miembro()
    {
        return $this->hasOne(Miembro::class, 'pers_id', 'id');
    }
    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'pers_id');
    }
    public function contacto()
    {
        return $this->hasOne(Contacto::class, 'pers_id');
    }
}
