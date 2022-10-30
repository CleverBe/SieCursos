<div class="modal fade" id="sliderModal" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="basicModalLabel" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg></span>
                </button>
                <div class="text-center">
                    <span>
                        <img style="max-width:1100px;max-height:800px;"
                            src="{{ asset('storage/asignaturas/' . $asignatura->image) }}">
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
