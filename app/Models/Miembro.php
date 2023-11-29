<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "miembros";
    protected $primaryKey = "id";
    protected $fillable = ['pers_id', 'estado', 'fecha_contratado', 'sueldo', 'rol' ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'pers_id', 'id');
    }
}
