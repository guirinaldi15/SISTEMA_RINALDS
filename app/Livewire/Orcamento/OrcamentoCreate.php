<?php

namespace App\Livewire\Orcamento;

use App\Models\Atendimento;
use App\Models\Espaco;
use App\Models\Orcamento;
use Livewire\Component;

class OrcamentoCreate extends Component
{
    public $atendimento_id;

    public $espaco_id;

    public $numero;

    public $validade;

    public $quantidade_convidados;

    public $valor_locacao = 0;

    public $valor_adicionais = 0;

    public $desconto = 0;

    public $valor_total = 0;

    public $status = 'rascunho';

    public $observacoes;


    public function mount()
    {
        $ultimoId =
            Orcamento::max('id') ?? 0;

        $this->numero =
            'ORC-' .
            str_pad(
                $ultimoId + 1,
                5,
                '0',
                STR_PAD_LEFT
            );

        $this->validade =
            now()
                ->addDays(7)
                ->format('Y-m-d');


        if (
            request()->has('atendimento')
        ) {

            $atendimento =
                Atendimento::findOrFail(
                    request()->get(
                        'atendimento'
                    )
                );

            $this->atendimento_id =
                $atendimento->id;
        }
    }


    protected function rules()
    {
        return [

            'atendimento_id' =>
                'required|exists:atendimentos,id',

            'espaco_id' =>
                'required|exists:espacos,id',

            'numero' =>
                'required|max:20|unique:orcamentos,numero',

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
        if (!$this->espaco_id) {

            $this->valor_locacao = 0;

            $this->calcularTotal();

            return;
        }

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
        $locacao =
            (float) ($this->valor_locacao ?: 0);

        $adicionais =
            (float) ($this->valor_adicionais ?: 0);

        $desconto =
            (float) ($this->desconto ?: 0);


        $total =
            $locacao
            + $adicionais
            - $desconto;


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


    public function salvar()
    {
        $this->calcularTotal();

        $dados =
            $this->validate();

        $dados['valor_total'] =
            $this->valor_total;


        $orcamento =
            Orcamento::create(
                $dados
            );


        if (
            $orcamento->status === 'enviado'
        ) {

            $orcamento
                ->atendimento
                ->update([

                    'status' =>
                        'orcamento_enviado',

                    'ultimo_contato' =>
                        now(),

                ]);
        }


        if (
            $orcamento->status === 'aceito'
        ) {

            $orcamento
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
            'Orçamento criado com sucesso!'
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
                ->whereNotIn(
                    'status',
                    [
                        'fechado',
                        'perdido'
                    ]
                )
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
            'livewire.orcamento.orcamento-create',
            compact(
                'atendimentos',
                'espacos'
            )
        );
    }
}