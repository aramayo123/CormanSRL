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
			$table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
			$table->unsignedBigInteger('sucursal_id')->nullable();
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('set null');
            $table->text('descripcion');
            $table->text('elementos');
            $table->text('diagnostico');
            $table->text('acciones');
            $table->text('observaciones');
            $table->integer('certificado')->nullable();
            $table->integer('atm')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('prioridad')->nullable();
			$table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
