<x-modal id="theModalTablaPagos" size="xl">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>Listado de pagos de {{ $estudiante }}
        </h5>
        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span class="text-white">&times;</span>
        </button>
        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
    </x-slot>
    <x-slot name="body">
        <div class="widget-content">
            <div class="table-responsive">
                <table class="table table-unbordered">
                    <thead>
                        <tr>
                            <th class="table-th text-withe text-center">Modulo</th>
                            <th class="table-th text-withe text-center">Monto</th>
                            <th class="table-th text-withe text-center">A PAGAR</th>
                            <th class="table-th text-withe text-center">Fecha limite</th>
                            <th class="table-th text-withe text-center">Fecha de pago</th>
                            <th class="table-th text-withe text-center">Mes</th>
                            <th class="table-th text-withe text-center">Comprobante</th>
                            <th class="table-th text-withe text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pagosAlumno as $pago)
                        <tr @if ($pago->monto < $pago->a_pagar && $pago->fecha_limite < date('Y-m-d H:i', time())) class="table-danger" @endif>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $pago->modulo }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $pago->monto }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $pago->a_pagar }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($pago->fecha_limite)->format('d/m/Y') }}
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            @if ($pago->fecha_pago)
                                            {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}
                                            @endif
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            {{ strtoupper(\Carbon\Carbon::parse($pago->mes_pago)->formatLocalized('%B %Y')) }}
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/pagos/' . $pago->comprobante) }}" alt="imagen de ejemplo" height="80" width="100" class="rounded">
                                        </span>
                                        @if ($pago->comprobante!='noimage.png')
                                        <x-button wire:click="export('{{ $pago->comprobante }}')" texto="Descargar" color="primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud">
                                                <polyline points="8 17 12 21 16 17"></polyline>
                                                <line x1="12" y1="12" x2="12" y2="21">
                                                </line>
                                                <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29">
                                                </path>
                                            </svg>
                                        </x-button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <x-button wire:click="EditPago({{ $pago->id }})" title="Modificar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                </path>
                                            </svg>
                                        </x-button>
                                    </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <h5 class="text-center">No se realizaron pagos aún.</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-slot>
</x-modal>