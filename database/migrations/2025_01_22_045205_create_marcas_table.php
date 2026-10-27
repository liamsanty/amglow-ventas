<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
            // Verifica si la tabla ya existe antes de crearla
            if (!Schema::hasTable('marcas')) {
                Schema::create('marcas', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('caracteristica_id')->nullable()->constrained()->onDelete('cascade');
                    $table->timestamps();
                });
            }
        }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('marcas');
    }
};
