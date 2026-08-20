<?php

namespace App\Livewire\Orcamento;

use App\Models\Orcamento;
use App\Models\Reserva;
use Livewire\Component;

class OrcamentoShow extends Component
{
    public Orcamento $orcamento;

    public bool $possuiReserva = false;

    public ?int $reservaId = null;


    public function mount(int $id): void
    {
        /*
        |--------------------------------------------------------------------------
        | CARREGAR ORÇAMENTO
        |--------------------------------------------------------------------------
        */

        $this->orcamento =
            Orcamento::with([
                'atendimento.cliente',
                'espaco',
            ])
                ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | VERIFICAR SE O ATENDIMENTO JÁ POSSUI RESERVA
        |--------------------------------------------------------------------------
        */

        $reserva =
            Reserva::query()
                ->where(
                    'atendimento_id',
                    $this->orcamento
                        ->atendimento_id
                )
                ->first();


        if ($reserva) {

            $this->possuiReserva = true;

            $this->reservaId =
                $reserva->id;
        }
    }


    public function render()
    {
        return view(
            'livewire.orcamento.orcamento-show'
        );
    }
}