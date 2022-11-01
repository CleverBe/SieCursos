<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->string('lunes', 255);
            $table->string('martes', 255);
            $table->string('miercoles', 255);
            $table->string('jueves', 255);
            $table->string('viernes', 255);
            $table->string('sabado', 255);
            $table->string('domingo', 255);
            $table->enum('modalidad', ['VIRTUAL', 'PRESENCIAL']);
            $table->string('periodo', 255);
            $table->string('hora_inicio');
            $table->string('hora_fin');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('dia_de_cobro');
            $table->integer('horas_capacitacion');
            $table->integer('costo_curso');
            $table->integer('costo_matricula');
            $table->integer('duracion_meses');
            $table->integer('pago_cuota');
            $table->enum('estado', ['VIGENTE', 'FINALIZADO'])->default('VIGENTE');
            $table->unsignedBigInteger('aula_id');
            $table->foreign('aula_id')->references('id')->on('aulas');
            $table->unsignedBigInteger('professor_id');
            $table->foreign('professor_id')->references('id')->on('professors');
            $table->unsignedBigInteger('asignatura_id');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas');
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
        Schema::dropIfExists('horarios');
    }
}
