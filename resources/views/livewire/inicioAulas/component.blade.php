@section('css')
    <link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
@endsection


<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b class="text-center">LISTADO DE MATERIAS</b><br>
                </h4>
            </div>
            {{-- <div>
                <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                            wire:click="$set('estadoFiltro','ACTUALES')" role="tab" aria-controls="pills-home"
                            aria-selected="true">Actuales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="javascript:void(0)"
                            wire:click="$set('estadoFiltro','PASADOS')" role="tab" aria-controls="pills-contact"
                            aria-selected="false">Pasados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-disponible-tab" data-toggle="pill" href="javascript:void(0)"
                            wire:click="$set('estadoFiltro','DISPONIBLES')" role="tab"
                            aria-controls="pills-disponible" aria-selected="false">Disponibles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-proximos-tab" data-toggle="pill" href="javascript:void(0)"
                            wire:click="$set('estadoFiltro','PROXIMOS')" role="tab" aria-controls="pills-proximos"
                            aria-selected="false">Proximos cursos</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="row">
                            @foreach ($horarios as $horario)
                                <div class="col-sm-12 col-md-4">
                                    <div class="card component-card_9">
                                        <img src="assets/img/400x300.jpg" class="card-img-top" alt="widget-card-2">
                                        <div class="card-body">
                                            <p class="meta-date">{{ $horario->periodo }}</p>

                                            <h5 class="card-title">{{ $horario->asignatura->nombre }}</h5>
                                            <p class="card-text">Horario {{ $horario->horario }}</p>
                                            <p class="card-text">Aula {{ $horario->aula->codigo }}</p>

                                            <div class="meta-info">
                                                <div class="meta-user">
                                                    <div class="user-name">Instructor: {{ $horario->professor->nombre }}
                                                    </div>
                                                    <a href="{{ url('inicioCurso') }}" class="btn btn-dark"> Ingresar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="card component-card_9">
                                    <img src="assets/img/400x300.jpg" class="card-img-top" alt="widget-card-2">
                                    <div class="card-body">
                                        <p class="meta-date">Agosto</p>

                                        <h5 class="card-title">Curso Reparacion de celulares</h5>
                                        <p class="card-text">Horario 15:00 - 17:00</p>

                                        <div class="meta-info">
                                            <div class="meta-user">
                                                <div class="user-name">Prof. Gustavo Perez</div>
                                                <a href="{{ url('inicioCurso') }}" class="btn btn-dark"> Ingresar </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-disponible" role="tabpanel"
                        aria-labelledby="pills-disponible-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="card component-card_9">
                                    <img src="assets/img/400x300.jpg" class="card-img-top" alt="widget-card-2">
                                    <div class="card-body">
                                        <p class="meta-date">Agosto</p>

                                        <h5 class="card-title">Curso Reparacion de celulares</h5>
                                        <p class="card-text">Horario 15:00 - 17:00</p>

                                        <div class="meta-info">
                                            <div class="meta-user">
                                                <div class="user-name">Prof. Gustavo Perez</div>
                                                <a href="{{ url('inicioCurso') }}" class="btn btn-dark"> Ver
                                                    Descripcion </a>
                                            </div>


                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-proximos" role="tabpanel"
                        aria-labelledby="pills-proximos-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="card component-card_9">
                                    <img src="assets/img/400x300.jpg" class="card-img-top" alt="widget-card-2">
                                    <div class="card-body">
                                        <p class="meta-date">Octubre</p>

                                        <h5 class="card-title">Curso Reparacion de celulares</h5>
                                        <p class="card-text">Horario 15:00 - 17:00</p>

                                        <div class="meta-info">
                                            <div class="meta-user">
                                                <a href="{{ url('inicioCurso') }}" class="btn btn-dark"> Ver
                                                    Descripcion </a>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="widget-content {{-- widget-content-area --}} rounded-pills-icon">

                <ul class="nav nav-pills mb-4 mt-3  justify-content-center" id="rounded-pills-icon-tab" role="tablist">
                    <li class="nav-item ml-2 mr-2">
                        <a class="nav-link mb-2 active text-center" id="rounded-pills-icon-home-tab" data-toggle="pill"
                            href="#rounded-pills-icon-home" role="tab" aria-controls="rounded-pills-icon-home"
                            aria-selected="true" {{-- wire:click="$set('estadoFiltro','ACTUALES')" --}}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg> ACTUALES</a>
                    </li>
                    <li class="nav-item ml-2 mr-2">
                        <a class="nav-link mb-2 text-center" id="rounded-pills-icon-profile-tab" data-toggle="pill"
                            href="#rounded-pills-icon-profile" role="tab" aria-controls="rounded-pills-icon-profile"
                            aria-selected="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-rewind">
                                <polygon points="11 19 2 12 11 5 11 19"></polygon>
                                <polygon points="22 19 13 12 22 5 22 19"></polygon>
                            </svg> PASADAS</a>
                    </li>
                    <li class="nav-item ml-2 mr-2">
                        <a class="nav-link mb-2 text-center" id="rounded-pills-icon-contact-tab" data-toggle="pill"
                            href="#rounded-pills-icon-contact" role="tab" aria-controls="rounded-pills-icon-contact"
                            aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg> DISPONIBLES</a>
                    </li>
                    <li class="nav-item ml-2 mr-2">
                        <a class="nav-link mb-2 text-center" id="rounded-pills-icon-settings-tab" data-toggle="pill"
                            href="#rounded-pills-icon-settings" role="tab"
                            aria-controls="rounded-pills-icon-settings" aria-selected="false"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-calendar">
                                <rect x="3" y="4" width="18" height="18" rx="2"
                                    ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg> PROXIMAS</a>
                    </li>
                </ul>
                <div class="tab-content" id="rounded-pills-icon-tabContent">
                    <div class="tab-pane fade show active" id="rounded-pills-icon-home" role="tabpanel"
                        aria-labelledby="rounded-pills-icon-home-tab">
                        <div class="row">
                            @foreach ($horariosActuales as $horarioA)
                                <div class="col-sm-12 col-md-4">
                                    <div class="card component-card_9">
                                        <img src="{{ asset('storage/asignaturas/' . $horarioA->asignatura->image) }}"
                                            class="card-img-top" alt="widget-card-2">
                                        <div class="card-body">
                                            <p class="meta-date">
                                                {{ strtoupper(\Carbon\Carbon::parse($horarioA->periodo)->formatLocalized('%B %Y')) }}
                                            </p>
                                            <h5 class="card-title">{{ $horarioA->asignatura->nombre }}</h5>
                                            <p class="card-text">Horario:
                                                De {{ $horarioA->hora_inicio }} a {{ $horarioA->hora_fin }} <br>
                                                Aula: {{ $horarioA->aula->codigo }}</p>
                                            <div class="meta-info">
                                                <div class="meta-user">
                                                    <div class="user-name">Instructor:
                                                        {{ $horarioA->professor->nombre }}
                                                    </div>
                                                    <a href="{{ url('cursos/' . $horarioA->id) }}"
                                                        class="btn btn-secondary "> Ingresar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="rounded-pills-icon-profile" role="tabpanel"
                        aria-labelledby="rounded-pills-icon-profile-tab">
                        <div class="row">
                            @foreach ($horariosPasados as $horarioP)
                                <div class="col-sm-12 col-md-4">
                                    <div class="card component-card_9">
                                        <img src="{{ asset('storage/asignaturas/' . $horarioP->asignatura->image) }}"
                                            class="card-img-top" alt="widget-card-2">
                                        <div class="card-body">
                                            <p class="meta-date">
                                                {{ strtoupper(\Carbon\Carbon::parse($horarioP->periodo)->formatLocalized('%B %Y')) }}
                                            </p>
                                            <h5 class="card-title">{{ $horarioP->asignatura->nombre }}</h5>
                                            <p class="card-text">Horario:
                                                De {{ $horarioP->hora_inicio }} a {{ $horarioP->hora_fin }} <br>
                                                Aula: {{ $horarioP->aula->codigo }}</p>
                                            <div class="meta-info">
                                                <div class="meta-user">
                                                    <div class="user-name">Instructor:
                                                        {{ $horarioP->professor->nombre }}
                                                    </div>
                                                    <a href="{{ url('cursos/' . $horarioP->id) }}"
                                                        class="btn btn-secondary "> Ingresar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="rounded-pills-icon-contact" role="tabpanel"
                        aria-labelledby="rounded-pills-icon-contact-tab">
                        <div class="row">
                            @foreach ($horariosDisponibles as $horarioD)
                                <div class="col-sm-12 col-md-4">
                                    <div class="card component-card_9">
                                        <img src="{{ asset('storage/asignaturas/' . $horarioD->asignatura->image) }}"
                                            class="card-img-top" alt="widget-card-2">
                                        <div class="card-body">
                                            <p class="meta-date">
                                                {{ strtoupper(\Carbon\Carbon::parse($horarioD->periodo)->formatLocalized('%B %Y')) }}
                                            </p>
                                            <h5 class="card-title">{{ $horarioD->asignatura->nombre }}</h5>
                                            <p class="card-text">Horario:
                                                De {{ $horarioD->hora_inicio }} a {{ $horarioD->hora_fin }} <br>
                                                Aula: {{ $horarioD->aula->codigo }}</p>
                                            <div class="meta-info">
                                                <div class="meta-user">
                                                    <div class="user-name">Instructor:
                                                        {{ $horarioD->professor->nombre }}
                                                    </div>
                                                    <a href=""
                                                        class="btn btn-secondary "> Ver información
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="rounded-pills-icon-settings" role="tabpanel"
                        aria-labelledby="rounded-pills-icon-settings-tab">
                        <div class="row">
                            @foreach ($horariosProximos as $horarioPr)
                                <div class="col-sm-12 col-md-4">
                                    <div class="card component-card_9">
                                        <img src="{{ asset('storage/asignaturas/' . $horarioPr->asignatura->image) }}"
                                            class="card-img-top" alt="widget-card-2">
                                        <div class="card-body">
                                            <p class="meta-date">
                                                {{ strtoupper(\Carbon\Carbon::parse($horarioPr->periodo)->formatLocalized('%B %Y')) }}
                                            </p>
                                            <h5 class="card-title">{{ $horarioPr->asignatura->nombre }}</h5>
                                            <p class="card-text">Horario:
                                                De {{ $horarioPr->hora_inicio }} a {{ $horarioPr->hora_fin }} <br>
                                                Aula: {{ $horarioPr->aula->codigo }}</p>
                                            <div class="meta-info">
                                                <div class="meta-user">
                                                    <div class="user-name">Instructor:
                                                        {{ $horarioPr->professor->nombre }}
                                                    </div>
                                                    <a href=""
                                                        class="btn btn-secondary "> Ver información
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@section('javascript')
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('plugins/highlight/highlight.pack.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
@endsection
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
    });

    function Confirm(id, name) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmar eliminar la categoria ' + '"' + name + '"?.',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script> --}}
