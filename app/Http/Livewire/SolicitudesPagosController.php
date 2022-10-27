<?php

namespace App\Http\Livewire;

use App\Models\SolicitudPago;
use Livewire\Component;
use Livewire\WithPagination;

class SolicitudesPagosController extends Component
{
    use WithPagination;

    public  $search, $selected_id;
    public  $pageTitle, $componentName;
    public $comentarios;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Solicitudes de pago';
        $this->selected_id = 0;
    }

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $solicitudes = SolicitudPago::join('pagos as p', 'solicitud_pagos.pago_id', 'p.id')
            ->join('alumno_horario as ah', 'p.alumno_horario_id', 'ah.id')
            ->join('alumnos as a', 'ah.alumno_id', 'a.id')
            ->join('horarios as h', 'ah.horario_id', 'h.id')
            ->join('asignaturas as asig', 'h.asignatura_id', 'asig.id')
            ->select(
                'solicitud_pagos.id',
                'solicitud_pagos.comprobante',
                'solicitud_pagos.fecha_transferencia',
                'solicitud_pagos.created_at',
                'solicitud_pagos.estado',
                'solicitud_pagos.comentarios',
                'solicitud_pagos.telefono_solicitante',
                'a.nombre',
                'asig.nombre as asignatura',
                'h.periodo',
                'h.hora_inicio',
                'h.hora_fin',
                'ah.id as alumnoHorarioID',
            )
            ->get();
        return view('livewire.solicitudesPagos.component', [
            'solicitudes' => $solicitudes,
        ])->extends('layouts.theme.app')
            ->section('content');
    }
    public function Observaciones(SolicitudPago $solicitud)
    {
        $this->comentarios = $solicitud->comentarios;
        $this->emit('show-modalObservaciones', 'show modal!');
    }
}
