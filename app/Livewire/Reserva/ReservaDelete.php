<?php

namespace App\Livewire\Reserva;

use Livewire\Component;
use App\Models\Reserva;

class ReservaDelete extends Component
{
    public Reserva $reserva;

    public function mount($id)
    {
        $this->reserva =
            Reserva::with('cliente')
                ->findOrFail($id);
    }

    public function excluir()
    {
        $this->reserva->delete();

        session()->flash(
            'success',
            'Reserva excluída com sucesso!'
        );

        return redirect()
            ->route('reservas.index');
    }

    public function render()
    {
        return view(
            'livewire.reserva.reserva-delete'
        );
    }
}