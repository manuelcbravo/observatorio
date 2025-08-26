<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $fillable = [
        'nombre_contacto',
        'telefono_contacto',
        'facebook',
        'twitter',
        'instagram',
        'anonimo',
        'tipo_reporte_id',
        'estado_id',
        'municipio_id',
        'codigo_postal',
        'colonia_id',
        'comentario',
        'lat',
        'lng',
        'fotos',
    ];

    protected $casts = [
        'anonimo' => 'boolean',
        'fotos' => 'array',
    ];
}
