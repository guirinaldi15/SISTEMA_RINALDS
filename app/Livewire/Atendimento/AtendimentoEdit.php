<?php

namespace App\Livewire\Atendimento;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Atendimento;

class AtendimentoEdit extends Component
{
    public Atendimento $atendimento;

    public $cliente_id;
    public $origem;
    public $tipo_evento;
    public $data_evento;
    public $status;
    public $ultimo_contato;
    public $observacoes;
    public $motivo_perda;


    public function mount($id)
    {
        $this->atendimento =
            Atendimento::findOrFail($id);

        $this->cliente_id =
            $this->atendimento->cliente_id;

        $this->origem =
            $this->atendimento->origem;

        $this->tipo_evento =
            $this->atendimento->tipo_evento;

        $this->data_evento =
            $this->atendimento->data_evento
                ?->format('Y-m-d');

        $this->status =
            $this->atendimento->status;

        $this->ultimo_contato =
            $this->atendimento->ultimo_contato
                ?->format('Y-m-d\TH:i');

        $this->observacoes =
            $this->atendimento->observacoes;

        $this->motivo_perda =
            $this->atendimento->motivo_perda;
    }


    protected function rules()
    {
        return [

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
    }


    public function atualizar()
    {
        $dados = $this->validate();

        if ($this->status !== 'perdido') {

            $dados['motivo_perda'] = null;

        }

        $this->atendimento->update($dados);

        session()->flash(
            'success',
            'Atendimento atualizado com sucesso!'
        );

        return redirect()
            ->route('atendimentos.index');
    }


    public function render()
    {
        $clientes =
            Cliente::orderBy('nome')->get();

        return view(
            'livewire.atendimento.atendimento-edit',
            compact('clientes')
        );
    }
}