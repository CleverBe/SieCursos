      </div>
      <div class="modal-footer">
          @if ($selected_id < 1)
              <x-button wire:click.prevent="Store()" wire:loading.attr="disabled" wire:target="Store" texto="GUARDAR" />
              {{-- <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-btn text-info">GUARDAR</button> --}}
          @else
              <x-button wire:click.prevent="Update()" wire:loading.attr="disabled" wire:target="Update" texto="ACTUALIZAR" />
          @endif
          <button class="btn" wire:click="resetUI()" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
              CANCELAR</button>
      </div>
      </div>
      </div>
      </div>
