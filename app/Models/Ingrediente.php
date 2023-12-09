<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "ingredientes";
    protected $primaryKey = "id";
    protected $fillable = ['nombre', 'tipo_id'];

}
