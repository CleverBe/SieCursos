<x-modal id="theModal">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
        </h5>
        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
    </x-slot>
    <x-slot name="body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Codigo del aula" />
                    <x-input type="text" wire:model.defer="codigo" maxlenght="25" />
                    @error('codigo')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Capacidad" />
                    <x-input type="number" wire:model.defer="capacidad" maxlenght="3" />
                    @error('capacidad')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @if ($selected_id != 0)
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Estado" />
                        <x-select wire:model.defer='estado'>
                            <option value="ACTIVO">Activo</option>
                            <option value="INACTIVO">Inactivo</option>
                        </x-select>
                        @error('estado')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
        </div>
    </x-slot>
    <x-slot name="footer">
        @if ($selected_id < 1)
            <x-button wire:click.prevent="Store()" wire:loading.attr="disabled" wire:target="Store" texto="GUARDAR" />
        @else
            <x-button wire:click.prevent="Update()" wire:loading.attr="disabled" wire:target="Update"
                texto="ACTUALIZAR" />
        @endif
        <button class="btn" wire:click="resetUI()" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
            CANCELAR</button>
    </x-slot>
</x-modal>
