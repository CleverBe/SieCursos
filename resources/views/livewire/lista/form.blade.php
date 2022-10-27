<x-modal id="theModal">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>Control de asistencia de estudiantes
        </h5>
        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span class="text-white">&times;</span>
        </button>
    </x-slot>
    <x-slot name="body">
        <div class="widget-content">
            <div class="table-responsive">
                <table class="table table-unbordered table-hover mb-4">
                    <thead>
                        <tr>
                            <th class="table-th text-withe text-center">Alumno</th>
                            <th class="table-th text-withe text-center">Asistencias</th>
                            <th class="table-th text-withe text-center">Faltas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asistencias as $asisten)
                            <tr>
                                <td class="text-center">
                                    <h6 class="text-center">{{ $asisten->nombre }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6 class="text-center">{{ $asisten->ASISTENCIAS }}</h6>
                                </td>
                                <td class="text-center">
                                    <h6 class="text-center">{{ $asisten->FALTAS }}</h6>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
</x-modal>
