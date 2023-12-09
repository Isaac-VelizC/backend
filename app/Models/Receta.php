<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;
    protected $table = "recetas";
    protected $primaryKey = "id";
    protected $fillable = ['titulo', 'imagen', 'descripcion', 'porcion', 'tiempo', 'ocasion', 'consejos'];
}
class IngredienteReceta extends Model
{
    use HasFactory;
    protected $table = "ingrediente_recetas";
    protected $primaryKey = "id";
    protected $fillable = ['ingrediente_id', 'cantidad', 'unida_media', 'receta_id'];
}
class PasosReceta extends Model
{
    use HasFactory;
    protected $table = "pasos_recetas";
    protected $primaryKey = "id";
    protected $fillable = ['paso', 'receta_id'];    
}