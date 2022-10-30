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
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <h6 class="form-control"><strong>Area : </strong></h6>
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <x-select wire:model='areaFiltro'>
                            <option value="">Todas</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                            @endforeach
                        </x-select>
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
                                <th class="table-th text-withe text-center">AREA</th>
                                <th class="table-th text-withe text-center">DURACION MESES</th>
                                <th class="table-th text-withe text-center">COSTO</th>
                                <th class="table-th text-withe text-center">MATRICULA</th>
                                <th class="table-th text-withe text-center">ESTADO</th>
                                <th class="table-th text-withe text-center">IMAGEN</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($asignaturas as $asignatura)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $asignatura->nombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $asignatura->area->nombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $asignatura->duracion }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $asignatura->costo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $asignatura->matricula }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $asignatura->estado }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                                            data-target="#sliderModal"><span>
                                                <img src="{{ asset('storage/asignaturas/' . $asignatura->image) }}"
                                                    alt="imagen de ejemplo" height="120" width="150"
                                                    class="rounded">
                                            </span></a>
                                    </td>
                                    <td class="text-center">
                                        <x-button wire:click="Edit({{ $asignatura->id }})" title="Editar">
                                            <i class="far fa-edit"></i>
                                        </x-button>
                                        <x-button
                                            onclick="Confirm('{{ $asignatura->id }}','{{ $asignatura->nombre }}','{{ $asignatura->horarios_count }}')"
                                            title="Eliminar">
                                            <i class="far fa-trash-alt"></i>
                                        </x-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <h5 class="text-center">Sin Resultados</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $asignaturas->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.cursos.form')
    @include('livewire.cursos.imagenModal')
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

    function Confirm(id, name, horarios) {
        if (horarios > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No puede eliminar el curso "' + name + '" porque tiene ' +
                    horarios + ' horarios asignado/s.'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente quiere eliminar el curso ' + '"' + name + '"?.',
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
