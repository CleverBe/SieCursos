@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/elements/alert.css') }}">
@endsection
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $asignatura }} -
                        {{ strtoupper(\Carbon\Carbon::parse($periodo)->formatLocalized('%B %Y')) }}</b> |
                    {{ $dias }} | {{ $horario }} |
                </h4>
                <ul class="tabs tab-pills">
                    @if ($estado == 'VIGENTE')
                        <x-button wire:click="Agregar()" texto="NUEVO ESTUDIANTE" class="mb-1" /> <br>
                        <x-button onclick="ConfirmFinalizarCurso()" color="danger" texto="FINALIZAR CURSO" />
                    @endif
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
                                <th class="table-th text-withe text-center">Pagos</th>
                                <th class="table-th text-withe text-center">Nota final</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inscripciones as $inscripcion)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td @if ($inscripcion->status == 'LOCKED') title="Abandonó" class="table-danger" @endif>
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
                                        @if ($inscripcion->debe == 'SI') class="table-danger" title="Debe" @else class="table-success" title="Al día" @endif>
                                        <h6 class="text-center">{{ number_format($inscripcion->pendiente, 2) }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <x-button wire:click="MostrarPagos({{ $inscripcion->idAlumno_horario }})"
                                            title="Ver Pagos" color="info" texto="Ver" />
                                    </td>
                                    <td class="text-center">
                                        <x-button wire:click="EditNotas({{ $inscripcion->idAlumno_horario }})"
                                            title="Ver Notas" color="info" texto="{{ $inscripcion->nota_final }}" />
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button id="btndefault" type="button"
                                                class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg></button>
                                            <div class="dropdown-menu" aria-labelledby="btndefault">
                                                <a wire:click="Edit({{ $inscripcion->idAlumno }},{{ $inscripcion->idAlumno_horario }})"
                                                    class="dropdown-item">Editar</a>
                                                <a onclick="Confirm('{{ $inscripcion->idAlumno_horario }}','{{ $inscripcion->idAlumno }}',
                                                    '{{ $inscripcion->nombreAlumno }}')"
                                                    class="dropdown-item">Eliminar</a>
                                                <a class="dropdown-item"
                                                    wire:click="generarCertificado({{ $inscripcion->idAlumno_horario }})">
                                                    Certificado</a>
                                            </div>
                                        </div>
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
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <h5 class="text-dark-right">Promedio de nota de los estudiantes
                                    </h5>
                                </td>
                                <td>
                                    <h5 class="text-dark text-center">
                                        {{ number_format($promedioNotas), 2 }}</h5>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $inscripciones->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.inscripciones.form')
    @include('livewire.inscripciones.tablaPagos')
    @include('livewire.inscripciones.formPagos')
    @include('livewire.inscripciones.notas')
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

        window.livewire.on('show-modalNotas', msg => {
            $('#theModalNotas').modal('show')
        });
        window.livewire.on('hide-modalNotas', msg => {
            $('#theModalNotas').modal('hide')
            noty(msg, 1)
        });
    });

    function Confirm(alumnohorario, id, name) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmar eliminar al alumno ' + name + ' del curso"?.',
            showCancelButton: true,
            confirmButtonText: '<i class="flaticon-checked-1"></i> Confirmar',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText: '<i class="flaticon-cancel-circle"></i> Cancelar',
            cancelButtonAriaLabel: 'Thumbs down',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', alumnohorario, id)
                Swal.close()
            }
        })
    }

    function ConfirmFinalizarCurso() {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente quiere finalizar este curso?',
            showCancelButton: true,
            confirmButtonText: '<i class="flaticon-checked-1"></i> Confirmar',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText: '<i class="flaticon-cancel-circle"></i> Cancelar',
            cancelButtonAriaLabel: 'Thumbs down',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('finalizarCurso')
                Swal.close()
            }
        })
    }
</script>
