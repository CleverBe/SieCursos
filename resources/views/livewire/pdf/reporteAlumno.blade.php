<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Alumnos</title>
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
                    <th width="5%">Nº</th>
                    <th width="10%">Nombre</th>
                    <th width="20%">Telefono</th>
                    <th width="20%">Curso</th>
                    <th width="15%">Horario</th>
                    <th width="10%">Primera nota</th>
                    <th width="10%">Segunda nota</th>
                    <th width="10%">Nota final</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1> {{ $loop->iteration }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->nombreAlumno }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1> {{ $item->telefono }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->nombreAsignatura }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->codigo }}
                                {{ $item->hora_inicio }}-{{ $item->hora_fin }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->primera_nota }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->segunda_nota }}</FONT>
                        </td>
                        <td align="center">
                            <FONT FACE="times new roman" SIZE=1>{{ $item->nota_final }}</FONT>
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
