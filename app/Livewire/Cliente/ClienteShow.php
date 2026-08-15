<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use App\Models\Cliente;

class ClienteShow extends Component
{
    public Cliente $cliente;

    public function mount($id)
    {
        $this->cliente = Cliente::with([
            'atendimentos' => function ($query) {
                $query->orderByDesc('updated_at');
            },

            'atendimentos.lembretes' => function ($query) {
                $query->orderBy('lembrar_em');
            },

            'reservas' => function ($query) {
                $query->orderByDesc('data_evento');
            },
        ])->findOrFail($id);
    }

    public function render()
    {
        /*
        |--------------------------------------------------------------------------
        | Estatísticas do cliente
        |--------------------------------------------------------------------------
        */

        $totalAtendimentos =
            $this->cliente->atendimentos->count();

        $totalReservas =
            $this->cliente->reservas->count();

        $reservasConfirmadas =
            $this->cliente
                ->reservas
                ->where('status', 'confirmada')
                ->count();

        /*
        |--------------------------------------------------------------------------
        | Todos os lembretes dos atendimentos deste cliente
        |--------------------------------------------------------------------------
        */

        $lembretes =
            $this->cliente
                ->atendimentos
                ->flatMap(function ($atendimento) {
                    return $atendimento->lembretes;
                })
                ->sortBy('lembrar_em');

        $lembretesPendentes =
            $lembretes
                ->where('status', 'pendente');

        /*
        |--------------------------------------------------------------------------
        | Próxima reserva
        |--------------------------------------------------------------------------
        */

        $proximaReserva =
            $this->cliente
                ->reservas
                ->filter(function ($reserva) {
                    return
                        $reserva->data_evento
                            ->greaterThanOrEqualTo(today())

                        && in_array(
                            $reserva->status,
                            [
                                'pre_reserva',
                                'confirmada'
                            ]
                        );
                })
                ->sortBy('data_evento')
                ->first();

        return view(
            'livewire.cliente.cliente-show',
            compact(
                'totalAtendimentos',
                'totalReservas',
                'reservasConfirmadas',
                'lembretes',
                'lembretesPendentes',
                'proximaReserva'
            )
        );
    }
}