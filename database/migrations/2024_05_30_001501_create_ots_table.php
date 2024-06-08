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
        Schema::create('ots', function (Blueprint $table) {
            $table->id();
            $table->string('fecha')->nullable();
            $table->string('ticket')->nullable()->unique();
            $table->integer('cliente')->nullable();
            $table->integer('sucursal')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('elementos')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('acciones')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('materiales')->nullable();
            $table->integer('combustible')->nullable();
            $table->integer('certificado')->nullable();
            $table->integer('atm')->nullable();
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
        Schema::dropIfExists('ots');
    }
};
