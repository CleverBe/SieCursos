@include('common.listaSideBarCurso')

<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">

            <div class="widget-heading">
                <h4 class="card-title">
                    <b class="text-center">
                        {{ $componentName }}</b><br>
                </h4>
                <ul class="tabs tab-pills">
                    @if (count($alumnos) > 0)
                        <x-button onclick="ConfirmEliminar()" texto="Eliminar lista" />
                    @else
                        <x-button onclick="ConfirmAgregar()" texto="AGREGAR" />
                    @endif
                    <x-button wire:click="verAsistencias()" texto="Control asistencias" />
                </ul>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <h6 class="form-control"><strong>Día : </strong></h6>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <input type="date" wire:model="fechaAsistencia" class="form-control">
                    </div>
                </div>
            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">Estudiante</th>
                                <th class="table-th text-withe text-center">Asistencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alumnos as $alumno)
                                <tr>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $alumno->nombre }}</h6>
                                    </td>
                                    <td>
                                        <div class="n-chk text-center">
                                            <label class="new-control new-checkbox checkbox-primary">
                                                <input type="checkbox"
                                                    wire:change="cambiarEstado('{{ $alumno->idAsistencia }}')"
                                                    class="new-control-input"
                                                    {{ $alumno->estado == 'ASISTIO' ? 'checked' : '' }}>
                                                <span class="new-control-indicator"></span>
                                                <h6>Estado</h6>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <h5 class="text-center">Sin Resultados</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    @include('livewire.lista.form')
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
        window.livewire.on('item-message', msg => {
            noty(msg, 0)
        });
    });

    function ConfirmAgregar() {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Generar lista para el dia seleccionado?.',
            showCancelButton: true,
            confirmButtonText: '<i class="flaticon-checked-1"></i> Confirmar',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText: '<i class="flaticon-cancel-circle"></i> Cancelar',
            cancelButtonAriaLabel: 'Thumbs down',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('Agregar')
                Swal.close()
            }
        })
    }
    function ConfirmEliminar() {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente desea eliminar la lista del dia selecionado?.',
            showCancelButton: true,
            confirmButtonText: '<i class="flaticon-checked-1"></i> Confirmar',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText: '<i class="flaticon-cancel-circle"></i> Cancelar',
            cancelButtonAriaLabel: 'Thumbs down',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('Eliminar')
                Swal.close()
            }
        })
    }
</script>
