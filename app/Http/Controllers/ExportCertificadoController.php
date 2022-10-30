<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asignatura;
use App\Models\Horario;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportCertificadoController extends Controller
{

    public function reporte()
    {
        $pdf = Pdf::loadView('livewire.pdf.certificado')->setPaper('a4', 'landscape');

        return $pdf->stream('certificado.pdf');
        // return $pdf->download('ReporteAlumnos.pdf');  // descargar
    }
}
