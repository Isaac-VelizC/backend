<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoEstudiante extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "pago_estudiantes";
    protected $primaryKey = "id";
    protected $fillable = ['estudiante_id', 'curso_id', 'pago_id'];

}
