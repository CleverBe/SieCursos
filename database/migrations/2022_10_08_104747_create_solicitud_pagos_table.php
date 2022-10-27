<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_solicitante', 255);
            $table->string('telefono_solicitante', 255);
            $table->string('comprobante', 255);
            $table->dateTime('fecha_transferencia');
            $table->string('comentarios', 255);
            $table->enum('estado', ['PENDIENTE', 'APROBADO', 'RECHAZADO'])->default('PENDIENTE');
            $table->enum('visto_Admin', ['SI', 'NO'])->default('NO');
            $table->enum('visto_Student', ['SI', 'NO'])->default('NO');
            $table->unsignedBigInteger('pago_id');
            $table->foreign('pago_id')->references('id')->on('pagos');
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
        Schema::dropIfExists('solicitud_pagos');
    }
}
