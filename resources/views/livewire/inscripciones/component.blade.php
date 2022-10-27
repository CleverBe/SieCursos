@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/elements/alert.css') }}">
@endsection
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $asignatura }} |
                        {{ strtoupper(\Carbon\Carbon::parse($periodo)->formatLocalized('%B %Y')) }} |
                        {{ $dias }} | {{ $horario }} | </b>
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
            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">Nombre</th>
                                <th class="table-th text-withe text-center">Teléfono</th>
                                <th class="table-th text-withe text-center">A PAGAR</th>
                                <th class="table-th text-withe text-center">Pagado</th>
                                <th class="table-th text-withe text-center">Pendiente</th>
                                <th class="table-th text-withe text-center">Fecha inscripcion</th>
                                <th class="table-th text-withe text-center">Pagos</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inscripciones as $inscripcion)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $inscripcion->nombreAlumno }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $inscripcion->telefono }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ number_format($inscripcion->a_pagar, 2) }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ number_format($inscripcion->pagado, 2) }}</h6>
                                    </td>
                                    <td
                                        @if ($inscripcion->debe == 'SI') class="table-danger"@else class="table-success" @endif>
                                        <h6 class="text-center">{{ number_format($inscripcion->pendiente, 2) }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y H:i') }}
                                        </h6>
                                    </td>
                                    <td>
                                        <x-button wire:click="MostrarPagos({{ $inscripcion->idAlumno_horario }})"
                                            title="Ver pagos" texto="Ver" />
                                    </td>
                                    <td class="text-center">
                                        <x-button
                                            wire:click="Edit({{ $inscripcion->idAlumno }},{{ $inscripcion->idAlumno_horario }})"
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </x-button>
                                        <x-button
                                            onclick="Confirm('{{ $inscripcion->idAlumno_horario }}','{{ $inscripcion->idAlumno }}',
                                            '{{ $inscripcion->nombreAlumno }}')"
                                            title="Eliminar">
                                            <i class="far fa-trash-alt"></i>
                                        </x-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12">
                                        <h5 class="text-center">Sin Resultados</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $inscripciones->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.inscripciones.form')
    @include('livewire.inscripciones.tablaPagos')
    @include('livewire.inscripciones.formPagos')
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

        window.livewire.on('show-modalTablaPagos', msg => {
            $('#theModalTablaPagos').modal('show')
        });

        window.livewire.on('show-modalFormPagos', msg => {
            $('#theModalFormPagos').modal('show')
        });
        window.livewire.on('hide-modalFormPagos', msg => {
            $('#theModalFormPagos').modal('hide')
            noty(msg, 1)
        });
    });

    function Confirm(alumnohorario, id, name) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmar eliminar al alumno ' + name + ' de la materia"?.',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', alumnohorario, id)
                Swal.close()
            }
        })
    }
</script>
