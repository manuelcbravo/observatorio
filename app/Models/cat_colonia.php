<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class cat_colonia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
       'id_estado',
       'id_municipio',
        'cp',
        'nombre',
        'tipo',
    ];
}
