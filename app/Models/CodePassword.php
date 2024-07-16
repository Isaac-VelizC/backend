<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodePassword extends Model
{
    use HasFactory;

    protected $table = "code_passwords";
    protected $primaryKey = "id";
    protected $fillable = ['code', 'fecha', 'user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }
    
}
