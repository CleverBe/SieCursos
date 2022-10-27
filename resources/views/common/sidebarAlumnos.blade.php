@section('sidebar')
    <li>
        <a href="{{ url('cursos' . '/' . $horario_id->id) }}"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                    <circle cx="12" cy="12" r="10"></circle>
                </svg></span> Inicio curso </a>
    </li>
    <li>
        <a href="{{ url('misNotas' . '/' . $horario_id->id) }}"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                    <circle cx="12" cy="12" r="10"></circle>
                </svg></span> Mis notas </a>
    </li>
    <li>
        <a href="{{ url('misPagos' . '/' . $horario_id->id) }}"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle">
                    <circle cx="12" cy="12" r="10"></circle>
                </svg></span> Mis pagos </a>
    </li>
@endsection
