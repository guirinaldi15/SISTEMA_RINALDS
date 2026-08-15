<?php

namespace App\Livewire\Pagamento;

use Livewire\Component;
use App\Models\Pagamento;
use App\Models\Reserva;

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
        $dados =
            $this->validate();


        if (
            $this->status === 'pago'
            &&
            !$this->data_pagamento
        ) {

            $dados['data_pagamento'] =
                today();

        }


        if (
            $this->status !== 'pago'
        ) {

            $dados['data_pagamento'] =
                null;

        }


        $this->pagamento
            ->update($dados);


        session()->flash(
            'success',
            'Pagamento atualizado com sucesso!'
        );


        return redirect()
            ->route('pagamentos.index');
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