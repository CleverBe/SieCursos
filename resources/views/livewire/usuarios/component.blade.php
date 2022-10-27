<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <x-button wire:click="Agregar()" texto="AGREGAR" />
                </ul>
            </div>
            @include('common.searchbox')

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="PROFESSOR"
                                        value="PROFESSOR" wire:model="rolefiltro">
                                    <span class="new-control-indicator"></span>
                                    <h6>PROFESORES</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="custom-radio-4" id="ADMIN"
                                        value="ADMIN" wire:model="rolefiltro">
                                    <span class="new-control-indicator"></span>
                                    <h6>ADMINISTRADORES</h6>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">NOMBRE</th>
                                <th class="table-th text-withe text-center">TELEFONO</th>
                                <th class="table-th text-withe text-center">CEDULA</th>
                                <th class="table-th text-withe text-center">CORREO ELECTRÓNICO</th>
                                <th class="table-th text-withe text-center">ESTADO</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usuarios as $usuario)
                                <tr>
                                    <td>
                                        <h6 class="text-center">
                                            {{ $loop->iteration }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">
                                            {{ $rolefiltro == 'PROFESSOR' ? $usuario->professor->nombre : $usuario->admin->nombre }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">
                                            {{ $rolefiltro == 'PROFESSOR' ? $usuario->professor->telefono : $usuario->admin->telefono }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $usuario->cedula }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $usuario->email }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">
                                            <span
                                                class="badge {{ $usuario->status == 'ACTIVE' ? 'badge-success' : 'badge-danger' }}">
                                                {{ $usuario->status }} </span>
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <x-button wire:click="Edit({{ $usuario->id }})" title="Editar">
                                            <i class="far fa-edit"></i>
                                        </x-button>
                                        @if ($rolefiltro == 'PROFESSOR')
                                            <x-button
                                                onclick="Confirm('{{ $usuario->id }}','{{ $usuario->professor->nombre }}',
                                                '{{ $usuario->professor->horarios->count() }}','{{ $usuario->materials->count() }}')"
                                                title="Eliminar">
                                                <i class="far fa-trash-alt"></i>
                                            </x-button>
                                        @else
                                            <x-button
                                                onclick="Confirm('{{ $usuario->id }}','{{ $usuario->admin->nombre }}','0','0')"
                                                title="Eliminar">
                                                <i class="far fa-trash-alt"></i>
                                            </x-button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <h5 class="text-center">Sin Resultados</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.usuarios.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide')
            noty(msg, 1)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg, 2)
        });
        window.livewire.on('item-deleted', msg => {
            noty(msg, 0)
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('item-error', msg => {
            noty(msg, 0)
        });
    });

    function Confirm(id, name, horarios, materiales) {
        if (horarios > 0) {
            swal.fire({
                icon: 'error',
                title: 'PRECAUCION',
                type: 'warning',
                text: 'No puede eliminar al profesor "' + name + '" porque tiene ' +
                    horarios + ' cursos asignado/s.'
            })
            return;
        }
        if (materiales > 0) {
            swal.fire({
                icon: 'error',
                title: 'PRECAUCION',
                type: 'warning',
                text: 'No puede eliminar al profesor "' + name + '" porque ha subido ' +
                    materiales + ' recursos a un horario o asignatura.'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            type: 'warning',
            text: '¿Realmente quiere eliminar al usuario ' + '"' + name + '"?.',
            showCancelButton: true,
            confirmButtonText: '<i class="flaticon-checked-1"></i> Confirmar',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText: '<i class="flaticon-cancel-circle"></i> Cancelar',
            cancelButtonAriaLabel: 'Thumbs down',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script>
