<x-modal id="theModalObservaciones">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>Tu comentario</b>
        </h5>
        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span class="text-white">&times;</span>
        </button>
    </x-slot>
    <x-slot name="body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <x-label texto="Comentarios" />
                    <h6 class="form-control" wire:model="comentarios"><strong>{{ $comentarios }}</strong></h6>
                </div>
            </div>
        </div>
    </x-slot>
</x-modal>
