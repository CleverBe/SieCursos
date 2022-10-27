<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->enum('estado', ['ASISTIO', 'NO ASISTIO'])->default('NO ASISTIO');
            $table->date('fecha_asistencia');
            $table->unsignedBigInteger('alumno_horario_id');
            $table->foreign('alumno_horario_id')->references('id')->on('alumno_horario');
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
        Schema::dropIfExists('asistencias');
    }
}
