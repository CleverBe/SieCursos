@include('common.listaSideBarCurso')

<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">

            <div class="widget-heading">
                <h4 class="card-title">
                    <b class="text-center">Calificaciones de los estudiantes</b><br>
                </h4>
            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">Nombre estudiante</th>
                                <th class="table-th text-withe text-center">Primera nota</th>
                                <th class="table-th text-withe text-center">Segunda nota</th>
                                <th class="table-th text-withe text-center">Nota final</th>
                                <th class="table-th text-withe text-center">Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnos as $alumno)
                                <tr>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $alumno->nombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $alumno->primera_nota }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $alumno->segunda_nota }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $alumno->nota_final }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <x-button wire:click="Edit({{ $alumno->idAlumnoHorario }})" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.calificar.form')
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
    });
</script>
