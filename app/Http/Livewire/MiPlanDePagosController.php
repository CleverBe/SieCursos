<?php

namespace App\Http\Livewire;

use App\Models\Alumno;
use App\Models\AlumnoHorario;
use App\Models\Horario;
use App\Models\Pago;
use App\Models\SolicitudPago;
use Livewire\Component;
use Livewire\WithFileUploads;

class MiPlanDePagosController extends Component
{
    use WithFileUploads;

    public $selected_id;

    public $telefono_solicitante,
        $comprobante,
        $fecha_transferencia,
        $comentarios;

    public Horario $horario_id;

    public $alumnosHorario;

    public $solicitudes = [];
    public $mensajes = [];

    public $solicitud_id;
    public $messageText;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount(Horario $horario_id)
    {
        $this->horario_id = $horario_id;
        $this->selected_id = 0;
        $this->solicitud_id = 0;
    }

    public function render()
    {
        $alumno_id = Auth()->user()->alumno->id;
        $misPagos = Alumno::join('alumno_horario as ah', 'ah.alumno_id', 'alumnos.id')
            ->join('pagos as p', 'p.alumno_horario_id', 'ah.id')
            ->select(
                'p.id as id_pago',
                'p.modulo',
                'p.monto',
                'p.fecha_pago',
                'p.fecha_limite',
                'p.a_pagar',
                'p.mes_pago',
                'p.comprobante',
                'ah.id as AlumnoHorarioID',
            )
            ->where('alumnos.id', $alumno_id)
            ->where('ah.horario_id', $this->horario_id->id)
            ->get();
        $this->alumnosHorario = AlumnoHorario::where('horario_id', $this->horario_id->id)
            ->where('alumno_id', $alumno_id)
            ->first();

        return view('livewire.mi_plan_pagos.component', [
            'misPagos' => $misPagos
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function ListadoSolicitudes(AlumnoHorario $alumnoHorario)
    {
        $this->solicitudes = SolicitudPago::join('pagos as p', 'solicitud_pagos.pago_id', 'p.id')
            ->where('p.alumno_horario_id', $alumnoHorario->id)
            ->select('solicitud_pagos.*')
            ->get();
        $this->emit('show-modalSolicitudes', 'show modal!');
    }

    public function export($nombre)
    {
        return response()->download(public_path('storage/pagos/' . $nombre));
    }

    public function SolicitarPago(Pago $pago)
    {
        $this->resetUI();
        $this->selected_id = $pago->id;
        $this->emit('show-modal', 'show modal!');
    }

    public function Store()
    {
        $rules = [
            'telefono_solicitante' => 'required',
            'comprobante' => 'required',
            'fecha_transferencia' => 'required',
            'comentarios' => 'required',
        ];
        $messages = [
            'telefono_solicitante.required' => 'El teléfono es requerido.',
            'comprobante.required' => 'El comprobante es requerido.',
            'fecha_transferencia.required' => 'La fecha de la transferncia es requerida.',
            'comentarios.required' => 'Este campo es obligatorio.',
        ];
        $this->validate($rules, $messages);

        $customFileName = uniqid() . '.' . $this->comprobante->extension();
        $this->comprobante->storeAs('public/pagos', $customFileName);

        SolicitudPago::create([
            'nombre_solicitante' => Auth()->user()->alumno->nombre,
            'telefono_solicitante' => $this->telefono_solicitante,
            'comprobante' => $customFileName,
            'fecha_transferencia' => $this->fecha_transferencia,
            'comentarios' => $this->comentarios,
            'pago_id' => $this->selected_id
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Solicitud enviada');
    }

    public function Observaciones(SolicitudPago $solicitud)
    {
        $this->comentarios = $solicitud->comentarios;
        $this->emit('show-modalObservaciones', 'show modal!');
    }
    public function resetUI()
    {
        $this->reset([
            'telefono_solicitante', 'comprobante', 'fecha_transferencia', 'comentarios',
        ]);
        $this->resetValidation();
    }
}
