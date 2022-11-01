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
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text">Curso</span>
                        </div>
                        <select wire:model="cursoFiltro" class="form-control">
                            <option value="" selected>Todos</option>
                            @foreach ($asignaturas as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text">Periodo</span>
                        </div>
                        <input type="month" wire:model="periodoFiltro" class="form-control">
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <select wire:model="filtroEstado" class="form-control">
                            <option value="VIGENTE">VIGENTES</option>
                            <option value="FINALIZADO">FINALIZADOS</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">CURSO</th>
                                <th class="table-th text-withe text-center">AULA</th>
                                <th class="table-th text-withe text-center">PROFESOR</th>
                                <th class="table-th text-withe text-center">ESTUDIANTES</th>
                                <th class="table-th text-withe text-center">DEBEN</th>
                                <th class="table-th text-withe text-center">DIAS DE CLASES</th>
                                <th class="table-th text-withe text-center">HORARIO</th>
                                <th class="table-th text-withe text-center">FECHA INICIO</th>
                                <th class="table-th text-withe text-center">FECHA FIN</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($horarios as $horario)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $horario->asignatura->nombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $horario->aula->codigo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $horario->professor->nombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">
                                            <x-button wire:click="MostrarEstudiantes({{ $horario->id }})"
                                                title="Ver estudiantes"
                                                texto="{{ $horario->alumnohorario->count() }}" />
                                        </h6>
                                    </td>
                                    <td
                                        @if ($horario->deudores == 'SI') class="table-danger" title="Debe" @else class="table-success" title="Al día" @endif>
                                        <h6 class="text-center">{{ $horario->deudores }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">
                                            @if ($horario->lunes != 'NO')
                                                {{ $horario->lunes }}
                                            @endif
                                            @if ($horario->martes != 'NO')
                                                {{ $horario->martes }}
                                            @endif
                                            @if ($horario->miercoles != 'NO')
                                                {{ $horario->miercoles }}
                                            @endif
                                            @if ($horario->jueves != 'NO')
                                                {{ $horario->jueves }}
                                            @endif
                                            @if ($horario->viernes != 'NO')
                                                {{ $horario->viernes }}
                                            @endif
                                            @if ($horario->sabado != 'NO')
                                                {{ $horario->sabado }}
                                            @endif
                                            @if ($horario->domingo != 'NO')
                                                {{ $horario->domingo }}
                                            @endif
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($horario->fecha_inicio)->format('d/m/Y') }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($horario->fecha_fin)->format('d/m/Y') }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ url('inscripciones' . '/' . $horario->id) }}"
                                                class="btn btn-secondary" title="Ingresar">
                                                Ingresar
                                            </a>
                                            @if ($filtroEstado != 'FINALIZADO')
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-chevron-down">
                                                        <polyline points="6 9 12 15 18 9"></polyline>
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        wire:click="Edit({{ $horario->id }})">Editar</a>
                                                    <a class="dropdown-item"
                                                        onclick="Confirm('{{ $horario->id }}','{{ $horario->asignatura->nombre }}',
                                                        '{{ $horario->aula->codigo }}','{{ $horario->hora_inicio }}','{{ $horario->hora_fin }}',
                                                        '{{ $horario->alumnos->count() }}','{{ $horario->materials->count() }}')">Eliminar</a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <h5 class="text-center">Sin Resultados</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $horarios->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.horarios.form')
    @include('livewire.horarios.tablaEstudiantes')
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

        window.livewire.on('show-modalEstudiantes', msg => {
            $('#theModalEstudiantes').modal('show')
        });
        window.livewire.on('modal-hideEstudiantes', msg => {
            $('#theModalEstudiantes').modal('hide')
        });
    });

    function Confirm(id, name, codigo, hora_inicio, hora_fin, alumnos, materiales) {
        if (alumnos > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No puede eliminar el horario "' + name + '" porque tiene ' +
                    alumnos + ' alumno/s registrado/s.'
            })
            return;
        }
        if (materiales > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No puede eliminar el horario "' + name + '" porque tiene ' +
                    materiales + ' material/es subido/s.'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente quiere eliminar el curso ' + '"' + name + '" que se encuentra en el aula ' +
                codigo + ' en el horario ' + hora_inicio + ' a ' + hora_fin + '?',
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
