<x-modal id="theModal">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>Nueva solicitud de pago</b>
        </h5>
        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
    </x-slot>
    <x-slot name="body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Teléfono de contacto" />
                    <x-input type="text" wire:model.defer="telefono_solicitante" />
                    @error('telefono_solicitante')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Fecha que realizó la transferencia" />
                    <x-input type="datetime-local" wire:model.defer="fecha_transferencia" />
                    @error('fecha_transferencia')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group custom-file mt-4">
                    <input type="file" class="custom-file-input form-control" wire:model.defer="comprobante"
                        accept="image/*">
                    <label class="custom-file-label">Comprobante {{ $comprobante }}</label>
                    @error('comprobante')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Comentarios" />
                    <x-textarea wire:model.defer="comentarios" rows="3" />
                    @error('comentarios')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-button wire:click.prevent="Store()" wire:loading.attr="disabled" wire:target="Store,comprobante"
            texto="Enviar" />
        <button class="btn" wire:click="resetUI()" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
            CANCELAR</button>
    </x-slot>
</x-modal>
