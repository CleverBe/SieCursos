<x-modal id="theModalNotas">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>Notas de {{ $estudiante }}
        </h5>
        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span class="text-white">&times;</span>
        </button>
        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
    </x-slot>
    <x-slot name="body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Primera nota</label>
                    <input type="number" wire:model.defer="primera_nota" class="form-control" maxlenght="3">
                    @error('primera_nota')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label>Segunda nota</label>
                    <input type="number" wire:model.defer="segunda_nota" class="form-control" maxlenght="3">
                    @error('segunda_nota')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Nota final" />
                    <h6 class="form-control" wire:model="nota_final"><strong>{{ $nota_final }}</strong></h6>
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-button wire:click.prevent="UpdateNotas()" wire:loading.attr="disabled" wire:target="UpdateNotas"
            texto="ACTUALIZAR" />
        <button class="btn" wire:click="resetUI()" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
            CANCELAR</button>
    </x-slot>
</x-modal>
