@section('css')
    <link href="{{ asset('assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
@endsection

@role('PROFESSOR')
    @include('common.listaSideBarCurso')
@endcan

@role('STUDENT')
    @include('common.sidebarAlumnos')
@endcan

<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h2 class="card-title">
                    <b class="text-center">Bienvenido al curso</b>
                </h2>
            </div>
            <div class="widget-content {{-- widget-content-area --}} animated-underline-content">

                <ul class="nav nav-tabs  mb-3" id="animateLine" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="animated-underline-home-tab" data-toggle="tab" href="#home"
                            role="tab" aria-controls="animated-underline-home" aria-selected="true"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg> Inicio</a>
                    </li>
                    @role('STUDENT')
                        <li class="nav-item">
                            <a class="nav-link" id="animated-underline-notas-tab" data-toggle="tab" href="#notasPanel"
                                role="tab" aria-controls="animated-underline-notas" aria-selected="false"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> Mis notas</a>
                        </li>
                    @endcan
                </ul>

                <div class="tab-content" id="animateLineContent-4">
                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                        aria-labelledby="animated-underline-home-tab">
                        <div class="row sales layout-top-spacing">
                            <div class="col-sm-12">

                                <div class="widget-heading">
                                    <h4 class="card-title">
                                        <b>{{ $asignatura }}</b>
                                    </h4>
                                    <ul class="tabs tab-pills">
                                        @can('subir_material')
                                            <x-button wire:click="Agregar()" texto="Subir material" />
                                        @endcan
                                    </ul>
                                </div>
                                <div>
                                    <p><b>Horario de la asignatura:</b> {{ $hora_inicio }}-{{ $hora_fin }}
                                    </p>
                                    <p><b>Profesor asignado:</b> {{ $professor }}</p>
                                    <p><b>Descripción del curso:</b> {{ $descripcion }}</p>
                                    <h5>Material de este curso</h5>
                                </div>
                                <div class="widget-content">
                                    <div class="row">
                                        @foreach ($materiales as $materi)
                                            <div class="col-sm-12 col-md-4 mt-2 mb-2">
                                                <div class="card component-card_1">
                                                    <div class="card-body">
                                                        <div class="icon-svg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="50"
                                                                height="50" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-file">
                                                                <path
                                                                    d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                                                </path>
                                                                <polyline points="13 2 13 9 20 9"></polyline>
                                                            </svg>
                                                        </div>
                                                        <h5 class="card-title"></h5>
                                                        <p class="card-text"><b>Titulo: {{ $materi->nombre }}</b></p>
                                                        <p class="card-text">Archivo: {{ $materi->nombre_archivo }}</p>
                                                        <p class="card-text">Comentario: {{ $materi->comentario }}</p>
                                                        <x-button wire:click="export('{{ $materi->nombre_archivo }}')"
                                                            texto="Descargar" title="Descargar" color="primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-download-cloud">
                                                                <polyline points="8 17 12 21 16 17"></polyline>
                                                                <line x1="12" y1="12" x2="12"
                                                                    y2="21">
                                                                </line>
                                                                <path
                                                                    d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29">
                                                                </path>
                                                            </svg>
                                                        </x-button>
                                                        @can('editar_material')
                                                            <x-button wire:click="Edit({{ $materi->id }})"
                                                                texto="Editar" title="Editar" color="info">
                                                                <i class="far fa-edit"></i>
                                                            </x-button>
                                                        @endcan
                                                        @can('eliminar_material')
                                                            <x-button
                                                                onclick="Confirm('{{ $materi->id }}','{{ $materi->nombre }}')"
                                                                texto="Eliminar" title="Eliminar" color="danger">
                                                                <i class="far fa-trash-alt"></i>
                                                            </x-button>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @role('STUDENT')
                        <div class="tab-pane fade" id="notasPanel" role="tabpanel"
                            aria-labelledby="animated-underline-notas-tab">
                            <div class="user-profile layout-spacing">
                                <div class="widget-content widget-content-area">
                                    <div class="text-center user-info">
                                        <p class="">Estudiante : {{ $estudiante->nombreEstudiante }}</p>
                                    </div>
                                    <div class="user-info-list">

                                        <div class="">
                                            <ul class="contacts-block list-unstyled">
                                                <li class="contacts-block__item">
                                                    Primera nota : {{ $estudiante->primera_nota }}
                                                </li>
                                                <li class="contacts-block__item">
                                                    Segunda nota : {{ $estudiante->segunda_nota }}
                                                </li>
                                                <li class="contacts-block__item">
                                                    Nota final : {{ $estudiante->nota_final }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>

        </div>

    </div>
    @include('livewire.inicioCurso.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide')
            noty(msg, 1)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg, 2)
        });
        window.livewire.on('item-deleted', msg => {
            noty(msg, 0)
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('item-error', msg => {
            noty(msg, 0)
        });
    });

    function Confirm(id, name) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente quiere eliminar el archivo ' + '"' + name + '"?.',
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
</script>
