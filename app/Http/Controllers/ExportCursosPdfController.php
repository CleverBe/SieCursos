<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Horario;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportCursosPdfController extends Controller
{
    public $periodoFiltro, $cursoFiltro, $horarioFiltro;

    public function reporte($periodoFiltro, $cursoFiltro = null, $horarioFiltro = null)
    {
        $this->periodoFiltro = $periodoFiltro;
        $this->cursoFiltro = $cursoFiltro;
        $this->horarioFiltro = $horarioFiltro;
        $data = [];

        $data = Alumno::join('users as u', 'alumnos.user_id', 'u.id')
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
            ->when($cursoFiltro, function ($query) {
                $query->where('a.id', $this->cursoFiltro);
            })
            ->when($horarioFiltro, function ($query) {
                $query->where('h.id', $this->horarioFiltro);
            })
            ->get();

        $nombreAsignatura = $cursoFiltro ? Asignatura::find($cursoFiltro)->nombre : 'Todos';

        if ($horarioFiltro) {
            $datos = Horario::with('aula')->where('id', $horarioFiltro)->get()->first();
            $horarioInfo = $datos->aula->codigo . ' ' . $datos->hora_inicio . '-' . $datos->hora_fin;
        } else {
            $horarioInfo = 'Todos';
        }
        $pdf = Pdf::loadView('livewire.pdf.reporteAlumno', compact('data', 'periodoFiltro', 'nombreAsignatura', 'horarioInfo'));

        return $pdf->stream('ReporteAlumnos.pdf');  // visualizar
    }
}
