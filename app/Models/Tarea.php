<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tarea extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo_de_tarea',
        'ticket',
        'cliente_id',
        'sucursal_id',
        'descripcion',
        'elementos',
        'diagnostico',
        'acciones',
        'observaciones',
        'certificado',
        'atm',
        'estado',
        'prioridad',
        'user_id',
    ];
    public function Autor(): HasOne
    {
        // llave foreign es el nombre del campo en la tabla actual
        // llave local es el nombre del campo en la tabla que queremos buscar
        return $this->hasOne(User::class, 'user_id');
    }
    public function Cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 'cliente_id');
    }
    public function Sucursal(): HasOne
    {
        return $this->hasOne(Sucursal::class, 'sucursal_id');
    }
}
