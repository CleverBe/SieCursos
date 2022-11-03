<?php

namespace App\Http\Livewire;

use App\Models\Area;
use App\Models\Asignatura;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CursosController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $selected_id;
    public  $pageTitle, $componentName;
    public $nombre, $descripcion, $duracion, $costo, $estado, $image, $area_id = 'Elegir';
    private $pagination = 5;
    public $areaFiltro, $areas;

    public $matricula;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Cursos';
        $this->selected_id = 0;
        $this->areas = Area::where('estado', 'ACTIVO')->get();
        $this->matricula = 100;
    }
    // resetear paginacion cuando se busca un elemento en otra pagina que no sea la primera
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $asignaturas = Asignatura::with('area')->withCount('horarios')
            ->when($this->search, function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->when($this->areaFiltro, function ($query) {
                $query->whereRelation('area', 'id', $this->areaFiltro);
            })
            ->paginate($this->pagination);

        return view('livewire.cursos.component', [
            'asignaturas' => $asignaturas,
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
        $validatedData = $this->validate(
            [
                'nombre' => 'required|unique:asignaturas',
                'descripcion' => 'nullable|min:5',
                'duracion' => 'required',
                'costo' => 'required',
                'area_id' => 'not_in:Elegir',
                'matricula' => 'required',
            ],
            [
                'nombre.required' => 'El nombre del curso es requerido.',
                'nombre.unique' => 'Ya existe un registro con ese nombre.',
                'descripcion.min' => 'La descripción debe contener minimo 5 caracteres.',
                'duracion.required' => 'La duracion es requerida.',
                'costo.required' => 'El costo es requerido.',
                'area_id.not_in' => 'Seleccione un área distinto a Elegir',
                'matricula.required' => 'La matrícula es requerida.',
            ],
        );

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/asignaturas', $customFileName);
        } else {
            $customFileName = 'noimage.jpg';
        }

        Asignatura::create($validatedData + ['image' => $customFileName]);

        $this->resetUI();
        $this->emit('item-added', 'Asignatura registrada');
    }

    public function Edit(Asignatura $asignatura)
    {
        $this->resetUI();
        $this->selected_id = $asignatura->id;
        $this->nombre = $asignatura->nombre;
        $this->descripcion = $asignatura->descripcion;
        $this->duracion = $asignatura->duracion;
        $this->costo = $asignatura->costo;
        $this->area_id = $asignatura->area_id;
        $this->estado = $asignatura->estado;
        $this->matricula = $asignatura->matricula;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $validatedData = $this->validate(
            [
                'nombre' => "required|unique:asignaturas,nombre,{$this->selected_id}",
                'descripcion' => 'nullable|min:5',
                'duracion' => 'required',
                'costo' => 'required',
                'area_id' => 'not_in:Elegir',
                'matricula' => 'required',
            ],
            [
                'nombre.required' => 'El nombre del curso es requerido.',
                'nombre.unique' => 'Ya existe un registro con ese nombre.',
                'descripcion.min' => 'La descripción debe contener minimo 5 caracteres.',
                'duracion.required' => 'La duracion es requerida.',
                'costo.required' => 'El costo es requerido.',
                'area_id.not_in' => 'Seleccione un área distinto a Elegir.',
                'matricula.required' => 'La matrícula es requerida.',
            ],
        );

        $asignatura = Asignatura::find($this->selected_id);

        $asignatura->update($validatedData + ['estado' => $this->estado]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/asignaturas', $customFileName);
            $imageTemp = $asignatura->image;
            $asignatura->image = $customFileName;
            $asignatura->save();

            if ($imageTemp != 'noimage.jpg') {
                if (file_exists('storage/asignaturas/' . $imageTemp)) {
                    unlink('storage/asignaturas/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated', 'Asignatura actualizada');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Asignatura $asignatura)
    {
        $imageName = $asignatura->image;
        if ($imageName != null) {
            unlink('storage/asignaturas/' . $imageName);
        }
        $asignatura->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Asignatura eliminada');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->reset(['nombre', 'descripcion', 'duracion', 'costo', 'estado', 'area_id', 'image']);
        $this->resetValidation();
    }
}
