<?php

namespace App\Http\Livewire;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Horario;
use Livewire\Component;

class ReporteCursosController extends Component
{
    public $componentName, $data, $reportType, $promedioNotas;

    public $cursoFiltro, $horarioFiltro, $periodoFiltro;

    public $cursos, $horarios;

    public function mount()
    {
        $this->componentName = 'Reporte de estudiantes';
        $this->data = [];
        $this->reportType = 0;
        $this->promedioNotas = 0;
        $this->periodoFiltro = date('Y-m', time());
        $this->cursos = Asignatura::where('estado', 'ACTIVO')->get();
        $this->horarios = [];
    }

    protected $queryString = [
        'periodoFiltro',
        'cursoFiltro' => ['except' => null],
        'horarioFiltro' => ['except' => null],
    ];

    public function render()
    {
        $this->Consulta();

        return view('livewire.reporteCursos.component')
            ->extends('layouts.theme.app')
            ->section('content');
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
                'ah.id as idAlumno_horario',
                'ah.primera_nota',
                'ah.segunda_nota',
                'ah.nota_final',
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

        $this->promedioNotas = count($this->data) > 0 ? $this->data->sum('nota_final') / count($this->data) : 0;

        if ($this->cursoFiltro) {
            $this->horarios = Horario::with('aula')->where('asignatura_id', $this->cursoFiltro)->get();
        }
    }
}
