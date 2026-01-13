<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteFoto extends Model
{
    protected $fillable = [
        'reporte_id',
        'ruta',
    ];

    public function reporte()
    {
        return $this->belongsTo(Reporte::class, 'reporte_id');
    }
}
