<?php

namespace App\Livewire\Pagamento;

use Livewire\Component;
use App\Models\Reserva;
use App\Models\Pagamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PagamentoCreate extends Component
{
    public $reserva_id;
    public $descricao;
    public $valor;
    public $data_vencimento;
    public $data_pagamento;
    public $forma_pagamento;
    public $status = 'pendente';
    public $observacoes;


    public function mount()
    {
        if (
            request()->has('reserva')
        ) {

            $reserva =
                Reserva::findOrFail(
                    request()->get('reserva')
                );

            $this->reserva_id =
                $reserva->id;
        }
    }


    protected $rules = [

        'reserva_id' =>
        'required|exists:reservas,id',

        'descricao' =>
        'required|max:150',

        'valor' =>
        'required|numeric|min:0.01',

        'data_vencimento' =>
        'required|date',

        'data_pagamento' =>
        'nullable|date',

        'forma_pagamento' =>
        'nullable|in:pix,dinheiro,cartao_credito,cartao_debito,transferencia,boleto,outro',

        'status' =>
        'required|in:pendente,pago,cancelado',

        'observacoes' =>
        'nullable|max:2000',
    ];



    public function salvar()
    {
        $dados = $this->validate();

        DB::transaction(function () use ($dados) {

            /*
        |--------------------------------------------------------------------------
        | BLOQUEAR RESERVA DURANTE O PAGAMENTO
        |--------------------------------------------------------------------------
        */

            $reserva = Reserva::query()
                ->whereKey($dados['reserva_id'])
                ->lockForUpdate()
                ->firstOrFail();

            /*
        |--------------------------------------------------------------------------
        | NÃO PERMITIR PAGAMENTOS EM RESERVAS CANCELADAS
        |--------------------------------------------------------------------------
        */

            if ($reserva->status === 'cancelada') {
                throw ValidationException::withMessages([
                    'reserva_id' =>
                    'Não é possível cadastrar pagamentos para uma reserva cancelada.',
                ]);
            }

            /*
        |--------------------------------------------------------------------------
        | VALIDAR SALDO RESTANTE
        |--------------------------------------------------------------------------
        */

            if ($dados['status'] === 'pago') {

                $totalPago = (float) Pagamento::query()
                    ->where('reserva_id', $reserva->id)
                    ->where('status', 'pago')
                    ->sum('valor');

                $valorTotal = (float) $reserva->valor_total;

                $saldoRestante = max(
                    0,
                    round($valorTotal - $totalPago, 2)
                );

                if (
                    $saldoRestante <= 0 ||
                    round((float) $dados['valor'], 2) > $saldoRestante
                ) {
                    throw ValidationException::withMessages([
                        'valor' =>
                        'O pagamento ultrapassa o saldo restante de R$ ' .
                            number_format(
                                $saldoRestante,
                                2,
                                ',',
                                '.'
                            ) . '.',
                    ]);
                }
            }

            /*
        |--------------------------------------------------------------------------
        | DEFINIR DATA DO PAGAMENTO
        |--------------------------------------------------------------------------
        */

            if ($dados['status'] === 'pago') {

                if (empty($dados['data_pagamento'])) {
                    $dados['data_pagamento'] = today();
                }
            } else {

                $dados['data_pagamento'] = null;
            }

            /*
        |--------------------------------------------------------------------------
        | CADASTRAR PAGAMENTO
        |--------------------------------------------------------------------------
        */

            Pagamento::create($dados);
        }, 3);

        session()->flash(
            'success',
            'Pagamento cadastrado com sucesso!'
        );

        return redirect()->route('pagamentos.index');
    }


    public function render()
    {
        $reservas =
            Reserva::with('cliente')
            ->whereNotIn(
                'status',
                ['cancelada']
            )
            ->orderByDesc(
                'data_evento'
            )
            ->get();


        return view(
            'livewire.pagamento.pagamento-create',
            compact('reservas')
        );
    }
}
