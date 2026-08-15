<?php

namespace App\Livewire\Pagamento;

use Livewire\Component;
use App\Models\Reserva;
use App\Models\Pagamento;

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


        Pagamento::create($dados);


        session()->flash(
            'success',
            'Pagamento cadastrado com sucesso!'
        );


        return redirect()
            ->route('pagamentos.index');
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