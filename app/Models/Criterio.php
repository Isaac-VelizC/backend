<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    use HasFactory;
    protected $table = "criterios";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'porcentaje', 'total', 'curso_id'];

    public function categorias()
    {
        return $this->hasMany(CategoriaCriterio::class, 'criterio_id');
    }
    public function trabajos()
    {
        return $this->hasMany(Trabajo::class, 'criterio_id');
    }
}

class CatCritTrabajo extends Model
{
    use HasFactory;
    protected $table = "catCritTrabajo";
    protected $primaryKey = "id";
    protected $fillable = ['cat_id', 'tarea_id'];

    public function categorias()
    {
        return $this->hasMany(CategoriaCriterio::class, 'criterio_id');
    }
    public function trabajos()
    {
        return $this->hasMany(Trabajo::class, 'criterio_id');
    }
}