<?php

namespace App\Livewire\Reserva;

use Livewire\Component;
use App\Models\Reserva;

class ReservaIndex extends Component
{
    public $search = '';

    public $status = '';


    public function render()
    {
        $reservas =
            Reserva::query()

            ->with([
                'cliente',
                'pagamentos'
            ])

            ->when(
                $this->search,
                function ($query) {

                    $query->whereHas(
                        'cliente',
                        function ($q) {

                            $q->where(
                                'nome',
                                'like',
                                '%' .
                                $this->search .
                                '%'
                            )

                            ->orWhere(
                                'telefone',
                                'like',
                                '%' .
                                $this->search .
                                '%'
                            );

                        }
                    );

                }
            )

            ->when(
                $this->status,
                function ($query) {

                    $query->where(
                        'status',
                        $this->status
                    );

                }
            )

            ->orderBy(
                'data_evento'
            )

            ->get();


        return view(
            'livewire.reserva.reserva-index',
            compact('reservas')
        );
    }
}