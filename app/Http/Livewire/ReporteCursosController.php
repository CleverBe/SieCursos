<?php

namespace App\Http\Livewire;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Horario;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteCursosController extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails, $reportType,
        $userId, $periodoFiltro, $saleId;

    public $cursoFiltro, $horarioFiltro;

    public $cursos, $horarios;

    public function mount()
    {
        $this->componentName = 'Reporte de estudiantes';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->saleId = 0;
        $this->periodoFiltro = date('Y-m', time());
        $this->cursos = Asignatura::where('estado', 'ACTIVO')->get();
        $this->horarios = [];
    }

    public function render()
    {
        $this->Consulta();

        return view('livewire.reporteCursos.component')
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function updatedCursoFiltro()
    {
        $this->horarios = Horario::with('aula')->where('asignatura_id', $this->cursoFiltro)->get();
    }

    public function Consulta()
    {
        $this->data = Alumno::join('users as u', 'alumnos.user_id', 'u.id')
            ->join('alumno_horario as ah', 'ah.alumno_id', 'alumnos.id')
            ->join('horarios as h', 'ah.horario_id', 'h.id')
            ->join('asignaturas as a', 'h.asignatura_id', 'a.id')
            ->join('aulas as au', 'h.aula_id', 'au.id')
            ->select(
                'alumnos.id as idAlumno',
                'alumnos.nombre as nombreAlumno',
                'alumnos.telefono',
                'u.email',
                'u.cedula',
                'a.id as idAsignatura',
                'a.nombre as nombreAsignatura',
                'h.id as idHorario',
                'h.periodo',
                'h.hora_inicio',
                'h.hora_fin',
                'a.costo',
                'ah.id as idAlumno_horario',
                'ah.fecha_inscripcion',
                'au.codigo',
            )
            ->where('h.periodo', $this->periodoFiltro)
            ->when($this->cursoFiltro, function ($query) {
                $query->where('a.id', $this->cursoFiltro);
            })
            ->when($this->horarioFiltro, function ($query) {
                $query->where('h.id', $this->horarioFiltro);
            })
            ->get();
    }

    /* public function getDetails($saleId)
    {
        $this->details = SaleDetail::join('products as p', 'p.id', 'sale_details.product_id')
            ->select('sale_details.id', 'sale_details.price', 'sale_details.quantity', 'p.name as product')
            ->where('sale_details.sale_id', $saleId)
            ->get();

        //
        $suma = $this->details->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $this->sumDetails = $suma;
        $this->countDetails = $this->details->sum('quantity');
        $this->saleId = $saleId;

        $this->emit('show-modal', 'details loaded');
    } */
}
