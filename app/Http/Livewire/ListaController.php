<?php

namespace App\Http\Livewire;

use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\Horario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListaController extends Component
{
    public  $componentName, $fechaAsistencia;

    public Horario $horario_id;

    public $asistencias;

    public function mount(Horario $horario_id)
    {
        $this->horario_id = $horario_id;

        $this->componentName = 'Asistencias';

        $this->fechaAsistencia = Carbon::parse(Carbon::now())->format('Y-m-d');

        $this->asistencias = [];
    }

    public function render()
    {
        $alumnos = Asistencia::join('alumno_horario as ah', 'ah.id', 'asistencias.alumno_horario_id')
            ->join('alumnos as a', 'a.id', 'ah.alumno_id')
            ->select(
                'a.nombre',
                'asistencias.estado',
                'asistencias.id as idAsistencia',
            )
            ->where('ah.horario_id', $this->horario_id->id)
            ->where('asistencias.fecha_asistencia', $this->fechaAsistencia)
            ->get();

        return view('livewire.lista.component', [
            'alumnos' => $alumnos,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Agregar()
    {
        $asis = Asistencia::where('fecha_asistencia', $this->fechaAsistencia)->get();
        if ($asis) {
            $alumnos = Alumno::join('alumno_horario as ah', 'ah.alumno_id', 'alumnos.id')
                ->select('ah.id')
                ->where('ah.horario_id', $this->horario_id->id)
                ->get();
            foreach ($alumnos as $alumno) {
                Asistencia::create([
                    'estado' => 'NO ASISTIO',
                    'fecha_asistencia' => $this->fechaAsistencia,
                    'alumno_horario_id' => $alumno->id,
                ]);
            }
            $this->emit('item-message', 'Se generó la lista del dia seleccionado.');
        } else {
            $this->emit('item-message', 'Ya hay una lista del dia seleccionado.');
        }
    }

    public function cambiarEstado(Asistencia $asistencia)
    {
        $asistencia->update([
            'estado' => $asistencia->estado == 'ASISTIO' ? 'NO ASISTIO' : 'ASISTIO'
        ]);
        $this->emit('item-message', 'Cambio realizado');
    }

    public function Eliminar()
    {
        $asistencias = Asistencia::where('fecha_asistencia', $this->fechaAsistencia)->get();
        foreach ($asistencias as $asistencia) {
            $asistencia->delete();
        }
        $this->emit('item-message', 'Se eliminó la lista del dia seleccionado.');
    }

    public function verAsistencias()
    {
        $this->asistencias = Asistencia::join('alumno_horario as ah', 'ah.id', 'asistencias.alumno_horario_id')
            ->join('alumnos as a', 'a.id', 'ah.alumno_id')
            ->selectRaw("SUM(CASE WHEN asistencias.estado = 'ASISTIO' THEN 1  ELSE 0 END) AS ASISTENCIAS, " .
                "SUM(CASE WHEN asistencias.estado = 'NO ASISTIO' THEN 1 ELSE 0 END) AS FALTAS, a.nombre")
            ->groupBy('a.nombre')
            ->where('ah.horario_id', $this->horario_id->id)
            ->get();

        $this->emit('show-modal', 'show modal!');
    }

    protected $listeners = ['Agregar', 'Eliminar'];
}
