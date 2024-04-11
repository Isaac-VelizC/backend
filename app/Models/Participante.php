<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "participantes";
    protected $primaryKey = "id";
    protected $fillable = ['persona_id', 'contact_id', 'curso_id', 'estado', 'direccion','fecha_nac'];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}
