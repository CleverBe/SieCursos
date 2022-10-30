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
                    <table class="table table-unbordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th class="table-th text-withe text-center">#</th>
                                <th class="table-th text-withe text-center">CODIGO AULA</th>
                                <th class="table-th text-withe text-center">CAPACIDAD</th>
                                <th class="table-th text-withe text-center">ESTADO</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aulas as $aula)
                                <tr>
                                    <td>
                                        <h6 class="text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $aula->codigo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $aula->capacidad }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $aula->estado }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <x-button wire:click="Edit({{ $aula->id }})" title="Editar">
                                            <i class="far fa-edit"></i>
                                        </x-button>
                                        <x-button
                                            onclick="Confirm('{{ $aula->id }}','{{ $aula->codigo }}','{{ $aula->horarios_count }}')"
                                            title="Eliminar">
                                            <i class="far fa-trash-alt"></i>
                                        </x-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <h5 class="text-center">Sin Resultados</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $aulas->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.aulas.form')
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
    });

    function Confirm(id, name, horarios) {
        if (horarios > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No puede eliminar el aula "' + name + '" porque tiene ' +
                    horarios + ' horarios asignado/s.'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente quiere eliminar el aula ' + '"' + name + '"?.',
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
