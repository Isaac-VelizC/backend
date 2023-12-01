<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;
    protected $table = "recetas";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'descripcion', 'porcion'];
}
class IngredienteReceta extends Model
{
    use HasFactory;
    protected $table = "ingrediente_recetas";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'cantidad', 'unida_media', 'receta_id'];
}
class PasosReceta extends Model
{
    use HasFactory;
    protected $table = "pasos_recetas";
    protected $primaryKey = "id";
    protected $fillable = ['titulo', 'paso', 'receta_id'];    
}
class FotosReceta extends Model
{
    use HasFactory;
    protected $table = "fotos_recetas";
    protected $primaryKey = "id";
    protected $fillable = ['imagen', 'receta_id'];
}
