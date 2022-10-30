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
                    <x-label texto="Nombre del estudiante" />
                    <x-input type="text" wire:model.defer="nombre" maxlenght="25" />
                    @error('nombre')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Telefono" />
                    <x-input type="text" wire:model.defer="telefono" maxlenght="25" />
                    @error('telefono')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Fecha de nacimiento" />
                    <x-input type="date" wire:model.defer="fecha_nacimiento" />
                    @error('fecha_nacimiento')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Cédula de identidad" />
                    <x-input type="number" wire:model.defer="cedula" />
                    @error('cedula')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Nombre tutor (opcional)" />
                    <x-input type="text" wire:model.defer="tutor" />
                    @error('tutor')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Telefono tutor (opcional)" />
                    <x-input type="text" wire:model.defer="telef_tutor" />
                    @error('telef_tutor')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Correo electrónico" />
                    <x-input type="text" wire:model.defer="email" />
                    @error('email')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @if ($selected_id != 0)
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Fecha de inscripción" />
                        <x-input type="datetime-local" wire:model.defer="fecha_inscripcion" />
                        @error('fecha_inscripcion')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
            @if ($selected_id != 0)
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Estado del estudiante" />
                        <x-select wire:model.defer='status'>
                            <option value="ACTIVE">Activo</option>
                            <option value="LOCKED">Abandonó</option>
                        </x-select>
                        @error('status')
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
