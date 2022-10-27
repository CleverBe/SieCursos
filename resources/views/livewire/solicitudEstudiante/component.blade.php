<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Solicitud de pago para "{{ $moduloSolicitud }}"</b>
                </h4>
                <ul class="tabs tab-pills">
                    @if ($estado == 'PENDIENTE')
                        <x-button onclick="ConfirmAprobar()" texto="Aprobar" title="Aprobar" />
                        <x-button onclick="ConfirmRechazar()" texto="Rechazar" title="Rechazar" />
                    @endif
                </ul>
            </div>
            <div class="mb-2">
                <h6 class="card-title">
                    Estudiante: <b>{{ $nombre_solicitante }}</b><br>
                    Teléfono estudiante: <b>{{ $telefono_solicitante }}</b><br>
                    Comprobante: <br>
                    <img src="{{ asset('storage/pagos/' . $comprobante) }}" alt="widget-card-2"
                        style="max-width:500px;width:100%"><br>
                    Fecha de transferencia:
                    <b>{{ \Carbon\Carbon::parse($fecha_transferencia)->format('d/m/Y H:i') }}</b><br>
                    Comentario: <b>{{ $comentarios }}</b><br>
                    Estado de solicitud: <b>{{ $estado }}</b>
                    <br>
                </h6>
            </div>
            <h6><b>Listado de los pagos del estudiante</b></h6>
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">Modulo</th>
                                <th class="table-th text-withe text-center">Monto</th>
                                <th class="table-th text-withe text-center">A pagar</th>
                                <th class="table-th text-withe text-center">Fecha a pagar</th>
                                <th class="table-th text-withe text-center">Fecha de pago</th>
                                <th class="table-th text-withe text-center">Mes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pagos as $pago)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $pago->modulo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $pago->monto }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $pago->a_pagar }}</h6>
                                    </td>
                                    <td>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $data->links() }} --}}
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide')
            noty(msg, 1)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg, 1)
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
    });

    function ConfirmAprobar() {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Está seguro de que quiere aprobar esta solicitud de pago?.',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('aprobar')
                Swal.close()
            }
        })
    }

    function ConfirmRechazar() {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Está seguro de que quiere rechazar esta solicitud de pago?.',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('rechazar')
                Swal.close()
            }
        })
    }
</script>
