<x-modal id="theModalSolicitudes">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>Listado de mis solicitudes de pago
        </h5>
        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
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
                            <th class="table-th text-withe text-center">Comprobante</th>
                            <th class="table-th text-withe text-center">Fecha tranferencia</th>
                            <th class="table-th text-withe text-center">Fecha de realización de solicitud</th>
                            <th class="table-th text-withe text-center">Estado</th>
                            <th class="table-th text-withe text-center">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solicitudes as $solicitud)
                            <tr>
                                <td class="text-center">
                                    <span>
                                        <img src="{{ asset('storage/pagos/' . $solicitud->comprobante) }}"
                                            alt="imagen de ejemplo" height="120" width="150" class="rounded">
                                    </span>
                                    <x-button wire:click="export('{{ $solicitud->comprobante }}')" texto="Descargar"
                                        color="primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-download-cloud">
                                            <polyline points="8 17 12 21 16 17"></polyline>
                                            <line x1="12" y1="12" x2="12" y2="21">
                                            </line>
                                            <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29">
                                            </path>
                                        </svg>
                                    </x-button>
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
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
</x-modal>
