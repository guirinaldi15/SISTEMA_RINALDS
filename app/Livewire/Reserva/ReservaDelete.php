<?php

namespace App\Livewire\Reserva;

use App\Models\Reserva;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ReservaDelete extends Component
{
    public Reserva $reserva;

    public function mount($id): void
    {
        $this->reserva = Reserva::with('cliente')
            ->findOrFail($id);
    }

    public function excluir()
    {
        DB::transaction(function () {

            $reserva = Reserva::query()
                ->whereKey($this->reserva->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Preservar pagamentos registrados.

            if ($reserva->pagamentos()->exists()) {
                throw ValidationException::withMessages([
                    'exclusao' =>
                        'Esta reserva possui pagamentos vinculados. ' .
                        'Não é permitido excluí-la.',
                ]);
            }

            // Preservar o histórico das reservas
            // confirmadas e realizadas.

            if (in_array(
                $reserva->status,
                ['confirmada', 'realizada'],
                true
            )) {
                throw ValidationException::withMessages([
                    'exclusao' =>
                        'Reservas confirmadas ou realizadas ' .
                        'não podem ser excluídas diretamente.',
                ]);
            }

            $reserva->delete();

        }, 3);

        session()->flash(
            'success',
            'Reserva excluída com sucesso!'
        );

        return redirect()->route('reservas.index');
    }

    public function render()
    {
        return view('livewire.reserva.reserva-delete');
    }
}
