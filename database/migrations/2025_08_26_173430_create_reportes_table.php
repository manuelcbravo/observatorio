<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();

            // Datos de contacto
            $table->string('nombre_contacto')->nullable();
            $table->string('telefono_contacto')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();

            // Datos del reporte
            $table->boolean('anonimo')->default(false);
            $table->integer('tipo_reporte_id')->nullable(); // catálogo después
            $table->integer('estado_id')->nullable();
            $table->integer('municipio_id')->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->integer('colonia_id')->nullable();

            $table->text('comentario')->nullable();

            // Ubicación
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            // Fotos (guardamos paths separados por coma o JSON)
            $table->json('fotos')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
