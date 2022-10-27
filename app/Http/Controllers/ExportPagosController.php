<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Horario;
use App\Models\Pago;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ExportPagosController extends Controller
{
    public $periodoFiltro, $cursoFiltro, $horarioFiltro;

    public function reporte($periodoFiltro, $reportType, $dateFrom = null, $dateTo = null, $cursoFiltro = null, $horarioFiltro = null)
    {
        $this->periodoFiltro = $periodoFiltro;
        $this->cursoFiltro = $cursoFiltro;
        $this->horarioFiltro = $cursoFiltro;

        if ($reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($dateTo)->format('Y-m-d')     . ' 23:59:59';
        }

        $data = [];

        $data = Pago::join('alumno_horario as ah', 'ah.id', 'pagos.alumno_horario_id')
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

        $nombreAsignatura = $cursoFiltro ? Asignatura::find($cursoFiltro)->nombre : 'Todos';

        if ($horarioFiltro) {
            $datos = Horario::with('aula')->where('id', $horarioFiltro)->get()->first();
            $horarioInfo = $datos->aula->codigo . ' ' . $datos->hora_inicio . '-' . $datos->hora_fin;
        } else {
            $horarioInfo = 'Todos';
        }

        $pdf = Pdf::loadView('livewire.pdf.reportePagos', compact('data', 'periodoFiltro', 'nombreAsignatura', 'horarioInfo', 'reportType', 'dateFrom', 'dateTo'));

        return $pdf->stream('ReportePagos.pdf');  // visualizar
    }
}
