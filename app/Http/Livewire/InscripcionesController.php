<?php

namespace App\Http\Livewire;

use App\Models\Alumno;
use App\Models\AlumnoHorario;
use App\Models\Asistencia;
use App\Models\Horario;
use App\Models\Pago;
use App\Models\SolicitudPago;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class InscripcionesController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public  $search, $selected_id = 0, $selected_user = 0;
    public  $pageTitle = 'Listado', $componentName = 'Alumnos';
    // modal inscripcion
    public $nombre, $telefono, $fecha_nacimiento, $cedula, $tutor, $telef_tutor, $email, $status,
        $fecha_inscripcion;
    // array de pagos del alumno
    public $pagosAlumno = [];
    // modal pagos
    public $modulo, $a_pagar, $monto, $fecha_pago, $mes_pago, $comprobante, $observaciones;

    public $selected_pago;

    public $select_alumno_horario = 0;

    public $estudiante, $primera_nota, $segunda_nota, $nota_final, $selected_nota;

    public Horario $horario_obj;

    public $asignatura, $periodo, $horario, $estado;

    public $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $dias;

    private $pagination = 15;

    public $promedioNotas;

    protected $paginationTheme = 'bootstrap';


    public function mount(Horario $horario_id)
    {
        $this->horario_obj = $horario_id;

        $this->asignatura = $this->horario_obj->asignatura->nombre;
        $this->periodo = $this->horario_obj->periodo;
        $this->horario = $this->horario_obj->hora_inicio . '-' . $this->horario_obj->hora_fin;

        $this->lunes =  $this->horario_obj->lunes != 'NO' ? $this->horario_obj->lunes . ' ' : '';
        $this->martes =  $this->horario_obj->martes != 'NO' ? $this->horario_obj->martes . ' ' : '';
        $this->miercoles =  $this->horario_obj->miercoles != 'NO' ? $this->horario_obj->miercoles . ' ' : '';
        $this->jueves =  $this->horario_obj->jueves != 'NO' ? $this->horario_obj->jueves . ' ' : '';
        $this->viernes =  $this->horario_obj->viernes != 'NO' ? $this->horario_obj->viernes . ' ' : '';
        $this->sabado =  $this->horario_obj->sabado != 'NO' ? $this->horario_obj->sabado . ' ' : '';
        $this->domingo =  $this->horario_obj->domingo != 'NO' ? $this->horario_obj->domingo . ' ' : '';

        $this->dias = $this->lunes . $this->martes . $this->miercoles . $this->jueves . $this->viernes . $this->sabado . $this->domingo;

        $this->promedioNotas = 0;
    }
    // resetear paginacion cuando se busca un elemento en otra pagina que no sea la primera
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->estado = $this->horario_obj->estado;

        $inscripciones = Alumno::join('users as u', 'alumnos.user_id', 'u.id')
            ->join('alumno_horario as ah', 'ah.alumno_id', 'alumnos.id')
            ->join('horarios as h', 'ah.horario_id', 'h.id')
            ->select(
                'alumnos.id as idAlumno',
                'alumnos.nombre as nombreAlumno',
                'alumnos.telefono',
                'u.email',
                'u.cedula',
                'u.status',
                'h.costo_curso',
                'h.costo_matricula',
                'h.dia_de_cobro',
                'ah.id as idAlumno_horario',
                'ah.fecha_inscripcion',
                'ah.nota_final',
                DB::raw('0 as a_pagar'),
                DB::raw('0 as pagado'),
                DB::raw('0 as pendiente'),
                DB::raw('0 as debe'),
            )
            ->where('h.id', $this->horario_obj->id)
            ->orderBy('nombreAlumno')
            ->paginate($this->pagination);

        $this->promedioNotas = count($inscripciones) > 0 ? $inscripciones->sum('nota_final') / count($inscripciones) : 0;

        $fecha_actual = date("Y-m-d");

        foreach ($inscripciones as $inscripcion) {
            // CALCULAR CUANTO YA HA PAGADO
            $pagado = Pago::where('pagos.alumno_horario_id', $inscripcion->idAlumno_horario)->sum('monto');
            $inscripcion->pagado = $pagado;
            // SUMA COSTO Y MATRICULA DEL CURSO
            $inscripcion->a_pagar = $inscripcion->costo_curso + $inscripcion->costo_matricula;
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

    public function finalizarCurso()
    {
        $this->horario_obj->estado = 'FINALIZADO';
        $this->horario_obj->save();
        $alumno_horarios = AlumnoHorario::where('horario_id', $this->horario_obj->id)->get();
        foreach ($alumno_horarios as $value) {
            $value->update([
                'estado' => 'FINALIZADO',
            ]);
        }
        $this->resetUI();
        $this->emit('item-updated', 'Este curso finalizó');
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
            'password' => bcrypt($this->cedula),
            'image' => 'noimage.png'
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
            'a_pagar' => $this->horario_obj->costo_matricula,
            'mes_pago' => $this->periodo,
            'alumno_horario_id' => $AlumnoHorario->id,
        ]);

        for ($i = 0; $i < $this->horario_obj->duracion_meses; $i++) {
            $fechaSumada = date("Y-m", strtotime($this->periodo . "+ " . $i . "month"));
            Pago::create([
                'modulo' => $modulos[$i],
                'monto' => '0',
                'fecha_limite' => $fechaSumada . '-' . $dia_de_cobro,
                'a_pagar' => $this->horario_obj->pago_cuota,
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
        $this->status = $alumno->user->status;

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
            'status' => $this->status,
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

        $usuario->syncRoles('STUDENT');

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
        $asistencias = Asistencia::where('alumno_horario_id', $alumno_horario->id)->get();
        foreach ($asistencias as $asist) {
            $asist->delete();
        }

        $alumno->horarios()->detach($this->horario_obj->id);

        $this->resetUI();
        $this->emit('item-deleted', 'El alumno fue retirado de la materia');
    }

    public function MostrarPagos(AlumnoHorario $alumno_Horario)
    {
        $this->select_alumno_horario = $alumno_Horario->id;
        $this->estudiante = $alumno_Horario->alumno->nombre;
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
        $this->a_pagar = $pago->a_pagar;
        $this->monto = $pago->monto;
        $this->fecha_pago = $pago->fecha_pago;
        $this->observaciones = $pago->observaciones;
        $this->emit('show-modalFormPagos', 'show modal!');
    }

    public function UpdatePago()
    {
        $validatedData = $this->validate(
            [
                'monto' => "required|numeric|gt:0|lte:{$this->a_pagar}",
                'fecha_pago' => 'required',
            ],
            [
                'monto.required' => 'El monto es requerido.',
                'monto.numeric' => 'El monto debe ser de tipo numérico.',
                'monto.gt' => 'El monto debe ser mayor a 0.',
                'monto.lte' => "El monto debe ser menor o igual a {$this->a_pagar}.",
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
            if ($imageTemp != 'noimage.png') {
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
        return response()->download(storage_path('app/public/pagos/'.$nombre));
    }

    public function EditNotas(AlumnoHorario $alumno_Horario)
    {
        $this->select_alumno_horario = $alumno_Horario->id;

        $this->estudiante = $alumno_Horario->alumno->nombre;
        $this->primera_nota = $alumno_Horario->primera_nota;
        $this->segunda_nota = $alumno_Horario->segunda_nota;
        $this->nota_final = $alumno_Horario->nota_final;

        $this->emit('show-modalNotas', 'show modal!');
    }

    public function UpdateNotas()
    {
        $rules = [
            'primera_nota' => 'required|integer|lte:100',
            'segunda_nota' => 'required|integer|lte:100',
        ];
        $messages = [
            'primera_nota.required' => 'La nota es requerida.',
            'primera_nota.integer' => 'La nota debe ser un número.',
            'primera_nota.lte' => 'La nota máxima es de 100.',
            'segunda_nota.required' => 'La nota es requerida.',
            'segunda_nota.integer' => 'La nota debe ser un número.',
            'segunda_nota.lte' => 'La nota máxima es de 100.',
        ];
        $this->validate($rules, $messages);

        $alumnoHorario = AlumnoHorario::find($this->select_alumno_horario);
        $alumnoHorario->update([
            'primera_nota' => $this->primera_nota,
            'segunda_nota' => $this->segunda_nota,
            'nota_final' => ($this->primera_nota + $this->segunda_nota) / 2,
        ]);
        $this->resetUI();
        $this->emit('hide-modalNotas', 'Se actualizó correctamente');
    }

    public function generarCertificado(AlumnoHorario $alumnohorario)
    {
        $nombreAlumno = $alumnohorario->alumno->nombre;
        $nombreCurso = $alumnohorario->horario->asignatura->nombre;
        $descripcion = $alumnohorario->horario->asignatura->descripcion;
        $horas_capacitacion = $alumnohorario->horario->horas_capacitacion;
        $fecha_fin = \Carbon\Carbon::parse($alumnohorario->horario->fecha_fin)->formatLocalized('%d %B %Y');
        $profesor = $alumnohorario->horario->professor->nombre;

        $template = new \PhpOffice\PhpWord\TemplateProcessor('Certificado_template.docx');
        $template->setValue('nomEstudiante', $nombreAlumno);
        $template->setValue('nomCurso', $nombreCurso);
        $template->setValue('descripcionCurso', $descripcion);
        $template->setValue('horasCapacitacion', $horas_capacitacion);
        $template->setValue('fechaFinalizacionCurso', $fecha_fin);
        $template->setValue('nombreProfesor', $profesor);

        $tenpFile = tempnam(sys_get_temp_dir(), 'PHPWord');
        $template->saveAs($tenpFile);

        $header = [
            "Content-Type: application/octet-stream",
        ];

        return response()->download($tenpFile, 'Certificado ' . $nombreAlumno . '.docx', $header)->deleteFileAfterSend($shouldDelete = true);
    }

    protected $listeners = ['deleteRow' => 'Destroy', 'finalizarCurso'];

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
            'a_pagar', 'monto', 'fecha_pago', 'observaciones', 'comprobante',
        ]);
        $this->resetValidation();
    }
}
