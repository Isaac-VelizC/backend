<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = "comentarios";
    protected $primaryKey = "id";
    protected $fillable = ['privacidad', 'body', 'action', 'autor_id', 'materia_id'];

}
