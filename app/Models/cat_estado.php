<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cat_estado extends Model
{
    use HasFactory;

    public function reportes()
    {
        return $this->hasMany(Reporte::class, 'estado_id');
    }
}
