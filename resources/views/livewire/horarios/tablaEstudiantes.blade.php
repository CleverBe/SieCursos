<x-modal id="theModalEstudiantes">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>Listado de estudiantes
        </h5>
        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span class="text-white">&times;</span>
        </button>
        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
    </x-slot>
    <x-slot name="body">
        <div class="widget-content">
            <div class="table-responsive">
                <table class="table table-unbordered table-hover mb-4">
                    <thead>
                        <tr>
                            <th class="table-th text-withe text-center">#</th>
                            <th class="table-th text-withe text-center">Estudiante</th>
                            <th class="table-th text-withe text-center">Teléfono</th>
                            <th class="table-th text-withe text-center">Fecha de inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($listadoEstudiantes as $alumno_horario)
                            <tr>
                                <td>
                                    <h6 class="text-center">{{ $loop->iteration }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6 class="text-center">{{ $alumno_horario->alumno->nombre }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6 class="text-center">{{ $alumno_horario->alumno->telefono }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6 class="text-center">
                                        {{ \Carbon\Carbon::parse($alumno_horario->fecha_inscripcion)->format('d/m/Y H:i') }}
                                    </h6>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <h5 class="text-center">No se registraron estudiantes aún.</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
</x-modal>
