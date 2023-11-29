<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioTrabajo extends Model
{
    use HasFactory;
    protected $table = "comentario_trabajos";
    protected $primaryKey = "id";
    protected $fillable = ['privacidad', 'body', 'action', 'autor_id', 'tarea_id'];

}
