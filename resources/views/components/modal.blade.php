<div wire:ignore.self class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-{{ $size }}" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #414141">
                {{ $head }}
            </div>
            <div class="modal-body">
                {{ $body }}
            </div>
            <div class="modal-footer">
                @if (isset($footer) && $footer != null)
                    {{ $footer }}
                @endif
            </div>
        </div>
    </div>
</div>
