@include('common.sidebarAlumnos')

<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b class="text-center">Mis calificaciones del curso {{ $estudiante->nombreAsignatura }}</b><br>
                </h4>
            </div>

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
    </div>
</div>
