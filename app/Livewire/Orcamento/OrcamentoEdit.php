<?php

namespace App\Livewire\Orcamento;

use App\Models\Atendimento;
use App\Models\Espaco;
use App\Models\Orcamento;
use Illuminate\Validation\Rule;
use Livewire\Component;

class OrcamentoEdit extends Component
{
    public Orcamento $orcamento;

    public $atendimento_id;

    public $espaco_id;

    public $numero;

    public $validade;

    public $quantidade_convidados;

    public $valor_locacao;

    public $valor_adicionais;

    public $desconto;

    public $valor_total;

    public $status;

    public $observacoes;


    public function mount(int $id): void
    {
        $this->orcamento =
            Orcamento::findOrFail($id);


        $this->atendimento_id =
            $this->orcamento
                ->atendimento_id;


        $this->espaco_id =
            $this->orcamento
                ->espaco_id;


        $this->numero =
            $this->orcamento
                ->numero;


        $this->validade =
            $this->orcamento
                ->validade
                ?->format('Y-m-d');


        $this->quantidade_convidados =
            $this->orcamento
                ->quantidade_convidados;


        $this->valor_locacao =
            $this->orcamento
                ->valor_locacao;


        $this->valor_adicionais =
            $this->orcamento
                ->valor_adicionais;


        $this->desconto =
            $this->orcamento
                ->desconto;


        $this->valor_total =
            $this->orcamento
                ->valor_total;


        $this->status =
            $this->orcamento
                ->status;


        $this->observacoes =
            $this->orcamento
                ->observacoes;
    }


    protected function rules()
    {
        return [

            'atendimento_id' =>
                'required|exists:atendimentos,id',

            'espaco_id' =>
                'required|exists:espacos,id',

            'numero' => [

                'required',
                'max:20',

                Rule::unique(
                    'orcamentos',
                    'numero'
                )
                    ->ignore(
                        $this->orcamento->id
                    ),
            ],

            'validade' =>
                'nullable|date',

            'quantidade_convidados' =>
                'nullable|integer|min:1',

            'valor_locacao' =>
                'required|numeric|min:0',

            'valor_adicionais' =>
                'nullable|numeric|min:0',

            'desconto' =>
                'nullable|numeric|min:0',

            'status' =>
                'required|in:rascunho,enviado,aceito,recusado,expirado',

            'observacoes' =>
                'nullable|max:3000',

        ];
    }


    public function updatedEspacoId()
    {
        $espaco =
            Espaco::find(
                $this->espaco_id
            );

        if (!$espaco) {
            return;
        }

        $this->valor_locacao =
            $espaco->valor_base ?? 0;

        $this->calcularTotal();
    }


    public function updatedValorLocacao()
    {
        $this->calcularTotal();
    }


    public function updatedValorAdicionais()
    {
        $this->calcularTotal();
    }


    public function updatedDesconto()
    {
        $this->calcularTotal();
    }


    public function calcularTotal()
    {
        $total =
            (float) ($this->valor_locacao ?: 0)
            + (float) ($this->valor_adicionais ?: 0)
            - (float) ($this->desconto ?: 0);


        if ($total < 0) {

            $total = 0;
        }


        $this->valor_total =
            number_format(
                $total,
                2,
                '.',
                ''
            );
    }


    public function atualizar()
    {
        $this->calcularTotal();

        $dados =
            $this->validate();


        $dados['valor_total'] =
            $this->valor_total;


        $this->orcamento
            ->update(
                $dados
            );


        if (
            $this->status === 'enviado'
        ) {

            $this->orcamento
                ->atendimento
                ->update([

                    'status' =>
                        'orcamento_enviado',

                    'ultimo_contato' =>
                        now(),

                ]);
        }


        if (
            $this->status === 'aceito'
        ) {

            $this->orcamento
                ->atendimento
                ->update([

                    'status' =>
                        'negociacao',

                    'ultimo_contato' =>
                        now(),

                ]);
        }


        session()->flash(
            'success',
            'Orçamento atualizado com sucesso!'
        );


        return redirect()
            ->route(
                'orcamentos.index'
            );
    }


    public function render()
    {
        $atendimentos =
            Atendimento::with('cliente')
                ->orderByDesc(
                    'updated_at'
                )
                ->get();


        $espacos =
            Espaco::query()
                ->where(
                    'ativo',
                    true
                )
                ->orderBy('nome')
                ->get();


        return view(
            'livewire.orcamento.orcamento-edit',
            compact(
                'atendimentos',
                'espacos'
            )
        );
    }
}