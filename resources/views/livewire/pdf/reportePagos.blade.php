<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Pagos</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
</head>

<body>
    <section class="header" style="top: -287px">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="text-center" colspan="2">
                    <span style="font-size: 25px; font-weight:bold;">SIE Cursos</span>
                </td>
            </tr>
            <tr>
                <td width="30%" class="text-center"
                    style="vertical-align: top; padding-top:10px; position:relative;">
                    <img src="assets/img/logo.jpg" alt="" class="invoice-logo">
                </td>

                <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top:10px;">

                    <span style="font-size: 16px;">
                        <strong>
                            Reporte de la gestión:
                            {{ strtoupper(\Carbon\Carbon::parse($periodoFiltro)->formatLocalized('%B %Y')) }}
                        </strong>
                    </span>
                    <br>
                    @if ($reportType == 0)
                        <span style="font-size: 16px;"><strong>Reporte de pagos del día</strong></span>
                    @else
                        <span style="font-size: 16px;"><strong>Reporte de pagos por fecha</strong></span>
                    @endif

                    <br>
                    @if ($reportType != 0)
                        <span style="font-size: 16px;"><strong>Fecha de consulta:
                                {{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} al
                                {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}</strong></span>
                    @else
                        <span style="font-size: 16px;"><strong>Fecha de consulta:
                                {{ \Carbon\Carbon::now()->format('d/m/Y') }}</strong></span>
                    @endif

                    <br>
                    <span style="font-size: 16px;"><strong>Del curso:
                            {{ $nombreAsignatura }}</strong></span>
                    <br>
                    <span style="font-size: 16px;"><strong>Del Horario:
                            {{ $horarioInfo }}</strong></span>
                    <br>
                </td>
            </tr>
        </table>
    </section>

    <section style="margin-top: -110px;">
        <table cellpadding="0" cellspacing="-1" class="table-items" width="100%" height="50%">
            <thead>
                <tr>
                    <th width="10%">Nº</th>
                    <th width='10%'>Modulo</th>
                    <th width='10%'>Monto</th>
                    <th width='20%'>Fecha de pago</th>
                    <th width='20%'>Mes de pago</th>
                    <th width='10%'>Alumno</th>
                    <th width='10%'>Curso</th>
                    <th width='10%'>Horario</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1> {{ $loop->iteration }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->modulo }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->monto }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>
                                {{ \Carbon\Carbon::parse($item->fecha_pago)->format('d/m/Y H:i') }}
                            </FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>
                                {{ strtoupper(\Carbon\Carbon::parse($item->mes_pago)->formatLocalized('%B %Y')) }}
                            </FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->nombreAlumno }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->nombreCurso }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->codigo }}
                                {{ $item->hora_inicio }}-{{ $item->hora_fin }}</FONT>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <br>

            <tfoot>
                <tr>
                    {{-- <td colspan="2" class="text-left">
                        <span><b>TOTALES</b></span>
                    </td>
                    <td class="text-right" colspan="7">
                        <span><strong>${{ number_format($total, 2) }}</strong></span>
                    </td> --}}
                </tr>
            </tfoot>
        </table>
    </section>

    <section class="footer">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="20%">
                    <span>SIE Cursos</span>
                </td>
                <td width="60%" class="text-center"> sieemanuelsie@gmail.com</td>
                <td class="text-center" width="20%">
                    <span>Página</span><span class="pagenum">-</span>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
