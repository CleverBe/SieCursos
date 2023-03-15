<?php

namespace App\Http\Livewire;

use App\Models\Horario;
use App\Models\SolicitudPago;
use Livewire\Component;

class HeaderComponent extends Component
{
    public function render()
    {
        if (auth()->user()->profile == 'ADMIN') {
            $solicitudesPendientes = SolicitudPago::where('estado', 'PENDIENTE')->get();
        } else {
            $solicitudesPendientes = SolicitudPago::with('pago')->where('estado', '!=', 'PENDIENTE')->get();
        }

        return view('livewire.layouts.theme.header-component', [
            'solicitudesPendientes' => $solicitudesPendientes,
        ]);
    }

    public function vistoAdmin(SolicitudPago $solicitud)
    {
        $solicitud->visto_Admin = 'SI';
        $solicitud->save();
        return redirect()->route('solicitud', ['solicitud_id' => $solicitud->id]);
    }

    public function vistoStudent(SolicitudPago $solicitud, Horario $horario)
    {
        $solicitud->visto_Student = 'SI';
        $solicitud->save();
        return redirect()->route('misPagos', ['horario_id' => $horario->id]);
    }

    protected $listeners = ['render'];
}
