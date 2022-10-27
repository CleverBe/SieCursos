<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }}</b>
                </h4>
            </div>

            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <x-select wire:model='role'>
                            <option value="Elegir" selected>Seleccione el rol</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <x-button wire:click="SyncAll()" class="mr-5" texto="Sincronizar todos" />
                    <x-button onclick="Revocar()" texto="Revocar todos" />
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-2">
                                <thead>
                                    <tr>
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">PERMISO</th>
                                        <th class="table-th text-withe text-center">USUARIOS CON EL PERMISO</th>
                                </thead>
                                <tbody>
                                    @forelse ($permisos as $permiso)
                                        <tr>
                                            <td class="text-center">
                                                <h6 class="text-center">{{ $loop->iteration }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <div class="n-chk">
                                                    <label class="new-control new-checkbox checkbox-primary">
                                                        <input type="checkbox"
                                                            wire:change="SyncPermiso($('#p' + {{ $permiso->id }}).is(':checked'), '{{ $permiso->name }}')"
                                                            id="p{{ $permiso->id }}" value="{{ $permiso->id }}"
                                                            class="new-control-input"
                                                            {{ $permiso->checked == 1 ? 'checked' : '' }}>
                                                        <span class="new-control-indicator"></span>
                                                        <h6>{{ $permiso->name }}</h6>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ \App\Models\User::permission($permiso->name)->count() }}</h6>
                                            </td>
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
                            {{ $permisos->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('sync-error', msg => {
            noty(msg, 0)
        });
        window.livewire.on('permi', msg => {
            noty(msg, 1)
        });
        window.livewire.on('syncall', msg => {
            noty(msg, 1)
        });
        window.livewire.on('removeall', msg => {
            noty(msg, 0)
        });
    });

    function Revocar() {

        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente quiere revocar todos los permisos del rol seleccionado?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('revokeall')
                Swal.close()
            }
        })
    }
</script>
