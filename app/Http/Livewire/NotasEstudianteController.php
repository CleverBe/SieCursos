<?php

namespace App\Http\Livewire;

use App\Models\Alumno;
use App\Models\Horario;
use Livewire\Component;

class NotasEstudianteController extends Component
{
    public  $componentName;

    public Horario $horario_id;

    public function mount(Horario $horario_id)
    {
        $this->horario_id = $horario_id;
    }

    public function render()
    {
        $alumno_id = Auth()->user()->alumno->id;
        $estudiante = Alumno::join('alumno_horario as ah', 'ah.alumno_id', 'alumnos.id')
            ->join('horarios as h', 'ah.horario_id', 'h.id')
            ->join('asignaturas as a', 'h.asignatura_id', 'a.id')
            ->select(
                'a.nombre as nombreAsignatura',
                'alumnos.nombre as nombreEstudiante',
                'ah.primera_nota',
                'ah.segunda_nota',
                'ah.nota_final',
            )
            ->where('alumnos.id', $alumno_id)
            ->where('ah.horario_id', $this->horario_id->id)
            ->get()->first();

        return view('livewire.mis_notas.component', [
            'estudiante' => $estudiante
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
