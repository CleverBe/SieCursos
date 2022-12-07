<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <x-button wire:click="Agregar()" texto="AGREGAR" />
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">NOMBRE DEL PERMISO</th>
                                {{-- <th class="table-th text-withe text-center">ACCIONES</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $permiso)
                                <tr>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $permiso->name }}</h6>
                                    </td>
                                    {{-- <td class="text-center">
                                        <x-button wire:click="Edit({{ $permiso->id }})" title="Editar">
                                            <i class="far fa-edit"></i>
                                        </x-button>
                                        <x-button onclick="Confirm('{{ $permiso->id }}','{{ $permiso->name }}')"
                                            title="Eliminar">
                                            <i class="far fa-trash-alt"></i>
                                        </x-button>
                                    </td> --}}
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
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.permisos.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide')
            noty(msg, 1)
        })
        window.livewire.on('item-update', msg => {
            $('#theModal').modal('hide')
            noty(msg, 2)
        })
        window.livewire.on('item-deleted', msg => {
            noty(msg, 0)
        })
        window.livewire.on('item-error', msg => {
            noty(msg, 0)
        })
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        })


    });

    function Confirm(id, name) {

        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el permiso ' + '"' + name + '"',
            showCancelButton: true,
            confirmButtonText: '<i class="flaticon-checked-1"></i> Confirmar',
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText: '<i class="flaticon-cancel-circle"></i> Cancelar',
            cancelButtonAriaLabel: 'Thumbs down',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script>
