<?php

namespace App\Http\Livewire;

use App\Models\Area;
use Livewire\Component;
use Livewire\WithPagination;

class AreasCursosController extends Component
{
    use WithPagination;

    public  $search, $selected_id;
    public $nombre, $estado;
    public  $pageTitle, $componentName;
    private $pagination = 5;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Areas de asignaturas';
        $this->selected_id = 0;
    }

    public function render()
    {
        $areas = Area::withCount('asignaturas')
            ->when($this->search, function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%');
            })->paginate($this->pagination);

        return view('livewire.areasCursos.component', [
            'areas' => $areas,
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
                'nombre' => 'required|unique:areas',
            ],
            [
                'nombre.required' => 'El nombre del área es requerido.',
                'nombre.unique' => 'Ya existe un registro con ese nombre.',
            ],
        );

        Area::create($validatedData);

        $this->resetUI();
        $this->emit('item-added', 'Area registrada');
    }
    public function Edit(Area $area)
    {
        $this->resetValidation();
        $this->selected_id = $area->id;
        $this->nombre = $area->nombre;
        $this->estado = $area->estado;

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $validatedData = $this->validate(
            [
                'nombre' => "required|unique:areas,nombre,{$this->selected_id}",
            ],
            [
                'nombre.required' => 'El nombre del área es requerido.',
                'nombre.unique' => 'Ya existe un registro con ese nombre.',
            ],
        );

        $area = Area::find($this->selected_id);

        $area->update($validatedData + ['estado' => $this->estado]);

        $this->resetUI();
        $this->emit('item-updated', 'Área actualizada');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Area $area)
    {
        $area->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Área eliminada');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->reset(['nombre', 'estado']);
        $this->resetValidation();
    }
}
