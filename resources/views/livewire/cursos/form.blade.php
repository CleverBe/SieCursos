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
                    <x-input type="text" wire:model.defer="nombre" maxlenght="25" />
                    @error('nombre')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Duracion en meses" />
                    <x-input type="number" wire:model.defer="duracion" />
                    @error('duracion')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Costo" />
                    <x-input type="number" wire:model.defer="costo" />
                    @error('costo')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Matrícula" />
                    <x-input type="number" wire:model.defer="matricula" />
                    @error('matricula')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Area" />
                    <x-select wire:model.defer='area_id'>
                        <option value="Elegir">Elegir</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                        @endforeach
                    </x-select>
                    @error('area_id')
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
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Imagen" />
                    <input type="file" class="form-control-file" wire:model.defer="image">
                </div>
            </div>
            @if ($image)
                <div class="col-sm-12 col-md-12 text-center">
                    <div class="form-group">
                        <h3>Visualización previa</h3>
                        <img src="{{ $image->temporaryURL() }}" height="200" width="200" class="img-fluid">
                    </div>
                </div>
            @endif
            <div class="col-sm-12 col-md-12">
                <div class="input-group">
                    <span class="input-group-text">Descripción</span>
                    <x-textarea wire:model.defer="descripcion" rows="3" />
                    @error('descripcion')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
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
