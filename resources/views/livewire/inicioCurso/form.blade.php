<x-modal id="theModal">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'SUBIR' }}
        </h5>
        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
    </x-slot>
    <x-slot name="body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Nombre para el material" />
                    <x-input type="text" wire:model.defer="nombre" />
                    @error('nombre')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group custom-file mt-4">
                    <input type="file" class="custom-file-input form-control" wire:model.defer="material"
                        accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                    <label class="custom-file-label">Material {{ $material }}</label>
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <x-label texto="Comentarios" />
                    <x-textarea wire:model.defer="comentario" rows="1" />
                    @error('comentario')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        @if ($selected_id < 1)
            <x-button wire:click.prevent="Store()" wire:loading.attr="disabled" wire:target="Store,material"
                texto="GUARDAR" />
        @else
            <x-button wire:click.prevent="Update()" wire:loading.attr="disabled" wire:target="Update,material"
                texto="ACTUALIZAR" />
        @endif
        <button class="btn" wire:click="resetUI()" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
            CANCELAR</button>
    </x-slot>
</x-modal>
