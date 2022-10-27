<?php

namespace App\Http\Livewire;

use App\Models\Horario;
use App\Models\User;
use Livewire\Component;

class InicioAulasController extends Component
{
    public  $search, $selected_id;
    public  $pageTitle, $componentName;

    public $estadoFiltro;

    private $pagination = 5;

    public function mount()
    {
        $this->selected_id = 0;
    }

    public function render()
    {
        $user_id = Auth()->user()->id;
        $professorAuth = User::where('profile', 'PROFESSOR')
            ->where('id', $user_id)->get()->first();
        if ($professorAuth) {
            $professor_id = Auth()->user()->professor->id;
            $horariosActuales = Horario::where('professor_id', $professor_id)
                ->where('estado', 'VIGENTE')
                ->paginate($this->pagination);
            $horariosPasados = Horario::where('professor_id', $professor_id)
                ->where('estado', 'FINALIZADO')
                ->paginate($this->pagination);
        } else {
            $alumno_id = Auth()->user()->alumno->id;
            $horariosActuales = Horario::join('alumno_horario as ah', 'ah.horario_id', 'horarios.id')
                ->select('horarios.*')
                ->where('ah.alumno_id', $alumno_id)
                ->where('ah.estado', 'VIGENTE')
                ->paginate($this->pagination);
            $horariosPasados = Horario::join('alumno_horario as ah', 'ah.horario_id', 'horarios.id')
                ->select('horarios.*')
                ->where('ah.alumno_id', $alumno_id)
                ->where('ah.estado', 'FINALIZADO')
                ->paginate($this->pagination);
        }
        $horariosDisponibles = Horario::with('asignatura')->where('estado', 'VIGENTE')->paginate($this->pagination);
        $horariosProximos = Horario::with('asignatura')->where('estado', 'PROXIMO')->paginate($this->pagination);

        return view('livewire.inicioAulas.component', [
            'horariosActuales' => $horariosActuales,
            'horariosDisponibles' => $horariosDisponibles,
            'horariosPasados' => $horariosPasados,
            'horariosProximos' => $horariosProximos,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
