@include('common.sidebarAlumnos')

<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">

            <div class="widget-heading">
                <h4 class="card-title">
                    <b class="text-center">Seguimiento de mis pagos</b><br>
                </h4>
                <ul class="tabs tab-pills">
                    <x-button wire:click="ListadoSolicitudes({{ $alumnosHorario }})" texto="Mis solicitudes de pago">
                        <i class="far fa-clipboard"></i>
                    </x-button>
                </ul>
            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">Modulo</th>
                                <th class="table-th text-withe text-center">PAGADO</th>
                                <th class="table-th text-withe text-center">A pagar</th>
                                <th class="table-th text-withe text-center">Fecha LIMITE DE PAGO</th>
                                <th class="table-th text-withe text-center">Fecha de pago</th>
                                <th class="table-th text-withe text-center">Mes</th>
                                <th class="table-th text-withe text-center">Solicitar pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($misPagos as $pago)
                                <tr>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $pago->modulo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $pago->monto }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $pago->a_pagar }}</h6>
                                    </td>
                                    <td @if ($pago->monto < $pago->a_pagar && $pago->fecha_limite < date('Y-m-d H:i', time())) class="table-danger" @endif>
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($pago->fecha_limite)->format('d/m/Y') }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">
                                            @if ($pago->fecha_pago)
                                                {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}
                                            @endif
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">
                                            {{ strtoupper(\Carbon\Carbon::parse($pago->mes_pago)->formatLocalized('%B')) }}
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        @if (!$pago->fecha_pago)
                                            <x-button wire:click="SolicitarPago({{ $pago->id_pago }})"
                                                title="Realizar solicitud">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-share">
                                                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                                    <polyline points="16 6 12 2 8 6"></polyline>
                                                    <line x1="12" y1="2" x2="12" y2="15">
                                                    </line>
                                                </svg>
                                            </x-button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    @include('livewire.mi_plan_pagos.form')
    @include('livewire.mi_plan_pagos.tablaSolicitudes')
    @include('livewire.mi_plan_pagos.modalObservaciones')
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

        window.livewire.on('show-modalSolicitudes', msg => {
            $('#theModalSolicitudes').modal('show')
        });

        window.livewire.on('show-modalObservaciones', msg => {
            $('#theModalObservaciones').modal('show')
        });

    });
</script>
