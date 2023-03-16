<?php

namespace App\Http\Livewire;

use App\Models\Pago;
use App\Models\SolicitudPago;
use Carbon\Carbon;
use Livewire\Component;

class SolicitudController extends Component
{
    public  $componentName;

    public SolicitudPago $solicitud_id;

    public $alumno;

    public $nombre_solicitante, $telefono_solicitante, $comprobante, $fecha_transferencia,
        $comentarios, $estado, $moduloSolicitud;

    public $pagos;

    public function mount(SolicitudPago $solicitud_id)
    {
        $this->solicitud_id = $solicitud_id;
        $this->alumno = SolicitudPago::join('pagos as p', 'solicitud_pagos.pago_id', 'p.id')
            ->join('alumno_horario as ah', 'p.alumno_horario_id', 'ah.id')
            ->select('ah.alumno_id')
            ->where('solicitud_pagos.id', $solicitud_id->id)
            ->get()->first();
        $this->moduloSolicitud = $this->solicitud_id->pago->modulo;
        $this->nombre_solicitante = $this->solicitud_id->nombre_solicitante;
        $this->telefono_solicitante = $this->solicitud_id->telefono_solicitante;
        $this->comprobante = $this->solicitud_id->comprobante;
        $this->fecha_transferencia = $this->solicitud_id->fecha_transferencia;
        $this->comentarios = $this->solicitud_id->comentarios;
        $this->estado = $this->solicitud_id->estado;

        $this->componentName = 'Solicitud';
        $this->pagos = [];
    }

    public function render()
    {
        $this->pagosListado();

        return view('livewire.solicitudEstudiante.component')
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function pagosListado()
    {
        $this->pagos = Pago::join('alumno_horario as ah', 'pagos.alumno_horario_id', 'ah.id')
            ->select('pagos.*')
            ->where('ah.alumno_id', $this->alumno->alumno_id)
            ->get();
    }

    public function aprobar()
    {
        $this->solicitud_id->estado = 'APROBADO';
        $this->solicitud_id->save();

        $pago = Pago::find($this->solicitud_id->pago_id);
        $pago->update([
            'monto' => $pago->a_pagar,
            'comprobante' => $this->comprobante,
            'fecha_pago' => Carbon::parse(Carbon::now()),
        ]);
        $this->redirect($this->solicitud_id->id);
        $this->emitTo('header-component', 'render');
        $this->emit('item-updated', 'Se aprobó la solicitud');
    }

    public function rechazar()
    {
        $this->solicitud_id->estado = 'RECHAZADO';
        $this->solicitud_id->save();
        $this->redirect($this->solicitud_id->id);
        $this->emitTo('header-component', 'render');
        $this->emit('item-updated', 'Se rechazó la solicitud');
    }

    public function export($nombre)
    {
        $this->exportar($nombre);
        $this->redirect($this->solicitud_id->id);
    }
    
    public function exportar($nombre)
    {
        return response()->download(storage_path('app/public/pagos/' . $nombre));
    }

    protected $listeners = ['aprobar', 'rechazar'];
}
