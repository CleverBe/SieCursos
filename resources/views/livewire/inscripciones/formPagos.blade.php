<x-modal id="theModalFormPagos">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>PAGOS</b> | EDITAR
        </h5>
        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span class="text-white">&times;</span>
        </button>
    </x-slot>
    <x-slot name="body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Modulo" />
                    <h6 class="form-control" wire:model="modulo"><strong>{{ $modulo }}</strong></h6>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Cuota" />
                    <h6 class="form-control" wire:model="a_pagar"><strong>{{ $a_pagar }}</strong></h6>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Monto" />
                    <x-input type="integer" wire:model.defer="monto" />
                    @error('monto')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @if ($selected_pago != 0)
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Fecha de pago" />
                        <x-input type="datetime-local" wire:model.defer="fecha_pago" />
                        @error('fecha_pago')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Observaciones" />
                    <x-textarea wire:model.defer="observaciones" rows="3" />
                    @error('observaciones')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group custom-file mt-4">
                    <input type="file" class="custom-file-input form-control" wire:model="comprobante"
                        accept="image/x-png,image/gif,image/jpeg">
                    <label class="custom-file-label">Comprobante {{ $comprobante }}</label>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div wire:loading wire:target="comprobante"
                    class="alert alert-arrow-right alert-icon-right alert-light-danger mb-4" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-alert-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <strong>¡Cargando imagen!</strong> Espere un momento.
                </div>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-button wire:click="UpdatePago()" wire:loading.attr="disabled" wire:target="UpdatePago,comprobante"
            texto="ACTUALIZAR" title="Actualizar" />
    </x-slot>
</x-modal>
