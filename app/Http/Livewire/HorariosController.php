<?php

namespace App\Http\Livewire;

use App\Models\AlumnoHorario;
use App\Models\Asignatura;
use App\Models\Aula;
use App\Models\Horario;
use App\Models\Pago;
use App\Models\Professor;
use Livewire\Component;
use Livewire\WithPagination;

class HorariosController extends Component
{
    use WithPagination;

    public  $search, $selected_id = 0;
    public  $pageTitle = 'Listado', $componentName = 'Horarios';

    public $asignatura = 'Elegir', $aula = 'Elegir', $modalidad = 'PRESENCIAL', $profesor = 'Elegir',
        $periodo, $dias = 'No', $lunes = false, $martes = false, $miercoles = false, $jueves = false,
        $viernes = false, $sabado = false, $domingo = false, $hora_inicio, $hora_fin, $fecha_inicio,
        $fecha_fin, $estado = 'VIGENTE', $dia_de_cobro;

    public $respuesta = 'Si', $resultado = 'Si';

    public $filtroEstado = 'VIGENTE', $cursoFiltro, $periodoFiltro;

    public $listadoEstudiantes = [], $select_horario = 0;

    public $asignaturas, $aulas, $profesores;

    private $pagination = 10;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->periodoFiltro = date('Y-m', time());

