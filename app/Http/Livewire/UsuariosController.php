<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Professor;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UsuariosController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public  $search, $selected_id, $selected_user;
    public  $pageTitle, $componentName;
    public $nombre, $cedula, $telefono, $email, $password, $profile, $status, $image;
    public $rolefiltro;
    private $pagination = 10;

    public $identificador;

    /* public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    } */

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->selected_id = 0;
        $this->selected_user = 0;
        $this->profile = 'Elegir';
        $this->rolefiltro = 'PROFESSOR';
        $this->identificador = rand();
    }
    // resetear paginacion cuando se busca un elemento en otra pagina que no sea la primera
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->rolefiltro == 'PROFESSOR') {
            $usuarios = User::with('professor')
                ->where('profile', $this->rolefiltro)
                ->where('id', '!=', '1')
                ->when($this->search, function ($query) {
                    $query->where(function ($query2) {
                        $query2->whereRelation('professor', 'nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('cedula', 'like', '%' . $this->search . '%');
                    });
                })
                ->paginate($this->pagination);
        } else {
            $usuarios = User::with('admin')
                ->where('profile', $this->rolefiltro)
                ->when($this->search, function ($query) {
                    $query->where(function ($query2) {
                        $query2->whereRelation('admin', 'nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('cedula', 'like', '%' . $this->search . '%');
                    });
                })
                ->paginate($this->pagination);
        }
        return view('livewire.usuarios.component', [
            'usuarios' => $usuarios,
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
            'telefono' => 'required|integer',
            'cedula' => 'required|integer',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:3',
            'profile' => 'not_in:Elegir',
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'telefono.required' => 'El telefono es requerido.',
            'telefono.integer' => 'El telefono debe ser un número.',
            'cedula.required' => 'La cédula es requerida.',
            'cedula.integer' => 'La cédula debe ser un número.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingresa una dirección de correo válida.',
            'email.unique' => 'El email ya existe en el sistema.',
            'password.required' => 'Ingresa el contraseña',
            'password.min' => 'La contraseña debe tener al menos tres caracteres',
            'profile.not_in' => 'Seleccione un rol distinto a Elegir',
        ];
        $this->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $this->nombre,
                'email' => $this->email,
                'cedula' => $this->cedula,
                'profile' => $this->profile,
                'password' => bcrypt($this->password)
            ]);
            if ($this->profile == 'PROFESSOR') {
                Professor::create([
                    'nombre' => $this->nombre,
                    'telefono' => $this->telefono,
                    'user_id' => $user->id,
                ]);
            } else {
                Admin::create([
                    'nombre' => $this->nombre,
                    'telefono' => $this->telefono,
                    'user_id' => $user->id,
                ]);
            }

            if ($this->image) {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $this->image->storeAs('public/usuarios', $customFileName);
            } else {
                $customFileName = 'noimage.png';
            }
            $user->image = $customFileName;
            $user->save();

            $user->syncRoles($this->profile);

            DB::commit();

            $this->resetUI();
            $this->emit('item-added', 'Usuario registrado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'No se pudo crear el usuario ' . $e->getMessage());
        }
    }
    public function Edit(User $usuario)
    {
        $this->resetValidation();
        if ($usuario->profile == 'PROFESSOR') {
            $this->selected_id = $usuario->professor->id;
            $this->nombre = $usuario->professor->nombre;
            $this->telefono = $usuario->professor->telefono;
        } else {
            $this->selected_id = $usuario->admin->id;
            $this->nombre = $usuario->admin->nombre;
            $this->telefono = $usuario->admin->telefono;
        }
        $this->selected_user = $usuario->id;
        $this->email = $usuario->email;
        $this->cedula = $usuario->cedula;
        $this->status = $usuario->status;

        $this->emit('show-modal', 'show modal!');
    }
    public function Update()
    {
        $rules = [
            'nombre' => 'required',
            'telefono' => 'required|integer',
            'cedula' => 'required|integer',
            'email' => "required|email|unique:users,email,{$this->selected_user}",
            'password' => 'nullable|min:3',
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'telefono.required' => 'El telefono es requerido.',
            'telefono.integer' => 'El telefono debe ser un número.',
            'cedula.required' => 'La cédula es requerida.',
            'cedula.integer' => 'La cédula debe ser un número.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingresa una dirección de correo válida.',
            'email.unique' => 'El email ya existe en el sistema.',
            'password.required' => 'Ingresa el contraseña.',
            'password.min' => 'La contraseña debe tener al menos tres caracteres.',
        ];
        $this->validate($rules, $messages);

        $usuario = User::find($this->selected_user);

        if ($usuario->profile == 'PROFESSOR') {
            $tipoUsuario = Professor::find($this->selected_id);
        } else {
            $tipoUsuario = Admin::find($this->selected_id);
        }

        if ($this->password != null) {
            $usuario->update([
                'name' => $this->nombre,
                'email' => $this->email,
                'cedula' => $this->cedula,
                'status' => $this->status,
                'password' => bcrypt($this->password)
            ]);
        } else {
            $usuario->update([
                'name' => $this->nombre,
                'email' => $this->email,
                'cedula' => $this->cedula,
                'status' => $this->status,
            ]);
        }

        $tipoUsuario->update([
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/usuarios', $customFileName);
            $imageTemp = $usuario->image;
            $usuario->image = $customFileName;
            $usuario->save();

            if ($imageTemp != 'noimage.png') {
                if (file_exists('storage/usuarios/' . $imageTemp)) {
                    unlink('storage/usuarios/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated', 'Usuario actualizado');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(User $usuario)
    {
        $imageName = $usuario->image;
        if ($imageName != null) {
            unlink('storage/usuarios/' . $imageName);
        }

        if ($usuario->profile == 'PROFESSOR') {
            $tipoUsuario = Professor::find($usuario->professor->id);
        } else {
            $tipoUsuario = Admin::find($usuario->admin->id);
        }

        $tipoUsuario->delete();

        $usuario->delete();

        $this->resetUI();
        $this->emit('item-deleted', 'Usuario eliminado');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->selected_user = 0;
        $this->profile = 'Elegir';
        $this->reset(['nombre', 'cedula', 'telefono', 'email', 'password', 'image']);
        $this->identificador = rand();
        $this->resetValidation();
    }
}
