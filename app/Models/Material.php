<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = "materiales";
    use HasFactory;
    protected $fillable = [
        'rubro',
        'descripcion',
        'unidad',
    ];
}