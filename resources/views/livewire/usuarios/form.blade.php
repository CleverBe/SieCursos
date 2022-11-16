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
                    <x-label texto="Nombre" />
                    <x-input type="text" wire:model.defer="nombre" maxlenght="30" />
                    @error('nombre')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Telefono" />
                    <x-input type="text" wire:model.defer="telefono" maxlenght="10" />
                    @error('telefono')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Cédula" />
                    <x-input type="text" wire:model.defer="cedula" maxlenght="10" />
                    @error('cedula')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Correo electronico" />
                    <x-input type="text" wire:model.defer="email" maxlenght="25" />
                    @error('email')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    @if ($selected_id == 0)
                        <x-label texto="Contraseña" />
                    @else
                        <x-label texto="Nueva contraseña (opcional)" />
                    @endif
                    <x-input type="password" date-type='currency' wire:model.defer="password" maxlenght="25" />
                    @error('password')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @if ($selected_id == 0)
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Asignar rol" />
                        <x-select wire:model.defer='profile'>
                            <option value="Elegir" disabled selected>Elegir</option>
                            <option value="ADMIN">Administrador</option>
                            <option value="PROFESSOR">Profesor</option>
                        </x-select>
                        @error('profile')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
            @if ($selected_id != 0)
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Estado del usuario" />
                        <x-select wire:model.defer='status'>
                            <option value="ACTIVE">Activo</option>
                            <option value="LOCKED">Inactivo</option>
                        </x-select>
                        @error('status')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Imagen" />
                    <input id="{{ $identificador }}" type="file" class="form-control-file" wire:model.defer="image">
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        @if ($selected_id < 1)
            <x-button wire:click.prevent="Store()" wire:loading.attr="disabled" wire:target="Store,image"
                texto="GUARDAR" />
        @else
            <x-button wire:click.prevent="Update()" wire:loading.attr="disabled" wire:target="Update,image"
                texto="ACTUALIZAR" />
        @endif
        <button class="btn" wire:click="resetUI()" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
            CANCELAR</button>
    </x-slot>
</x-modal>
