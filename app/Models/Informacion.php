<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informacion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "informacions";
    protected $primaryKey = "id";
    protected $fillable = ['logo',
        'imagen1',
        'imagen2',
        'nombre',
        'titulo',
        'subtitulo1',
        'subtitulo2',
        'descripcion1',
        'descripcion2',
        'telefono',
        'correo',
        'facebook',
        'youtube',
        'twitter',
        'instagram',
        'linkedin',
        'latitud',
        'longitud'];

}
