<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string('modulo', 255);
            $table->decimal('monto', 10, 2);
            $table->dateTime('fecha_pago')->nullable();
            $table->date('fecha_limite');
            $table->decimal('a_pagar', 10, 2);
            $table->string('mes_pago', 255)->nullable();
            $table->string('comprobante', 255)->nullable();
            $table->string('observaciones', 255)->nullable();
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
        Schema::dropIfExists('pagos');
    }
}
