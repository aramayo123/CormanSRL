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
        Schema::create('materiales_gastados', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('material_id');
			$table->unsignedBigInteger('tarea_id');
			$table->integer('unidades');
            $table->float('precio', 2);
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
        Schema::dropIfExists('materiales_gastados');
    }
};
