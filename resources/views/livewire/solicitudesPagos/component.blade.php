<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">Solicitante</th>
                                <th class="table-th text-withe text-center">Teléfono</th>
                                <th class="table-th text-withe text-center">Asignatura</th>
                                <th class="table-th text-withe text-center">Fecha tranferencia</th>
                                <th class="table-th text-withe text-center">Fecha de realizacion de solicitud</th>
                                <th class="table-th text-withe text-center">Estado</th>
                                <th class="table-th text-withe text-center">OBSERVACIONES</th>
                                <th class="table-th text-withe text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitudes as $solicitud)
                                <tr @if ($solicitud->estado == 'PENDIENTE') class="table-danger" @endif>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $solicitud->nombre }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $solicitud->telefono_solicitante }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $solicitud->asignatura }}
                                            <b>{{ \Carbon\Carbon::parse($solicitud->periodo)->formatLocalized('%B %Y') }}</b>
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($solicitud->fecha_transferencia)->format('d/m/Y H:i') }}
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y H:i') }}
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $solicitud->estado }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <x-button wire:click="Observaciones({{ $solicitud->id }})" title="Detalles">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-file-text">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                </path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" y1="13" x2="8" y2="13">
                                                </line>
                                                <line x1="16" y1="17" x2="8" y2="17">
                                                </line>
                                                <polyline points="10 9 9 9 8 9"></polyline>
                                            </svg>
                                        </x-button>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('solicitud' . '/' . $solicitud->id) }}"
                                            class="btn btn-secondary" title="Ver">
                                            Ver solicitud
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $solicitudes->links() }} --}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.solicitudesPagos.modalObservaciones')
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

        window.livewire.on('show-modalObservaciones', msg => {
            $('#theModalObservaciones').modal('show')
        });

    });
</script>
