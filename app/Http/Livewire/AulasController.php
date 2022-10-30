<?php

namespace App\Http\Livewire;

use App\Models\Aula;
use Livewire\Component;
use Livewire\WithPagination;

class AulasController extends Component
{
    use WithPagination;

    public  $search, $selected_id;
    public $codigo, $capacidad, $estado;
    public  $pageTitle, $componentName;
    private $pagination = 5;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Aulas';
        $this->selected_id = 0;
    }

    public function render()
    {
        $aulas = Aula::withCount('horarios')
            ->when($this->search, function ($query) {
                $query->where('codigo', 'like', '%' . $this->search . '%');
            })->paginate($this->pagination);

        return view('livewire.aulas.component', [
            'aulas' => $aulas,
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
                'codigo' => 'required|unique:aulas',
                'capacidad' => 'required|integer'
            ],
            [
                'codigo.required' => 'El código del aula es requerido.',
                'codigo.unique' => 'Ya existe un aula con ese código.',
                'capacidad.required' => 'La capacidad del aula es requerido.',
                'capacidad.integer' => 'La capacidad debe ser un número.',
            ],
        );

        Aula::create($validatedData);

        $this->resetUI();
        $this->emit('item-added', 'Aula registrada');
    }
    public function Edit(Aula $aula)
    {
        $this->resetValidation();
        $this->selected_id = $aula->id;
        $this->codigo = $aula->codigo;
        $this->capacidad = $aula->capacidad;
        $this->estado = $aula->estado;

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $validatedData = $this->validate(
            [
                'codigo' => "required|unique:aulas,codigo,{$this->selected_id}",
                'capacidad' => 'required|integer',
            ],
            [
                'codigo.required' => 'El código del aula es requerido.',
                'codigo.unique' => 'Ya existe un aula con ese código.',
                'capacidad.required' => 'La capacidad del aula es requerido.',
                'capacidad.integer' => 'La capacidad debe ser un número.',
            ],
        );

        $aula = Aula::find($this->selected_id);

        $aula->update($validatedData + ['estado' => $this->estado]);

        $this->resetUI();
        $this->emit('item-updated', 'Aula actualizada');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Aula $aula)
    {
        $aula->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Aula eliminada');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->reset(['codigo', 'capacidad', 'estado']);
        $this->resetValidation();
    }
}
