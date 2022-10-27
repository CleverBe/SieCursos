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
                                <option value="" selected>Todas</option>
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

                    <div class="col-sm-12 col-md-3">
                        <h6>Elige el tipo de Reporte</h6>
                        <div class="form-group">
                            <select wire:model="reportType" class="form-control">
                                <option value="0">Pagos del día</option>
                                <option value="1">Pagos por fecha</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <h6>Fecha desde</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date"
                                wire:model="dateFrom" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <h6>Fecha hasta</h6>
                        <div class="form-group">
                            <input @if ($reportType == 0) disabled @endif type="date" wire:model="dateTo"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 mt-4">
                        <a class="btn btn-secondary btn-block mb-4 mr-2 btn-lg {{ count($data) < 1 ? 'disabled' : '' }}"
                            href="{{ url('reportePagos/pdf' . '/' . $periodoFiltro . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo . '/' . $cursoFiltro . '/' . $horarioFiltro) }}">
                            Generar PDF</a>
                    </div>


                    <div class="col-sm-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-1">
                                <thead class="text-white">
                                    <tr>
                                        <th class="table-th text-withe text-center">#</th>
                                        <th class="table-th text-withe text-center">Modulo</th>
                                        <th class="table-th text-withe text-center">Monto</th>
                                        <th class="table-th text-withe text-center">Fecha de pago</th>
                                        <th class="table-th text-withe text-center">Mes de pago</th>
                                        <th class="table-th text-withe text-center">Alumno</th>
                                        <th class="table-th text-withe text-center">Curso</th>
                                        <th class="table-th text-withe text-center">Horario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $d)
                                        <tr>
                                            <td class="text-center">
                                                <h6 class="text-center">{{ $loop->iteration }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->modulo }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->monto }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">
                                                    {{ \Carbon\Carbon::parse($d->fecha_pago)->format('d/m/Y H:i') }}
                                                </h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">
                                                    {{ strtoupper(\Carbon\Carbon::parse($d->mes_pago)->formatLocalized('%B %Y')) }}
                                                </h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->nombreAlumno }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->nombreCurso }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="text-center">{{ $d->codigo }}
                                                    {{ $d->hora_inicio }}-{{ $d->hora_fin }}</h6>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11">
                                                <h5 class="text-center">Sin Resultados</h5>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
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
