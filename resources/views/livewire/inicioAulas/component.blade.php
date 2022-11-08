@section('css')
    <link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
@endsection


<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b class="text-center">LISTADO DE CURSOS</b><br>
                </h4>
            </div>
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
                </ul>
                <div class="tab-content" id="rounded-pills-icon-tabContent">
                    <div class="tab-pane fade show active" id="rounded-pills-icon-home" role="tabpanel"
                        aria-labelledby="rounded-pills-icon-home-tab">
                        <div class="row">
                            @foreach ($horariosActuales as $horarioA)
                                <div class="col-sm-12 col-md-4">
                                    <div class="card component-card_9">
                                        <img style="max-width:350px;max-height:400px;"
                                            src="{{ asset('storage/asignaturas/' . $horarioA->asignatura->image) }}"
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
                                                        {{ $horarioA->professor->nombre }} <br>
                                                        <a href="{{ url('cursos/' . $horarioA->id) }}"
                                                            class="btn btn-secondary btn-block"> Ingresar
                                                        </a>
                                                    </div>
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
                                        <img style="max-width:350px;max-height:400px;"
                                            src="{{ asset('storage/asignaturas/' . $horarioP->asignatura->image) }}"
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
                                                        {{ $horarioP->professor->nombre }} <br>
                                                        <a href="{{ url('cursos/' . $horarioP->id) }}"
                                                            class="btn btn-secondary btn-block"> Ingresar
                                                        </a>
                                                    </div>
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
                                        <img style="max-width:350px;max-height:400px;"
                                            src="{{ asset('storage/asignaturas/' . $horarioD->asignatura->image) }}"
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
                                                        {{ $horarioD->professor->nombre }} <br>
                                                        <x-button wire:click.prevent="verInfo({{ $horarioD->id }})"
                                                            texto="Ver información" />
                                                    </div>
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
    @include('livewire.inicioAulas.informacion')
</div>

@section('javascript')
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('plugins/highlight/highlight.pack.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });
    });
</script>
