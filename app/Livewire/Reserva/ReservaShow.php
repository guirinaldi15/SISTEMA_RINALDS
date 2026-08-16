<?php

namespace App\Livewire\Reserva;

use App\Models\Reserva;
use Livewire\Component;

class ReservaShow extends Component
{
    public Reserva $reserva;


    public function mount(int $id): void
    {
        $this->reserva =
            Reserva::with([
                'cliente',
                'atendimento',
                'espaco',
                'pagamentos',
            ])
                ->findOrFail($id);
    }


    public function render()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL PAGO
        |--------------------------------------------------------------------------
        */

        $totalPago =
            $this->reserva
                ->pagamentos
                ->where(
                    'status',
                    'pago'
                )
                ->sum(
                    'valor'
                );


        /*
        |--------------------------------------------------------------------------
        | SALDO RESTANTE
        |--------------------------------------------------------------------------
        */

        $saldoRestante =
            max(
                0,
                (float)
                $this->reserva
                    ->valor_total
                -
                (float)
                $totalPago
            );


        /*
        |--------------------------------------------------------------------------
        | PERCENTUAL PAGO
        |--------------------------------------------------------------------------
        */

        $percentualPago = 0;


        if (
            (float)
            $this->reserva
                ->valor_total
            > 0
        ) {

            $percentualPago =
                (
                    (float)
                    $totalPago
                    /
                    (float)
                    $this->reserva
                        ->valor_total
                )
                *
                100;
        }


        $percentualPago =
            min(
                100,
                round(
                    $percentualPago,
                    2
                )
            );


        /*
        |--------------------------------------------------------------------------
        | PAGAMENTOS ATRASADOS
        |--------------------------------------------------------------------------
        */

        $pagamentosAtrasados =
            $this->reserva
                ->pagamentos
                ->filter(
                    function (
                        $pagamento
                    ) {

                        return
                            $pagamento
                                ->status
                            ===
                            'pendente'

                            &&

                            $pagamento
                                ->data_vencimento

                            &&

                            $pagamento
                                ->data_vencimento
                                ->isPast();
                    }
                );


        /*
        |--------------------------------------------------------------------------
        | PAGAMENTOS ORDENADOS
        |--------------------------------------------------------------------------
        */

        $pagamentos =
            $this->reserva
                ->pagamentos
                ->sortBy(
                    'data_vencimento'
                );


        /*
        |--------------------------------------------------------------------------
        | SITUAÇÃO FINANCEIRA
        |--------------------------------------------------------------------------
        */

        if (
            (float)
            $this->reserva
                ->valor_total
            <= 0
        ) {

            $situacaoFinanceira =
                'sem_valor';

        } elseif (
            $saldoRestante <= 0
        ) {

            $situacaoFinanceira =
                'quitada';

        } elseif (
            $pagamentosAtrasados
                ->count()
            > 0
        ) {

            $situacaoFinanceira =
                'atrasada';

        } elseif (
            $totalPago > 0
        ) {

            $situacaoFinanceira =
                'parcial';

        } else {

            $situacaoFinanceira =
                'pendente';
        }


        return view(
            'livewire.reserva.reserva-show',
            compact(
                'totalPago',
                'saldoRestante',
                'percentualPago',
                'pagamentosAtrasados',
                'pagamentos',
                'situacaoFinanceira'
            )
        );
    }
}