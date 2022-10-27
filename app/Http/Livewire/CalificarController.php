<?php

namespace App\Http\Livewire;

use App\Models\Alumno;
use App\Models\AlumnoHorario;
use App\Models\Horario;
use Livewire\Component;

class CalificarController extends Component
{
    public  $search, $selected_id;
    public  $pageTitle, $componentName;
    public $primera_nota, $segunda_nota;

    public Horario $horario_id;

    protected $paginationTheme = 'bootstrap';

    public function mount(Horario $horario_id)
    {
        $this->horario_id = $horario_id;
        $this->pageTitle = 'Listado';
        $this->componentName = 'Profesores';
        $this->selected_id = 0;
    }

    public function render()
    {
        $alumnos = Alumno::join('alumno_horario as ah', 'ah.alumno_id', 'alumnos.id')
            ->select(
                'alumnos.nombre',
                'ah.id as idAlumnoHorario',
                'ah.primera_nota',
                'ah.segunda_nota',
                'ah.nota_final',
            )
            ->where('ah.horario_id', $this->horario_id->id)
            ->get();

        return view('livewire.calificar.component', [
            'alumnos' => $alumnos
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function Edit(AlumnoHorario $alumnoHorario)
    {
        $this->resetValidation();
        $this->selected_id = $alumnoHorario->id;
        $this->primera_nota = $alumnoHorario->primera_nota;
        $this->segunda_nota = $alumnoHorario->segunda_nota;

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'primera_nota' => 'required|integer',
            'segunda_nota' => 'required|integer',
        ];
        $messages = [
            'primera_nota.required' => 'La nota es requerida.',
            'primera_nota.integer' => 'La nota debe ser un número.',
            'segunda_nota.required' => 'La nota es requerida.',
            'segunda_nota.integer' => 'La nota debe ser un número.',
        ];
        $this->validate($rules, $messages);

        $alumnoHorario = AlumnoHorario::find($this->selected_id);
        $alumnoHorario->update([
            'primera_nota' => $this->primera_nota,
            'segunda_nota' => $this->segunda_nota,
            'nota_final' => ($this->primera_nota + $this->segunda_nota) / 2,
        ]);
        $this->resetUI();
        $this->emit('item-updated', 'Se actualizó correctamente');
    }

    public function resetUI()
    {
        $this->reset(['primera_nota', 'segunda_nota']);
        $this->selected_id = 0;
    }
}
