<?php

namespace App\Http\Livewire;

use App\Models\Alumno;
use App\Models\Horario;
use App\Models\Material;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class InicioCursoController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public  $search;
    public  $pageTitle, $componentName, $selected_id;

    public $asignatura, $hora_inicio, $hora_fin, $professor, $descripcion;

    public $nombre, $material, $comentario;

    public Horario $horario_id;

    protected $paginationTheme = 'bootstrap';

    public function mount(Horario $horario_id)
    {
        $this->horario_id = $horario_id;
        $this->componentName = 'Material';
        $this->selected_id = 0;

        $this->asignatura = $this->horario_id->asignatura->nombre;
        $this->professor = $this->horario_id->professor->nombre;
        $this->hora_inicio = $this->horario_id->hora_inicio;
        $this->hora_fin = $this->horario_id->hora_fin;
        $this->descripcion = $this->horario_id->asignatura->descripcion;
    }

    public function render()
    {
        $materiales = $this->horario_id->materials;

        if (auth()->user()->profile == 'STUDENT') {
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
        } else {
            $estudiante = [];
        }

        return view('livewire.inicioCurso.component', [
            'materiales' => $materiales,
            'estudiante' => $estudiante
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Agregar()
    {
        $this->emit('show-modal', 'show modal!');
        if ($this->selected_id != 0) {
            $this->resetUI();
        }
    }

    public function Store()
    {
        $rules = [
            'nombre' => 'required',
            'material' => 'required',
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'material.required' => 'No se ha seleccionado ningun archivo.',
        ];
        $this->validate($rules, $messages);

        $filename = pathinfo($this->material->getClientOriginalName(), PATHINFO_FILENAME);
        $customFileName = $filename . '_' . rand(1, 9999) . '.' . $this->material->extension();
        $this->material->storeAs('public/material', $customFileName);

        Material::create([
            'nombre' => $this->nombre,
            'nombre_archivo' => $customFileName,
            'comentario' => $this->comentario,
            'materialable_id' => $this->horario_id->id,
            'materialable_type' => 'App\Models\Horario',
            'user_id' => Auth()->user()->id,
        ]);

        $this->resetUI();
        $this->redirect($this->horario_id->id);
        $this->emit('item-added', 'Archivo subido exitosamente');
    }

    public function Edit(Material $material)
    {
        $this->resetValidation();
        $this->selected_id = $material->id;
        $this->nombre = $material->nombre;
        $this->comentario = $material->comentario;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'nombre' => 'required',
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
        ];
        $this->validate($rules, $messages);

        $material = Material::find($this->selected_id);

        $material->update([
            'nombre' => $this->nombre,
            'comentario' => $this->comentario,
        ]);

        if ($this->material) {
            $filename = pathinfo($this->material->getClientOriginalName(), PATHINFO_FILENAME);
            $customFileName = $filename . '_' . rand(1, 9999) . '.' . $this->material->extension();
            $this->material->storeAs('public/material', $customFileName);
            $archivoTemp = $material->nombre_archivo;
            $material->nombre_archivo = $customFileName;
            $material->save();

            if (file_exists('storage/material/' . $archivoTemp)) {
                unlink('storage/material/' . $archivoTemp);
            }
        }

        $this->resetUI();
        $this->redirect($this->horario_id->id);
        $this->emit('item-updated', 'Datos actualizados');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Material $material)
    {
        $material->delete();
        $this->resetUI();
        $this->redirect($this->horario_id->id);
        $this->emit('item-deleted', 'Archivo eliminado');
    }

    public function export($nombre)
    {
        return response()->download(public_path('storage/material/' . $nombre));
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->reset(['nombre', 'comentario', 'material']);
        $this->resetValidation();
    }
}
