<?php

namespace App\Http\Livewire;

use App\Models\Alumno;
use App\Models\AlumnoHorario;
use App\Models\Horario;
use App\Models\Pago;
use App\Models\SolicitudPago;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class InscripcionesController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public  $search, $selected_id = 0, $selected_user = 0;
    public  $pageTitle = 'Listado', $componentName = 'Alumnos';
    // modal inscripcion
    public $nombre, $telefono, $fecha_nacimiento, $cedula, $tutor, $telef_tutor, $email,
        $fecha_inscripcion;
    // array de pagos del alumno
    public $pagosAlumno = [];
    // modal pagos
    public $modulo, $monto, $fecha_pago, $mes_pago, $comprobante, $observaciones;

    public $selected_pago;

    public $select_alumno_horario = 0;

    public Horario $horario_obj;

    public $asignatura, $periodo, $horario;

    public $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $dias;

    private $pagination = 15;

    protected $paginationTheme = 'bootstrap';

    public function mount(Horario $horario_id)
    {
        $this->horario_obj = $horario_id;

        $this->asignatura = $this->horario_obj->asignatura->nombre;
        $this->periodo = $this->horario_obj->periodo;
        $this->horario = $this->horario_obj->hora_inicio . '-' . $this->horario_obj->hora_fin;

        $this->lunes =  $this->horario_obj->lunes != 'NO' ? $this->horario_obj->lunes . '-' : '';
        $this->martes =  $this->horario_obj->martes != 'NO' ? $this->horario_obj->martes . '-' : '';
        $this->miercoles =  $this->horario_obj->miercoles != 'NO' ? $this->horario_obj->miercoles . '-' : '';
        $this->jueves =  $this->horario_obj->jueves != 'NO' ? $this->horario_obj->jueves . '-' : '';
        $this->viernes =  $this->horario_obj->viernes != 'NO' ? $this->horario_obj->viernes . '-' : '';
        $this->sabado =  $this->horario_obj->sabado != 'NO' ? $this->horario_obj->sabado . '-' : '';
        $this->domingo =  $this->horario_obj->domingo != 'NO' ? $this->horario_obj->domingo . '-' : '';

        $this->dias = $this->lunes . $this->martes . $this->miercoles . $this->jueves . $this->viernes . $this->sabado . $this->domingo;
    }

    public function render()
    {
        $inscripciones = Alumno::join('users as u', 'alumnos.user_id', 'u.id')
            ->join('alumno_horario as ah', 'ah.alumno_id', 'alumnos.id')
            ->join('horarios as h', 'ah.horario_id', 'h.id')
            ->join('asignaturas as a', 'h.asignatura_id', 'a.id')
            ->select(
                'alumnos.id as idAlumno',
                'alumnos.nombre as nombreAlumno',
                'alumnos.telefono',
                'u.email',
                'u.cedula',
                'a.costo',
                'a.matricula',
                'ah.id as idAlumno_horario',
                'ah.fecha_inscripcion',
                'h.dia_de_cobro',
                DB::raw('0 as a_pagar'),
                DB::raw('0 as pagado'),
                DB::raw('0 as pendiente'),
                DB::raw('0 as debe'),
            )
            ->where('h.id', $this->horario_obj->id)
            /* ->when($this->search, function ($query) {
                $query->where(function ($query2) {
                    $query2->where('codigo', 'like', '%' . $this->search . '%');
                });
            }) */
            ->paginate($this->pagination);

        $fecha_actual = date("Y-m-d");

        foreach ($inscripciones as $inscripcion) {
            // CALCULAR CUANTO YA HA PAGADO
            $pagado = Pago::where('pagos.alumno_horario_id', $inscripcion->idAlumno_horario)->sum('monto');
            $inscripcion->pagado = $pagado;
            // SUMA COSTO Y MATRICULA DEL CURSO
            $inscripcion->a_pagar = $inscripcion->costo + $inscripcion->matricula;
            // CALCULAR CUANTO DEBE ENTRE MATRICULAS Y CUOTAS
            $pendiente = $inscripcion->a_pagar - $pagado;
            $inscripcion->pendiente = $pendiente;

            $pagosA = Pago::where('alumno_horario_id', $inscripcion->idAlumno_horario)
                ->where('fecha_limite', '<', $fecha_actual)
                ->whereRaw('monto < a_pagar')
                ->get();
            if (count($pagosA) > 0) {
                $inscripcion->debe = 'SI';
            } else {
                $inscripcion->debe = 'NO';
            }
        }

        return view('livewire.inscripciones.component', [
            'inscripciones' => $inscripciones,
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
    // REGISTRAR ALUMNO
    public function Store()
    {
        $existente = User::where('cedula', $this->cedula)->get()->first();

        if ($existente) {
            $this->selected_user = $existente->id;
        }

        $rules = [
            'nombre' => 'required',
            'telefono' => 'required',
            'cedula' => 'required',
            'tutor' => 'nullable|min:3',
            'telef_tutor' => 'nullable|min:3',
            'email' => "required|email|unique:users,email,{$this->selected_user}",
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'telefono.required' => 'El telefono es requerido.',
            'cedula.required' => 'La cedula es requerida.',
            'tutor.min' => 'El nombre del tutor debe tener mas de 3 caracteres.',
            'telef_tutor.min' => 'El telefono del tutor debe tener mas de 3 caracteres.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingresa una dirección de correo válida.',
            'email.unique' => 'El email ya existe en el sistema.',
        ];
        $this->validate($rules, $messages);

        $user = User::updateOrCreate([
            'cedula' => $this->cedula
        ], [
            'name' => $this->nombre,
            'email' => $this->email,
            'profile' => 'STUDENT',
            'password' => bcrypt($this->cedula)
        ]);

        if ($user->alumno) {
            $alumno = Alumno::find($user->alumno->id);
            $alumno->update([
                'nombre' => $this->nombre,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'telefono' => $this->telefono,
                'tutor' => $this->tutor,
                'telef_tutor' => $this->telef_tutor,
            ]);
        } else {
            $alumno = Alumno::create([
                'nombre' => $this->nombre,
                'telefono' => $this->telefono,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'tutor' => $this->tutor,
                'telef_tutor' => $this->telef_tutor,
                'user_id' => $user->id,
            ]);
        }

        $AlumnoHorario = AlumnoHorario::create([
            'alumno_id' => $alumno->id,
            'horario_id' => $this->horario_obj->id,
            'fecha_inscripcion' => date('Y-m-d H:i', time()),
        ]);

        $modulos = [
            'Primer pago', 'Segundo pago', 'Tercer pago', 'Cuarto pago', 'Quinto pago',
            'Sexto pago', 'Septimo pago', 'Octavo pago', 'Noveno pago', 'Decimo pago'
        ];
        $dia_de_cobro = $this->horario_obj->dia_de_cobro;

        Pago::create([
            'modulo' => 'Matrícula',
            'monto' => '0',
            'fecha_limite' => $this->periodo . '-' . $dia_de_cobro,
            'a_pagar' => $this->horario_obj->asignatura->matricula,
            'mes_pago' => $this->periodo,
            'alumno_horario_id' => $AlumnoHorario->id,
        ]);
        $cantidadCuotas = ($this->horario_obj->asignatura->duracion);
        $cantidadPagar = ($this->horario_obj->asignatura->costo) / $cantidadCuotas;
        for ($i = 0; $i < $cantidadCuotas; $i++) {
            $fechaSumada = date("Y-m", strtotime($this->periodo . "+ " . $i . "month"));
            Pago::create([
                'modulo' => $modulos[$i],
                'monto' => '0',
                'fecha_limite' => $fechaSumada . '-' . $dia_de_cobro,
                'a_pagar' => $cantidadPagar,
                'mes_pago' => $fechaSumada,
                'alumno_horario_id' => $AlumnoHorario->id,
            ]);
        }

        $user->syncRoles('STUDENT');

        $this->resetUI();
        $this->emit('item-added', 'Alumno registrado');
    }
    // EDITAR CARGAR DATOS DEL ALUMNO
    public function Edit(Alumno $alumno, AlumnoHorario $alumno_Horario)
    {
        $this->resetValidation();
        $this->selected_id = $alumno->id;
        $this->selected_user = $alumno->user->id;
        $this->nombre = $alumno->nombre;
        $this->telefono = $alumno->telefono;
        $this->fecha_nacimiento = $alumno->fecha_nacimiento;
        $this->cedula = $alumno->user->cedula;
        $this->tutor = $alumno->tutor;
        $this->telef_tutor = $alumno->telef_tutor;
        $this->email = $alumno->user->email;

        $this->select_alumno_horario = $alumno_Horario->id;
        $this->fecha_inscripcion = $alumno_Horario->fecha_inscripcion;

        $this->emit('show-modal', 'show modal!');
    }
    // ACTUALIZAR DATOS DEL ALUMNO
    public function Update()
    {
        $rules = [
            'nombre' => 'required',
            'telefono' => 'required',
            'cedula' => 'required',
            'tutor' => 'nullable|min:3',
            'telef_tutor' => 'nullable|min:3',
            'email' => "required|email|unique:users,email,{$this->selected_user}",
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'telefono.required' => 'El telefono es requerido.',
            'cedula.required' => 'La cedula es requerida.',
            'tutor.min' => 'El nombre del tutor debe tener mas de 3 caracteres.',
            'telef_tutor.min' => 'El telefono del tutor debe tener mas de 3 caracteres.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingresa una dirección de correo válida.',
            'email.unique' => 'El email ya existe en el sistema.',
        ];
        $this->validate($rules, $messages);

        $alumno = Alumno::find($this->selected_id);

        $usuario = User::find($this->selected_user);

        $usuario->update([
            'name' => $this->nombre,
            'email' => $this->email,
            'cedula' => $this->cedula,
            'password' => bcrypt($this->cedula)
        ]);

        $alumno->update([
            'nombre' => $this->nombre,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'telefono' => $this->telefono,
            'tutor' => $this->tutor,
            'telef_tutor' => $this->telef_tutor,
        ]);

        $alumno_horario = AlumnoHorario::find($this->select_alumno_horario);

        $alumno_horario->update([
            'fecha_inscripcion' => $this->fecha_inscripcion,
        ]);

        $this->resetUI();
        $this->emit('item-updated', 'Datos del alumno actualizados');
    }
    // QUITAR AL ESTUDIANTE DE LA MATERIA
    public function Destroy(AlumnoHorario $alumno_horario, Alumno $alumno)
    {
        $pagos = Pago::where('alumno_horario_id', $alumno_horario->id)->get();
        foreach ($pagos as $pago) {
            $solicitudesPagos = SolicitudPago::where('pago_id', $pago->id)->get();
            foreach ($solicitudesPagos as $solic) {
                $solic->delete();
            }
            $pago->delete();
        }

        $alumno->horarios()->detach($this->horario_obj->id);

        $this->resetUI();
        $this->emit('item-deleted', 'El alumno fue retirado de la materia');
    }

    public function MostrarPagos(AlumnoHorario $alumno_Horario)
    {
        $this->select_alumno_horario = $alumno_Horario->id;

        $this->tablaPagos();

        $this->emit('show-modalTablaPagos', 'show modal!');
    }

    public function tablaPagos()
    {
        $this->pagosAlumno = Pago::where('alumno_horario_id', $this->select_alumno_horario)->get();
    }

    public function EditPago(Pago $pago)
    {
        $this->resetValidation();
        $this->selected_pago = $pago->id;
        $this->modulo = $pago->modulo;
        $this->monto = $pago->monto;
        $this->fecha_pago = $pago->fecha_pago;
        $this->observaciones = $pago->observaciones;
        $this->emit('show-modalFormPagos', 'show modal!');
    }

    public function UpdatePago()
    {
        $validatedData = $this->validate(
            [
                'monto' => 'required|numeric|gt:0',
                'fecha_pago' => 'required',
            ],
            [
                'monto.required' => 'El monto es requerido.',
                'monto.numeric' => 'El monto debe ser de tipo numérico.',
                'monto.gt' => 'El monto debe ser mayor a 0.',
                'fecha_pago.required' => 'La fecha de pago es requerida.',
            ],
        );
        $pago = Pago::find($this->selected_pago);
        $pago->update($validatedData + [
            'observaciones' => $this->observaciones,
        ]);
        if ($this->comprobante) {
            $customFileName = uniqid() . '_.' . $this->comprobante->extension();
            $this->comprobante->storeAs('public/pagos', $customFileName);
            $imageTemp = $pago->comprobante;
            $pago->comprobante = $customFileName;
            $pago->save();
            if ($imageTemp != null) {
                if (file_exists('storage/pagos/' . $imageTemp)) {
                    unlink('storage/pagos/' . $imageTemp);
                }
            }
        }

        $this->tablaPagos();

        $this->emit('hide-modalFormPagos', 'Cambios realizados');
    }

    public function export($nombre)
    {
        return response()->download(public_path('storage/pagos/' . $nombre));
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function resetUI()
    {
        $this->reset([
            'selected_id', 'selected_user', 'pagosAlumno', 'selected_pago', 'select_alumno_horario',
        ]);
        $this->reset([
            'nombre', 'telefono', 'fecha_nacimiento', 'cedula', 'tutor', 'telef_tutor', 'email',
            'fecha_inscripcion'
        ]);
        $this->reset([
            'monto', 'fecha_pago', 'observaciones', 'comprobante',
        ]);
        $this->resetValidation();
    }
}