        $this->asignaturas = Asignatura::where('estado', 'ACTIVO')->get();
        $this->aulas = Aula::where('estado', 'ACTIVO')->get();
        $this->profesores = Professor::with('user')
            ->whereRelation('user', 'status', 'ACTIVE')->get();
    }

    public function render()
    {
        $horarios = Horario::with('asignatura', 'aula', 'professor')
            ->when($this->search, function ($query) {
                $query->where(function ($query2) {
                    $query2->whereRelation('professor', 'nombre', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->cursoFiltro, function ($query) {
                $query->where('asignatura_id', $this->cursoFiltro);
            })
            ->when($this->filtroEstado, function ($query) {
                $query->where('estado', $this->filtroEstado);
            })
            ->where('periodo', $this->periodoFiltro)
            ->addSelect([
                'cantidadAlumnos' => AlumnoHorario::selectRaw('COUNT(*)')
                    ->whereColumn('alumno_horario.horario_id', 'horarios.id')
            ])
            ->paginate($this->pagination);

        return view('livewire.horarios.component', [
            'horarios' => $horarios,
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
        if ($this->lunes || $this->martes || $this->miercoles || $this->jueves || $this->viernes || $this->sabado || $this->domingo) {
            $this->dias = 'Si';
        } else {
            $this->dias = 'No';
        }

        $horariosAulas = Horario::where('aula_id', $this->aula)->get();
        $this->respuesta = 'Si';

        foreach ($horariosAulas as $horarioAula) {
            if ($this->lunes) {
                if ($this->hora_inicio >= $horarioAula->hora_inicio && $this->hora_inicio <= $horarioAula->hora_fin) {
                    if ($horarioAula->lunes != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioAula->hora_inicio && $this->hora_fin <= $horarioAula->hora_fin) {
                    if ($horarioAula->lunes != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
            }
            if ($this->martes) {
                if ($this->hora_inicio >= $horarioAula->hora_inicio && $this->hora_inicio <= $horarioAula->hora_fin) {
                    if ($horarioAula->martes != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioAula->hora_inicio && $this->hora_fin <= $horarioAula->hora_fin) {
                    if ($horarioAula->martes != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
            }
            if ($this->miercoles) {
                if ($this->hora_inicio >= $horarioAula->hora_inicio && $this->hora_inicio <= $horarioAula->hora_fin) {
                    if ($horarioAula->miercoles != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioAula->hora_inicio && $this->hora_fin <= $horarioAula->hora_fin) {
                    if ($horarioAula->miercoles != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
            }
            if ($this->jueves) {
                if ($this->hora_inicio >= $horarioAula->hora_inicio && $this->hora_inicio <= $horarioAula->hora_fin) {
                    if ($horarioAula->jueves != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioAula->hora_inicio && $this->hora_fin <= $horarioAula->hora_fin) {
                    if ($horarioAula->jueves != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
            }
            if ($this->viernes) {
                if ($this->hora_inicio >= $horarioAula->hora_inicio && $this->hora_inicio <= $horarioAula->hora_fin) {
                    if ($horarioAula->viernes != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioAula->hora_inicio && $this->hora_fin <= $horarioAula->hora_fin) {
                    if ($horarioAula->viernes != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
            }
            if ($this->sabado) {
                if ($this->hora_inicio >= $horarioAula->hora_inicio && $this->hora_inicio <= $horarioAula->hora_fin) {
                    if ($horarioAula->sabado != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioAula->hora_inicio && $this->hora_fin <= $horarioAula->hora_fin) {
                    if ($horarioAula->sabado != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
            }
            if ($this->domingo) {
                if ($this->hora_inicio >= $horarioAula->hora_inicio && $this->hora_inicio <= $horarioAula->hora_fin) {
                    if ($horarioAula->domingo != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioAula->hora_inicio && $this->hora_fin <= $horarioAula->hora_fin) {
                    if ($horarioAula->domingo != 'NO') {
                        $this->respuesta = 'No';
                    }
                }
            }
        }
        if ($this->profesor != 1) {
            $horariosProfesor = Horario::where('professor_id', $this->profesor)
                ->get();
        } else {
            $horariosProfesor = [];
        }
        $this->resultado = 'Si';

        foreach ($horariosProfesor as $horarioProf) {
            if ($this->lunes) {
                if ($this->hora_inicio >= $horarioProf->hora_inicio && $this->hora_inicio <= $horarioProf->hora_fin) {
                    if ($horarioProf->lunes != 'NO') {
                        $this->resultado = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioProf->hora_inicio && $this->hora_fin <= $horarioProf->hora_fin) {
                    if ($horarioProf->lunes != 'NO') {
                        $this->resultado = 'No';
                    }
                }
            }
            if ($this->martes) {
                if ($this->hora_inicio >= $horarioProf->hora_inicio && $this->hora_inicio <= $horarioProf->hora_fin) {
                    if ($horarioProf->martes != 'NO') {
                        $this->resultado = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioProf->hora_inicio && $this->hora_fin <= $horarioProf->hora_fin) {
                    if ($horarioProf->martes != 'NO') {
                        $this->resultado = 'No';
                    }
                }
            }
            if ($this->miercoles) {
                if ($this->hora_inicio >= $horarioProf->hora_inicio && $this->hora_inicio <= $horarioProf->hora_fin) {
                    if ($horarioProf->miercoles != 'NO') {
                        $this->resultado = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioProf->hora_inicio && $this->hora_fin <= $horarioProf->hora_fin) {
                    if ($horarioProf->miercoles != 'NO') {
                        $this->resultado = 'No';
                    }
                }
            }
            if ($this->jueves) {
                if ($this->hora_inicio >= $horarioProf->hora_inicio && $this->hora_inicio <= $horarioProf->hora_fin) {
                    if ($horarioProf->jueves != 'NO') {
                        $this->resultado = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioProf->hora_inicio && $this->hora_fin <= $horarioProf->hora_fin) {
                    if ($horarioProf->jueves != 'NO') {
                        $this->resultado = 'No';
                    }
                }
            }
            if ($this->viernes) {
                if ($this->hora_inicio >= $horarioProf->hora_inicio && $this->hora_inicio <= $horarioProf->hora_fin) {
                    if ($horarioProf->viernes != 'NO') {
                        $this->resultado = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioProf->hora_inicio && $this->hora_fin <= $horarioProf->hora_fin) {
                    if ($horarioProf->viernes != 'NO') {
                        $this->resultado = 'No';
                    }
                }
            }
            if ($this->sabado) {
                if ($this->hora_inicio >= $horarioProf->hora_inicio && $this->hora_inicio <= $horarioProf->hora_fin) {
                    if ($horarioProf->sabado != 'NO') {
                        $this->resultado = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioProf->hora_inicio && $this->hora_fin <= $horarioProf->hora_fin) {
                    if ($horarioProf->sabado != 'NO') {
                        $this->resultado = 'No';
                    }
                }
            }
            if ($this->domingo) {
                if ($this->hora_inicio >= $horarioProf->hora_inicio && $this->hora_inicio <= $horarioProf->hora_fin) {
                    if ($horarioProf->domingo != 'NO') {
                        $this->resultado = 'No';
                    }
                }
                if ($this->hora_fin >= $horarioProf->hora_inicio && $this->hora_fin <= $horarioProf->hora_fin) {
                    if ($horarioProf->domingo != 'NO') {
                        $this->resultado = 'No';
                    }
                }
            }
        }

        $rules = [
            'asignatura' => 'not_in:Elegir',
            'aula' => 'not_in:Elegir',
            'profesor' => 'not_in:Elegir',
            'periodo' => 'required',
            'dias' => 'not_in:No',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after_or_equal:hora_inicio',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required|after_or_equal:fecha_inicio',
            'dia_de_cobro' => 'required',
            'resultado' => 'not_in:No',
            'respuesta' => 'not_in:No',
        ];
        $messages = [
            'asignatura.not_in' => 'Seleccione un curso distinto a Elegir.',
            'aula.not_in' => 'Seleccione un aula distinta a Elegir.',
            'profesor.not_in' => 'Seleccione un profesor distinto a Elegir.',
            'periodo.required' => 'Seleccione un periodo.',
            'dias.not_in' => 'Seleccione los dias de clases.',
            'hora_inicio.required' => 'La hora de inicio es requerido.',
            'hora_fin.required' => 'La hora de finalización es requerido.',
            'hora_fin.after_or_equal' => 'La hora de finalización debe ser posterior a la hora de inicio.',
            'fecha_inicio.required' => 'La fecha de inicio es requerido.',
            'fecha_fin.required' => 'La fecha de finalización es requerido.',
            'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser posterior a la fecha inicial.',
            'dia_de_cobro.required' => 'El día de cobro es requerido.',
            'resultado.not_in' => 'El profesor seleccionado está registrado en otro curso en uno de los dias selecionados entre los horarios seleccionados.',
            'respuesta.not_in' => 'El aula seleccionada está ocupado en uno de los dias selecionados.',
        ];
        $this->validate($rules, $messages);

        if ($this->lunes) {
            $lunes = 'Lu';
        } else {
            $lunes = 'NO';
        }
        if ($this->martes) {
            $martes = 'Ma';
        } else {
            $martes = 'NO';
        }
        if ($this->miercoles) {
            $miercoles = 'Mi';
        } else {
            $miercoles = 'NO';
        }
        if ($this->jueves) {
            $jueves = 'Ju';
        } else {
            $jueves = 'NO';
        }
        if ($this->viernes) {
            $viernes = 'Vi';
        } else {
            $viernes = 'NO';
        }
        if ($this->sabado) {
            $sabado = 'Sa';
        } else {
            $sabado = 'NO';
        }
        if ($this->domingo) {
            $domingo = 'Do';
        } else {
            $domingo = 'NO';
        }

        Horario::create([
            'lunes' => $lunes,
            'martes' => $martes,
            'miercoles' => $miercoles,
            'jueves' => $jueves,
            'viernes' => $viernes,
            'sabado' => $sabado,
            'domingo' => $domingo,
            'modalidad' => $this->modalidad,
            'periodo' => $this->periodo,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'dia_de_cobro' => $this->dia_de_cobro,
            'estado' => $this->estado,
            'asignatura_id' => $this->asignatura,
            'aula_id' => $this->aula,
            'professor_id' => $this->profesor,
        ]);

        $this->resetUI();
        $this->emit('item-added', 'Horario registrado');
    }

    public function Edit(Horario $horario)
    {
        $this->resetValidation();
        $this->selected_id = $horario->id;

        if ($horario->lunes == 'Lu') {
            $this->lunes = true;
        } else {
            $this->lunes = false;
        }

        if ($horario->martes == 'Ma') {
            $this->martes = true;
        } else {
            $this->martes = false;
        }

        if ($horario->miercoles == 'Mi') {
            $this->miercoles = true;
        } else {
            $this->miercoles = false;
        }

        if ($horario->jueves == 'Ju') {
            $this->jueves = true;
        } else {
            $this->jueves = false;
        }

        if ($horario->viernes == 'Vi') {
            $this->viernes = true;
        } else {
            $this->viernes = false;
        }

        if ($horario->sabado == 'Sa') {
            $this->sabado = true;
        } else {
            $this->sabado = false;
        }

        if ($horario->domingo == 'Do') {
            $this->domingo = true;
        } else {
            $this->domingo = false;
        }

        $this->modalidad = $horario->modalidad;
        $this->periodo = $horario->periodo;
        $this->hora_inicio = $horario->hora_inicio;
        $this->hora_fin = $horario->hora_fin;
        $this->fecha_inicio = $horario->fecha_inicio;
        $this->fecha_fin = $horario->fecha_fin;
        $this->dia_de_cobro = $horario->dia_de_cobro;
        $this->asignatura = $horario->asignatura_id;
        $this->aula = $horario->aula_id;
        $this->profesor = $horario->professor_id;
        $this->estado = $horario->estado;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        if ($this->lunes || $this->martes || $this->miercoles || $this->jueves || $this->viernes || $this->sabado || $this->domingo) {
            $this->dias = 'Si';
        } else {
            $this->dias = 'No';
        }
        $rules = [
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after_or_equal:hora_inicio',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required|after_or_equal:fecha_inicio',
            'dia_de_cobro' => 'required',
            'dias' => 'not_in:No',
        ];
        $messages = [
            'hora_inicio.required' => 'La hora de inicio es requerido',
            'hora_fin.after_or_equal' => 'La hora de finalización debe ser posterior a la hora de inicio.',
            'fecha_inicio.required' => 'La fecha de inicio es requerido',
            'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser posterior a la fecha inicial.',
            'dia_de_cobro.required' => 'El día de cobro es requerido.',
            'dias.not_in' => 'Seleccione los dias de clases.',
        ];
        $this->validate($rules, $messages);

        if ($this->lunes) {
            $lunes = 'Lu';
        } else {
            $lunes = 'NO';
        }
        if ($this->martes) {
            $martes = 'Ma';
        } else {
            $martes = 'NO';
        }
        if ($this->miercoles) {
            $miercoles = 'Mi';
        } else {
            $miercoles = 'NO';
        }
        if ($this->jueves) {
            $jueves = 'Ju';
        } else {
            $jueves = 'NO';
        }
        if ($this->viernes) {
            $viernes = 'Vi';
        } else {
            $viernes = 'NO';
        }
        if ($this->sabado) {
            $sabado = 'Sa';
        } else {
            $sabado = 'NO';
        }
        if ($this->domingo) {
            $domingo = 'Do';
        } else {
            $domingo = 'NO';
        }

        $horario = Horario::find($this->selected_id);
        $horario->update([
            'lunes' => $lunes,
            'martes' => $martes,
            'miercoles' => $miercoles,
            'jueves' => $jueves,
            'viernes' => $viernes,
            'sabado' => $sabado,
            'domingo' => $domingo,
            'modalidad' => $this->modalidad,
            'periodo' => $this->periodo,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'dia_de_cobro' => $this->dia_de_cobro,
            'asignatura_id' => $this->asignatura,
            'aula_id' => $this->aula,
            'professor_id' => $this->profesor,
            'estado' => $this->estado,
        ]);
        // actualizar la fecha limite de pago de todos los pagos de los estudiantes del horario
        $pagosHorario = Pago::join('alumno_horario as ah', 'pagos.alumno_horario_id', 'ah.id')
            ->select('pagos.id')
            ->where('ah.horario_id', $this->selected_id)->get();
        foreach ($pagosHorario as $value) {
            $pago = Pago::find($value->id);
            $pago->fecha_limite = substr($pago->fecha_limite, 0, 8) . $this->dia_de_cobro;
            $pago->save();
        }

        $this->resetUI();
        $this->emit('item-updated', 'Horario actualizado');
    }

    public function Destroy(Horario $horario)
    {
        $horario->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Horario eliminado');
    }

    public function finalizarCurso()
    {
        $horario = Horario::find($this->selected_id);
        $horario->update([
            'estado' => 'FINALIZADO',
        ]);
        $alumno_horarios = AlumnoHorario::where('horario_id', $this->selected_id)->get();
        foreach ($alumno_horarios as $value) {
            $value->update([
                'estado' => 'FINALIZADO',
            ]);
        }
        $this->resetUI();
        $this->emit('item-updated', 'El horario finalizó');
    }

    public function MostrarEstudiantes(Horario $horario)
    {
        $this->select_horario = $horario->id;
        $this->listadoEstudiantes = AlumnoHorario::with('alumno')
            ->where('horario_id', $this->select_horario)->get();
        $this->emit('show-modalEstudiantes', 'show modal!');
    }

    protected $listeners = ['deleteRow' => 'Destroy', 'finalizarCurso'];

    public function resetUI()
    {
        $this->reset([
            'selected_id',
            'asignatura', 'aula', 'modalidad', 'profesor', 'periodo', 'dias', 'lunes', 'martes', 'miercoles',
            'jueves', 'viernes', 'sabado', 'domingo', 'hora_inicio', 'hora_fin', 'fecha_inicio', 'fecha_fin',
            'estado', 'dia_de_cobro',
            'respuesta', 'resultado',
            'listadoEstudiantes', 'select_horario',
        ]);

        $this->resetValidation();
    }
}
