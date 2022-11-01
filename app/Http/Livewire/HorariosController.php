<?php

namespace App\Http\Livewire;

use App\Models\AlumnoHorario;
use App\Models\Asignatura;
use App\Models\Aula;
use App\Models\Horario;
use App\Models\Pago;
use App\Models\Professor;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class HorariosController extends Component
{
    use WithPagination;

    public  $search, $selected_id = 0;
    public  $pageTitle = 'Listado', $componentName = 'Horarios';

    public $asignatura_id = 'Elegir', $aula_id = 'Elegir', $modalidad = 'PRESENCIAL', $professor_id = 'Elegir',
        $periodo, $dias_seleccionado = 'No', $lunes = false, $martes = false, $miercoles = false, $jueves = false,
        $viernes = false, $sabado = false, $domingo = false,
        $hora_inicio, $hora_fin, $fecha_inicio, $fecha_fin, $dia_de_cobro,
        $horas_capacitacion, $costo_curso, $costo_matricula = 100;

    public $horario_libre = 'Si', $profesor_libre = 'Si';

    public $filtroEstado = 'VIGENTE', $cursoFiltro, $periodoFiltro;

    public $listadoEstudiantes = [];

    public $asignaturas, $aulas, $profesores;

    private $pagination = 10;

    protected $paginationTheme = 'bootstrap';

    public $duracion_meses, $pago_cuota;

    public function mount()
    {
        $this->asignaturas = Asignatura::where('estado', 'ACTIVO')->get();
        $this->aulas = Aula::where('estado', 'ACTIVO')->get();
        $this->profesores = Professor::with('user')
            ->whereRelation('user', 'status', 'ACTIVE')->get();
    }

    public function render()
    {
        $periodoActual = Horario::where('estado', 'VIGENTE')->orderBy('periodo')->get()->first();
        if ($periodoActual) {
            $this->periodoFiltro = $periodoActual->periodo;
        } else {
            $this->periodoFiltro = date('Y-m', time());
        }

        $horarios = Horario::with('asignatura', 'aula', 'professor', 'alumnohorario', 'alumnos', 'materials')
            ->select(
                'horarios.*',
                DB::raw('0 as deudores'),
            )
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
            ->paginate($this->pagination);

        if ($this->costo_curso && $this->duracion_meses) {
            $this->pago_cuota = $this->costo_curso / $this->duracion_meses;
        } else {
            $this->pago_cuota = 0;
        }

        $fecha_actual = date("Y-m-d");

        foreach ($horarios as $value) {

            foreach ($value->alumnohorario as $alumnoHor) {
                $pagosA = Pago::where('alumno_horario_id', $alumnoHor->id)
                    ->where('fecha_limite', '<', $fecha_actual)
                    ->whereRaw('monto < a_pagar')
                    ->get();
                if (count($pagosA) > 0) {
                    $value->deudores = 'SI';
                } else {
                    $value->deudores = 'NO';
                }
            }
            if (count($value->alumnohorario) == 0) {
                $value->deudores = 'NO';
            }
        }


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

    public function validarDiasSeleccionados()
    {
        // validacion de seleccionar al menos 1 dia
        if ($this->lunes || $this->martes || $this->miercoles || $this->jueves || $this->viernes || $this->sabado || $this->domingo) {
            $this->dias_seleccionado = 'Si';
        } else {
            $this->dias_seleccionado = 'No';
        }
    }

    public function validarAulaSeleccionada()
    {
        // validacion de aula con hora_inicio y hora_fin
        $horariosAulas = Horario::where('aula_id', $this->aula_id)->where('estado', 'VIGENTE')
            ->where('id', '!=', $this->selected_id)->get();
        $this->horario_libre = 'Si';

        foreach ($horariosAulas as $horarioAula) {
            if ($this->lunes) {
                if ($this->hora_inicio > $horarioAula->hora_inicio && $this->hora_inicio < $horarioAula->hora_fin) {
                    if ($horarioAula->lunes != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
                if ($this->hora_fin > $horarioAula->hora_inicio && $this->hora_fin < $horarioAula->hora_fin) {
                    if ($horarioAula->lunes != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
            }
            if ($this->martes) {
                if ($this->hora_inicio > $horarioAula->hora_inicio && $this->hora_inicio < $horarioAula->hora_fin) {
                    if ($horarioAula->martes != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
                if ($this->hora_fin > $horarioAula->hora_inicio && $this->hora_fin < $horarioAula->hora_fin) {
                    if ($horarioAula->martes != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
            }
            if ($this->miercoles) {
                if ($this->hora_inicio > $horarioAula->hora_inicio && $this->hora_inicio < $horarioAula->hora_fin) {
                    if ($horarioAula->miercoles != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
                if ($this->hora_fin > $horarioAula->hora_inicio && $this->hora_fin < $horarioAula->hora_fin) {
                    if ($horarioAula->miercoles != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
            }
            if ($this->jueves) {
                if ($this->hora_inicio > $horarioAula->hora_inicio && $this->hora_inicio < $horarioAula->hora_fin) {
                    if ($horarioAula->jueves != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
                if ($this->hora_fin > $horarioAula->hora_inicio && $this->hora_fin < $horarioAula->hora_fin) {
                    if ($horarioAula->jueves != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
            }
            if ($this->viernes) {
                if ($this->hora_inicio > $horarioAula->hora_inicio && $this->hora_inicio < $horarioAula->hora_fin) {
                    if ($horarioAula->viernes != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
                if ($this->hora_fin > $horarioAula->hora_inicio && $this->hora_fin < $horarioAula->hora_fin) {
                    if ($horarioAula->viernes != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
            }
            if ($this->sabado) {
                if ($this->hora_inicio > $horarioAula->hora_inicio && $this->hora_inicio < $horarioAula->hora_fin) {
                    if ($horarioAula->sabado != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
                if ($this->hora_fin > $horarioAula->hora_inicio && $this->hora_fin < $horarioAula->hora_fin) {
                    if ($horarioAula->sabado != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
            }
            if ($this->domingo) {
                if ($this->hora_inicio > $horarioAula->hora_inicio && $this->hora_inicio < $horarioAula->hora_fin) {
                    if ($horarioAula->domingo != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
                if ($this->hora_fin > $horarioAula->hora_inicio && $this->hora_fin < $horarioAula->hora_fin) {
                    if ($horarioAula->domingo != 'NO') {
                        $this->horario_libre = 'No';
                    }
                }
            }
        }
    }

    public function validarProfesorSeleccionado()
    {
        // validacion de disponibilidad del profesor
        if ($this->professor_id != 1) {
            $horariosProfesor = Horario::where('professor_id', $this->professor_id)->where('estado', 'VIGENTE')
                ->where('id', '!=', $this->selected_id)->get();
            $this->profesor_libre = 'Si';

            foreach ($horariosProfesor as $horarioProf) {
                if ($this->lunes) {
                    if ($this->hora_inicio > $horarioProf->hora_inicio && $this->hora_inicio < $horarioProf->hora_fin) {
                        if ($horarioProf->lunes != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                    if ($this->hora_fin > $horarioProf->hora_inicio && $this->hora_fin < $horarioProf->hora_fin) {
                        if ($horarioProf->lunes != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                }
                if ($this->martes) {
                    if ($this->hora_inicio > $horarioProf->hora_inicio && $this->hora_inicio < $horarioProf->hora_fin) {
                        if ($horarioProf->martes != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                    if ($this->hora_fin > $horarioProf->hora_inicio && $this->hora_fin < $horarioProf->hora_fin) {
                        if ($horarioProf->martes != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                }
                if ($this->miercoles) {
                    if ($this->hora_inicio > $horarioProf->hora_inicio && $this->hora_inicio < $horarioProf->hora_fin) {
                        if ($horarioProf->miercoles != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                    if ($this->hora_fin > $horarioProf->hora_inicio && $this->hora_fin < $horarioProf->hora_fin) {
                        if ($horarioProf->miercoles != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                }
                if ($this->jueves) {
                    if ($this->hora_inicio > $horarioProf->hora_inicio && $this->hora_inicio < $horarioProf->hora_fin) {
                        if ($horarioProf->jueves != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                    if ($this->hora_fin > $horarioProf->hora_inicio && $this->hora_fin < $horarioProf->hora_fin) {
                        if ($horarioProf->jueves != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                }
                if ($this->viernes) {
                    if ($this->hora_inicio > $horarioProf->hora_inicio && $this->hora_inicio < $horarioProf->hora_fin) {
                        if ($horarioProf->viernes != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                    if ($this->hora_fin > $horarioProf->hora_inicio && $this->hora_fin < $horarioProf->hora_fin) {
                        if ($horarioProf->viernes != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                }
                if ($this->sabado) {
                    if ($this->hora_inicio > $horarioProf->hora_inicio && $this->hora_inicio < $horarioProf->hora_fin) {
                        if ($horarioProf->sabado != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                    if ($this->hora_fin > $horarioProf->hora_inicio && $this->hora_fin < $horarioProf->hora_fin) {
                        if ($horarioProf->sabado != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                }
                if ($this->domingo) {
                    if ($this->hora_inicio > $horarioProf->hora_inicio && $this->hora_inicio < $horarioProf->hora_fin) {
                        if ($horarioProf->domingo != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                    if ($this->hora_fin > $horarioProf->hora_inicio && $this->hora_fin < $horarioProf->hora_fin) {
                        if ($horarioProf->domingo != 'NO') {
                            $this->profesor_libre = 'No';
                        }
                    }
                }
            }
        }
    }

    public function Store()
    {
        $this->validarDiasSeleccionados();

        $this->validarAulaSeleccionada();

        $this->validarProfesorSeleccionado();


        $validatedData = $this->validate(
            [
                'periodo' => 'required',
                'hora_inicio' => 'required',
                'hora_fin' => 'required|after_or_equal:hora_inicio',
                'fecha_inicio' => 'required',
                'fecha_fin' => 'required|after_or_equal:fecha_inicio',
                'dia_de_cobro' => 'required|integer|between:1,10',
                'horas_capacitacion' => 'required|integer|gt:0',
                'costo_curso' => 'required|integer|gt:0',
                'costo_matricula' => 'required|integer|gt:0',
                'duracion_meses' => 'required|integer|between:1,10',
                'pago_cuota' => 'integer',
                'aula_id' => 'not_in:Elegir',
                'professor_id' => 'not_in:Elegir',
                'asignatura_id' => 'not_in:Elegir',
                'dias_seleccionado' => 'not_in:No',
                'horario_libre' => 'not_in:No',
                'profesor_libre' => 'not_in:No',
            ],
            [
                'periodo.required' => 'Seleccione un periodo.',
                'hora_inicio.required' => 'La hora de inicio es requerido.',
                'hora_fin.required' => 'La hora de finalización es requerido.',
                'hora_fin.after_or_equal' => 'La hora de finalización debe ser posterior a la hora de inicio.',
                'fecha_inicio.required' => 'La fecha de inicio es requerido.',
                'fecha_fin.required' => 'La fecha de finalización es requerido.',
                'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser posterior a la fecha inicial.',
                'dia_de_cobro.required' => 'El día de cobro es requerido.',
                'dia_de_cobro.integer' => 'El día debe ser un número.',
                'dia_de_cobro.between' => 'El día debe ser entre el 1 y el 10.',
                'horas_capacitacion.required' => 'Las horas de capacitación son requeridas.',
                'horas_capacitacion.integer' => 'Las horas deben ser un número.',
                'horas_capacitacion.gt' => 'Las horas deben ser mayor a 0.',
                'costo_curso.required' => 'El costo del curso es requerido.',
                'costo_curso.integer' => 'El costo debe ser número.',
                'costo_curso.gt' => 'El costo debe ser mayor a 0.',
                'costo_matricula.required' => 'El costo de la matricula es requerido.',
                'costo_matricula.integer' => 'El costo debe ser un número.',
                'costo_matricula.gt' => 'El costo debe ser mayor a 0.',
                'duracion_meses.required' => 'La duración del curso es requerida.',
                'duracion_meses.integer' => 'La duración debe ser un número.',
                'duracion_meses.between' => 'La duración estar entre de 1 a 10 meses.',
                'pago_cuota.integer' => 'El pago de cuotas no debe tener decimales',
                'aula_id.not_in' => 'Seleccione un aula distinta a Elegir.',
                'professor_id.not_in' => 'Seleccione un profesor distinto a Elegir.',
                'asignatura_id.not_in' => 'Seleccione un curso distinto a Elegir.',
                'dias_seleccionado.not_in' => 'Seleccione los dias de clases.',
                'horario_libre.not_in' => 'El aula seleccionada está ocupada en ese horario.',
                'profesor_libre.not_in' => 'El profesor seleccionado está ocupado en ese horario.',
            ],
        );

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

        Horario::create(
            [
                'lunes' => $lunes,
                'martes' => $martes,
                'miercoles' => $miercoles,
                'jueves' => $jueves,
                'viernes' => $viernes,
                'sabado' => $sabado,
                'domingo' => $domingo,
                'modalidad' => $this->modalidad,
            ] + $validatedData
        );

        $this->resetUI();
        $this->emit('item-added', 'Horario registrado');
    }

    public function Edit(Horario $horario)
    {
        $this->resetValidation();

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

        $this->selected_id = $horario->id;
        $this->modalidad = $horario->modalidad;
        $this->periodo = $horario->periodo;
        $this->hora_inicio = $horario->hora_inicio;
        $this->hora_fin = $horario->hora_fin;
        $this->fecha_inicio = $horario->fecha_inicio;
        $this->fecha_fin = $horario->fecha_fin;
        $this->dia_de_cobro = $horario->dia_de_cobro;
        $this->horas_capacitacion = $horario->horas_capacitacion;
        $this->costo_curso = $horario->costo_curso;
        $this->costo_matricula = $horario->costo_matricula;
        $this->duracion_meses = $horario->duracion_meses;
        $this->pago_cuota = $horario->pago_cuota;
        $this->asignatura_id = $horario->asignatura_id;
        $this->aula_id = $horario->aula_id;
        $this->professor_id = $horario->professor_id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $this->validarDiasSeleccionados();

        $this->validarAulaSeleccionada();

        $this->validarProfesorSeleccionado();

        $validatedData = $this->validate(
            [
                'hora_inicio' => 'required',
                'hora_fin' => 'required|after_or_equal:hora_inicio',
                'fecha_inicio' => 'required',
                'fecha_fin' => 'required|after_or_equal:fecha_inicio',
                'dia_de_cobro' => 'required|integer|between:1,10',
                'horas_capacitacion' => 'required|integer|gt:0',
                'pago_cuota' => 'integer',
                'aula_id' => 'not_in:Elegir',
                'professor_id' => 'not_in:Elegir',
                'dias_seleccionado' => 'not_in:No',
                'horario_libre' => 'not_in:No',
                'profesor_libre' => 'not_in:No',
            ],
            [
                'hora_inicio.required' => 'La hora de inicio es requerido.',
                'hora_fin.required' => 'La hora de finalización es requerido.',
                'hora_fin.after_or_equal' => 'La hora de finalización debe ser posterior a la hora de inicio.',
                'fecha_inicio.required' => 'La fecha de inicio es requerido.',
                'fecha_fin.required' => 'La fecha de finalización es requerido.',
                'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser posterior a la fecha inicial.',
                'dia_de_cobro.required' => 'El día de cobro es requerido.',
                'dia_de_cobro.integer' => 'El día debe ser un número.',
                'dia_de_cobro.between' => 'El día debe ser entre el 1 y el 10.',
                'horas_capacitacion.required' => 'Las horas de capacitación son requeridas.',
                'horas_capacitacion.integer' => 'Las horas deben ser un número.',
                'horas_capacitacion.gt' => 'Las horas deben ser mayor a 0.',
                'pago_cuota.integer' => 'El pago de cuotas no debe tener decimales',
                'aula_id.not_in' => 'Seleccione un aula distinta a Elegir.',
                'professor_id.not_in' => 'Seleccione un profesor distinto a Elegir.',
                'dias_seleccionado.not_in' => 'Seleccione los dias de clases.',
                'horario_libre.not_in' => 'El aula seleccionada está ocupada en ese horario.',
                'profesor_libre.not_in' => 'El profesor seleccionado está ocupado en ese horario.',
            ],
        );

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
        ] + $validatedData);

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

    public function MostrarEstudiantes(Horario $horario)
    {
        $this->listadoEstudiantes = AlumnoHorario::with('alumno')
            ->where('horario_id', $horario->id)->get();

        $this->emit('show-modalEstudiantes', 'show modal!');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function resetUI()
    {
        $this->reset([
            'selected_id',
            'asignatura_id', 'aula_id', 'modalidad', 'professor_id', 'periodo', 'dias_seleccionado', 'lunes', 'martes', 'miercoles',
            'jueves', 'viernes', 'sabado', 'domingo', 'hora_inicio', 'hora_fin', 'fecha_inicio', 'fecha_fin',
            'dia_de_cobro',
            'horario_libre', 'profesor_libre',
            'listadoEstudiantes',
        ]);

        $this->resetValidation();
    }
}
