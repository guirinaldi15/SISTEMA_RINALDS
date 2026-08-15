<?php

namespace App\Livewire\Pagamento;

use Livewire\Component;
use App\Models\Pagamento;

class PagamentoIndex extends Component
{
    public $search = '';
    public $status = '';

    public function marcarComoPago($id)
    {
        $pagamento =
            Pagamento::findOrFail($id);

        $pagamento->update([
            'status' => 'pago',
            'data_pagamento' => today(),
        ]);

        session()->flash(
            'success',
            'Pagamento marcado como pago!'
        );
    }

    public function render()
    {
        $pagamentos =
            Pagamento::query()

            ->with([
                'reserva.cliente'
            ])

            ->when(
                $this->search,
                function ($query) {

                    $query->where(
                        'descricao',
                        'like',
                        '%' . $this->search . '%'
                    )

                    ->orWhereHas(
                        'reserva.cliente',
                        function ($q) {

                            $q->where(
                                'nome',
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

                    if (
                        $this->status === 'atrasado'
                    ) {

                        $query
                            ->where(
                                'status',
                                'pendente'
                            )
                            ->whereDate(
                                'data_vencimento',
                                '<',
                                today()
                            );

                    } else {

                        $query->where(
                            'status',
                            $this->status
                        );

                    }

                }
            )

            ->orderBy('data_vencimento')
            ->get();


        $totalRecebido =
            Pagamento::where(
                'status',
                'pago'
            )
            ->sum('valor');


        $totalPendente =
            Pagamento::where(
                'status',
                'pendente'
            )
            ->sum('valor');


        $totalAtrasado =
            Pagamento::where(
                'status',
                'pendente'
            )
            ->whereDate(
                'data_vencimento',
                '<',
                today()
            )
            ->sum('valor');


        return view(
            'livewire.pagamento.pagamento-index',
            compact(
                'pagamentos',
                'totalRecebido',
                'totalPendente',
                'totalAtrasado'
            )
        );
    }
}