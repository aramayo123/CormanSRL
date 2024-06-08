<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_de_tarea');
            $table->string('ticket');
			$table->unsignedBigInteger('cliente_id');
			$table->unsignedBigInteger('sucursal_id');
            $table->text('descripcion');
            $table->text('elementos');
            $table->text('diagnostico');
            $table->text('acciones');
            $table->text('observaciones');
            $table->integer('certificado')->nullable();
            $table->integer('atm')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('prioridad')->nullable();
			$table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('tareas');
    }
};
