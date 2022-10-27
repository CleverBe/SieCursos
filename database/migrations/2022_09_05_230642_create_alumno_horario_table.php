<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnoHorarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno_horario', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_inscripcion');
            $table->integer('primera_nota')->default(0);
            $table->integer('segunda_nota')->default(0);
            $table->decimal('nota_final', 10, 2)->default(0);
            $table->enum('estado', ['VIGENTE', 'FINALIZADO'])->default('VIGENTE');
            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumnos');
            $table->unsignedBigInteger('horario_id');
            $table->foreign('horario_id')->references('id')->on('horarios');
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
        Schema::dropIfExists('alumno_horario');
    }
}
