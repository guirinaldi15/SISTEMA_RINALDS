<?php

namespace App\Livewire\Atendimento;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Atendimento;

class AtendimentoCreate extends Component
{
    public $cliente_id;

    public $origem = 'WhatsApp';

    public $tipo_evento;

    public $data_evento;

    public $status = 'novo';

    public $ultimo_contato;

    public $observacoes;

    public $motivo_perda;


    protected $rules = [

        'cliente_id' =>
            'required|exists:clientes,id',

        'origem' =>
            'required|max:50',

        'tipo_evento' =>
            'nullable|max:100',

        'data_evento' =>
            'nullable|date',

        'status' =>
            'required|in:novo,aguardando_data,orcamento_enviado,aguardando_cliente,negociacao,fechado,perdido',

        'ultimo_contato' =>
            'nullable|date',

        'observacoes' =>
            'nullable|max:3000',

        'motivo_perda' =>
            'nullable|max:1000',

    ];


    protected $messages = [

        'cliente_id.required' =>
            'Selecione um cliente.',

        'origem.required' =>
            'Informe a origem do atendimento.',

    ];


    public function salvar()
    {
        $dados = $this->validate();

        if (!$this->ultimo_contato) {

            $dados['ultimo_contato'] = now();

        }

        Atendimento::create($dados);

        session()->flash(
            'success',
            'Atendimento cadastrado com sucesso!'
        );

        return redirect()
            ->route('atendimentos.index');
    }


    public function render()
    {
        $clientes =
            Cliente::orderBy('nome')->get();

        return view(
            'livewire.atendimento.atendimento-create',
            compact('clientes')
        );
    }
}