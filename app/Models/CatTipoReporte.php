<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTipoReporte extends Model
{
    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'tipo_reporte_id');
    }
}
