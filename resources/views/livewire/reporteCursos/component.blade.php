@section('css')
    <link href="{{ asset('plugins/flatpickr/flatpickr.blue.css') }}" rel="stylesheet" type="text/css" />
@endsection
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{ $componentName }}</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Periodo</h6>
                            <input type="month" wire:model="periodoFiltro" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Curso</h6>
                            <select wire:model="cursoFiltro" class="form-control">
                                <option value="" selected>Todos</option>
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Horario</h6>
                            <select wire:model="horarioFiltro" class="form-control">
                                <option value="" selected>Todos</option>
                                @foreach ($horarios as $hor)
                                    <option value="{{ $hor->id }}">
                                        Aula: {{ $hor->aula->codigo }} Hora:
                                        {{ $hor->hora_inicio }}-{{ $hor->hora_fin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 mt-4">
                        <a class="btn btn-secondary btn-block mb-4 mr-2 btn-lg {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reporteCursos/pdf' . '/' . $periodoFiltro . '/' . $cursoFiltro . '/' . $horarioFiltro) }}">
                            Generar PDF</a>
                    </div>


                    <div class="col-sm-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-1">
                                <thead class="text-white">
                                    <tr>
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">Nombre</th>
                                        <th class="table-th text-withe text-center">Telefono</th>
                                        <th class="table-th text-withe text-center">Curso</th>
                                        <th class="table-th text-withe text-center">HORARIO</th>
                                        <th class="table-th text-withe text-center">Primera nota</th>
                                        <th class="table-th text-withe text-center">Segunda nota</th>
                                        <th class="table-th text-withe text-center">Nota final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $d)
                                        <tr>
                                            <td class="text-center">
                                                <h6 class="text-center">{{ $loop->iteration }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->nombreAlumno }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->telefono }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->nombreAsignatura }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->codigo }}
                                                    {{ $d->hora_inicio }}-{{ $d->hora_fin }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->primera_nota }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->segunda_nota }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->nota_final }}</h6>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
                                                <h5 class="text-center">Sin Resultados</h5>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <h5 class="text-dark-right">Promedio de nota de los estudiantes
                                            </h5>
                                        </td>
                                        <td>
                                            <h5 class="text-dark text-center">
                                                {{ $promedioNotas }}</h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- @include('livewire.reporteCursos.modal_details') --}}
</div>

@section('javascript')
    <script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofweek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
            }
        })
        //eventos
        window.livewire.on('show-modal', msg => {
            $('#modalDetails').modal('show')
        });
    })
</script>
