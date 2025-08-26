<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatColoniasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_colonias', function (Blueprint $table) {
            $table->id();
            $table->integer('id_estado')->nullable();
            $table->integer('id_municipio')->nullable();
            $table->integer('cp')->nullable();
            $table->string('nombre')->nullable();
            $table->string('tipo')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_colonias');
    }
}
