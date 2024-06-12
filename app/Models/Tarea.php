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
        'estado_id',
        'prioridad_id',
        'user_id',
        'fecha_mail',
        'fecha_cerrado',
    ];
    public function Autor(): HasOne
    {
        // llave foreign es el nombre del campo en la tabla actual
        // llave local es el nombre del campo en la tabla que queremos buscar
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function Cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 'id', 'cliente_id');
    }
    public function Sucursal(): HasOne
    {
        return $this->hasOne(Sucursal::class, 'id', 'sucursal_id');
    }
    public function Prioridad(){
        return $this->hasOne(Prioridad::class, 'id', 'prioridad_id');
    }
    public function Estado(){
        return $this->hasOne(Estado::class, 'id', 'estado_id');
    }
    public function Certificado(){
        if($this->certificado)
            return "SI";
        else
            return "NO";
    }
    public function Atm(){
        if($this->atm)
            return "SI";
        else
            return "NO";
    }
}
