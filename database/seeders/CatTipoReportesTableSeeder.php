<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatTipoReportesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_tipo_reportes')->delete();
        
        \DB::table('cat_tipo_reportes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Agua',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'Bache',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'Basura',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}