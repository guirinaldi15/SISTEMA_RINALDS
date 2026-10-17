<?php

namespace App\Livewire\Pagamento;

use Livewire\Component;
use App\Models\Pagamento;
use App\Models\Reserva;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PagamentoEdit extends Component
{
    public Pagamento $pagamento;

    public $reserva_id;
    public $descricao;
    public $valor;
    public $data_vencimento;
    public $data_pagamento;
    public $forma_pagamento;
    public $status;
    public $observacoes;


    public function mount($id)
    {
        $this->pagamento =
            Pagamento::findOrFail($id);

        $this->reserva_id =
            $this->pagamento->reserva_id;

        $this->descricao =
            $this->pagamento->descricao;

        $this->valor =
            $this->pagamento->valor;

        $this->data_vencimento =
            $this->pagamento
            ->data_vencimento
            ->format('Y-m-d');

        $this->data_pagamento =
            $this->pagamento
            ->data_pagamento
            ?->format('Y-m-d');

        $this->forma_pagamento =
            $this->pagamento
            ->forma_pagamento;

        $this->status =
            $this->pagamento->status;

        $this->observacoes =
            $this->pagamento->observacoes;
    }


    protected function rules()
    {
        return [

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
    }



    public function atualizar()
    {
        $dados = $this->validate();

        DB::transaction(function () use ($dados) {

            /*
        |--------------------------------------------------------------------------
        | BLOQUEAR A RESERVA DE DESTINO
        |--------------------------------------------------------------------------
        */

            $reserva = Reserva::query()
                ->whereKey($dados['reserva_id'])
                ->lockForUpdate()
                ->firstOrFail();

            /*
        |--------------------------------------------------------------------------
        | IMPEDIR PAGAMENTO EM RESERVA CANCELADA
        |--------------------------------------------------------------------------
        */

            if ($reserva->status === 'cancelada') {
                throw ValidationException::withMessages([
                    'reserva_id' =>
                    'Não é possível vincular pagamentos a uma reserva cancelada.',
                ]);
            }

            /*
        |--------------------------------------------------------------------------
        | VERIFICAR SALDO DISPONÍVEL
        |--------------------------------------------------------------------------
        */

            if ($dados['status'] === 'pago') {

                // Soma os pagamentos recebidos,
                // excluindo o pagamento em edição.

                $totalOutrosPagamentos = Pagamento::query()
                    ->where('reserva_id', $reserva->id)
                    ->where('status', 'pago')
                    ->where('id', '!=', $this->pagamento->id)
                    ->sum('valor');

                // Trabalha em centavos para evitar
                // diferenças de arredondamento.

                $totalCentavos = (int) round(
                    (float) $reserva->valor_total * 100
                );

                $pagosCentavos = (int) round(
                    (float) $totalOutrosPagamentos * 100
                );

                $novoPagamentoCentavos = (int) round(
                    (float) $dados['valor'] * 100
                );

                $saldoCentavos = max(
                    0,
                    $totalCentavos - $pagosCentavos
                );

                if ($novoPagamentoCentavos > $saldoCentavos) {
                    throw ValidationException::withMessages([
                        'valor' =>
                        'O pagamento ultrapassa o saldo disponível de R$ ' .
                            number_format(
                                $saldoCentavos / 100,
                                2,
                                ',',
                                '.'
                            ) . '.',
                    ]);
                }
            }

            /*
        |--------------------------------------------------------------------------
        | ATUALIZAR DATA DO PAGAMENTO
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
        | SALVAR ALTERAÇÕES
        |--------------------------------------------------------------------------
        */

            $this->pagamento->update($dados);
        }, 3);

        session()->flash(
            'success',
            'Pagamento atualizado com sucesso!'
        );

        return redirect()->route('pagamentos.index');
    }


    public function render()
    {
        $reservas =
            Reserva::with('cliente')
            ->orderByDesc(
                'data_evento'
            )
            ->get();


        return view(
            'livewire.pagamento.pagamento-edit',
            compact('reservas')
        );
    }
}
