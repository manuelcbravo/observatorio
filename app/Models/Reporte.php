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
    ];

    protected $casts = [
        'anonimo' => 'boolean',
    ];

    public function tipoReporte()
    {
        return $this->belongsTo(CatTipoReporte::class, 'tipo_reporte_id');
    }

    public function estado()
    {
        return $this->belongsTo(cat_estado::class, 'estado_id');
    }

    public function municipio()
    {
        return $this->belongsTo(cat_municipio::class, 'municipio_id');
    }

    public function colonia()
    {
        return $this->belongsTo(cat_colonia::class, 'colonia_id');
    }

    public function fotos()
    {
        return $this->hasMany(ReporteFoto::class, 'reporte_id');
    }
}
