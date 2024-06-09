<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialGastado extends Model
{
    use HasFactory;
    protected $fillable = [
        'material_id',
        'tarea_id',
        'unidades',
        'precio',
    ];
}
