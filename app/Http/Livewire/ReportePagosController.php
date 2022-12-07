<?php

namespace App\Http\Livewire;

use App\Models\Asignatura;
use App\Models\Horario;
use App\Models\Pago;
use Carbon\Carbon;
use Livewire\Component;

class ReportePagosController extends Component
{
    public $componentName, $data, $reportType,
        $periodoFiltro, $dateFrom, $dateTo, $total;

    public $cursoFiltro, $horarioFiltro;

    public $cursos, $horarios;

    public function mount()
    {
        $this->componentName = 'Reporte de pagos';
        $this->data = [];
        $this->reportType = '0';
        $this->total = 0;
        $this->periodoFiltro = date('Y-m', time());
        $this->cursos = Asignatura::where('estado', 'ACTIVO')->get();
        $this->horarios = [];
        $this->dateFrom = Carbon::parse(Carbon::now())->format('d-m-Y');
        $this->dateTo = Carbon::parse(Carbon::now())->format('Y-m-d');
    }

    protected $queryString = [
        'periodoFiltro',
        'cursoFiltro' => ['except' => null],
        'horarioFiltro' => ['except' => null],
        'horarioFiltro' => ['except' => null],
        'reportType' => ['except' => '0'],
        'dateFrom',
        'dateTo',
    ];

    public function render()
    {
        $this->Consulta();

        if ($this->cursoFiltro) {
            $this->horarios = Horario::with('aula')->where('asignatura_id', $this->cursoFiltro)->get();
        }

        return view('livewire.reportePagos.component')
            ->extends('layouts.theme.app')
            ->section('content');
    }

    /* public function updatedCursoFiltro()
    {
        $this->horarios = Horario::with('aula')->where('asignatura_id', $this->cursoFiltro)->get();
    } */

    public function Consulta()
    {
        if ($this->reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
        }

        $this->data = Pago::join('alumno_horario as ah', 'ah.id', 'pagos.alumno_horario_id')
            ->join('horarios as h', 'ah.horario_id', 'h.id')
            ->join('alumnos as alu', 'ah.alumno_id', 'alu.id')
            ->join('asignaturas as a', 'h.asignatura_id', 'a.id')
            ->join('aulas as au', 'h.aula_id', 'au.id')
            ->select(
                'pagos.modulo',
                'pagos.monto',
                'pagos.fecha_pago',
                'pagos.mes_pago',
                'h.hora_inicio',
                'h.hora_fin',
                'a.nombre as nombreCurso',
                'au.codigo',
                'alu.nombre as nombreAlumno',
            )
            ->where('h.periodo', $this->periodoFiltro)
            ->when($this->cursoFiltro, function ($query) {
                $query->where('a.id', $this->cursoFiltro);
            })
            ->when($this->horarioFiltro, function ($query) {
                $query->where('h.id', $this->horarioFiltro);
            })
            ->whereBetween('pagos.fecha_pago', [$from, $to])
            ->get();
        $this->total = count($this->data) > 0 ? $this->data->sum('monto') : 0;
    }
}
