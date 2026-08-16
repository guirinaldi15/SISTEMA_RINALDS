<?php

namespace App\Livewire\Reserva;

use App\Models\Reserva;
use Livewire\Component;

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
                    'espaco',
                    'pagamentos',
                ])

                ->when(
                    $this->search,
                    function ($query) {

                        $query->where(
                            function ($q) {

                                $q->whereHas(
                                    'cliente',
                                    function ($clienteQuery) {

                                        $clienteQuery
                                            ->where(
                                                'nome',
                                                'like',
                                                '%' . $this->search . '%'
                                            )

                                            ->orWhere(
                                                'telefone',
                                                'like',
                                                '%' . $this->search . '%'
                                            );
                                    }
                                )

                                ->orWhereHas(
                                    'espaco',
                                    function ($espacoQuery) {

                                        $espacoQuery
                                            ->where(
                                                'nome',
                                                'like',
                                                '%' . $this->search . '%'
                                            );
                                    }
                                )

                                ->orWhere(
                                    'tipo_evento',
                                    'like',
                                    '%' . $this->search . '%'
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
            compact(
                'reservas'
            )
        );
    }
}