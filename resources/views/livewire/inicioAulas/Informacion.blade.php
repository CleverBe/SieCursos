<x-modal id="theModal">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>Información del curso</b>
        </h5>
        <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span class="text-white">&times;</span>
        </button>
    </x-slot>
    <x-slot name="body">
        <h6><strong>{{ $informacion }}</strong></h6>
    </x-slot>
</x-modal>
