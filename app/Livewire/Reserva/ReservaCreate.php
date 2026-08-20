<?php

namespace App\Livewire\Reserva;

use App\Models\Atendimento;
use App\Models\Cliente;
use App\Models\Espaco;
use App\Models\Orcamento;
use App\Models\Reserva;
use Livewire\Component;

class ReservaCreate extends Component
{
    public $cliente_id;

    public $atendimento_id;

    public $orcamento_id;

    public $espaco_id;

    public $data_evento;

    public $tipo_evento;

    public $quantidade_convidados;

    public $horario_inicio;

    public $horario_fim;

    public $valor_total;

    public $status = 'confirmada';

    public $observacoes;


    public function mount()
    {
        /*
        |--------------------------------------------------------------------------
        | RESERVA CRIADA A PARTIR DE ORÇAMENTO
        |--------------------------------------------------------------------------
        */

        if (request()->filled('orcamento')) {

            $orcamento = Orcamento::with([
                'atendimento.cliente',
                'espaco',
            ])
                ->findOrFail(
                    request()->get('orcamento')
                );


            /*
            |--------------------------------------------------------------------------
            | APENAS ORÇAMENTO ACEITO PODE GERAR RESERVA
            |--------------------------------------------------------------------------
            */

            if ($orcamento->status !== 'aceito') {

                session()->flash(
                    'error',
                    'Somente orçamentos aceitos podem gerar uma reserva.'
                );

                return redirect()
                    ->route(
                        'orcamentos.show',
                        $orcamento->id
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | VERIFICAR SE JÁ EXISTE RESERVA
            |--------------------------------------------------------------------------
            */

            $reservaExistente = Reserva::query()
                ->where(
                    'atendimento_id',
                    $orcamento->atendimento_id
                )
                ->first();


            if ($reservaExistente) {

                session()->flash(
                    'error',
                    'Este orçamento já possui uma reserva.'
                );

                return redirect()
                    ->route(
                        'reservas.show',
                        $reservaExistente->id
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | PREENCHIMENTO AUTOMÁTICO
            |--------------------------------------------------------------------------
            */

            $this->orcamento_id =
                $orcamento->id;


            $this->atendimento_id =
                $orcamento->atendimento_id;


            $this->cliente_id =
                $orcamento
                    ->atendimento
                    ->cliente_id;


            $this->espaco_id =
                $orcamento->espaco_id;


            if (
                $orcamento
                    ->atendimento
                    ->data_evento
            ) {

                $this->data_evento =
                    $orcamento
                        ->atendimento
                        ->data_evento
                        ->format('Y-m-d');
            }


            $this->tipo_evento =
                $orcamento
                    ->atendimento
                    ->tipo_evento;


            $this->quantidade_convidados =
                $orcamento
                    ->quantidade_convidados;


            $this->valor_total =
                $orcamento
                    ->valor_total;


            $this->observacoes =
                'Reserva criada a partir do orçamento '
                . $orcamento->numero
                . '.';


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | RESERVA CRIADA A PARTIR DE ATENDIMENTO
        |--------------------------------------------------------------------------
        */

        if (request()->filled('atendimento')) {

            $atendimento = Atendimento::with('cliente')
                ->findOrFail(
                    request()->get('atendimento')
                );


            $this->atendimento_id =
                $atendimento->id;


            $this->cliente_id =
                $atendimento->cliente_id;


            if ($atendimento->data_evento) {

                $this->data_evento =
                    $atendimento
                        ->data_evento
                        ->format('Y-m-d');
            }


            $this->tipo_evento =
                $atendimento
                    ->tipo_evento;


            if ($atendimento->observacoes) {

                $this->observacoes =
                    'Reserva criada a partir do atendimento. '
                    . $atendimento->observacoes;
            }
        }
    }


    protected function rules(): array
    {
        return [

            'cliente_id' =>
                'required|exists:clientes,id',

            'atendimento_id' =>
                'nullable|exists:atendimentos,id',

            'espaco_id' =>
                'required|exists:espacos,id',

            'data_evento' =>
                'required|date',

            'tipo_evento' =>
                'required|max:100',

            'quantidade_convidados' =>
                'nullable|integer|min:1',

            'horario_inicio' =>
                'nullable',

            'horario_fim' =>
                'nullable',

            'valor_total' =>
                'nullable|numeric|min:0',

            'status' =>
                'required|in:pre_reserva,confirmada,cancelada,realizada',

            'observacoes' =>
                'nullable|max:2000',
        ];
    }


    protected $messages = [

        'cliente_id.required' =>
            'Selecione um cliente.',

        'espaco_id.required' =>
            'Selecione o espaço do evento.',

        'espaco_id.exists' =>
            'O espaço selecionado é inválido.',

        'data_evento.required' =>
            'Informe a data do evento.',

        'tipo_evento.required' =>
            'Informe o tipo do evento.',
    ];


    public function updatedEspacoId(): void
    {
        /*
        |--------------------------------------------------------------------------
        | SE VEIO DO ORÇAMENTO, MANTÉM O VALOR NEGOCIADO
        |--------------------------------------------------------------------------
        */

        if ($this->orcamento_id) {
            return;
        }


        if (!$this->espaco_id) {
            return;
        }


        $espaco = Espaco::find(
            $this->espaco_id
        );


        if (!$espaco) {
            return;
        }


        if (
            empty($this->valor_total)
            &&
            $espaco->valor_base
        ) {

            $this->valor_total =
                $espaco->valor_base;
        }
    }


    public function salvar()
    {
        $dados =
            $this->validate();


        /*
        |--------------------------------------------------------------------------
        | IMPEDIR DUAS RESERVAS PARA O MESMO ATENDIMENTO
        |--------------------------------------------------------------------------
        */

        if ($this->atendimento_id) {

            $jaPossuiReserva =
                Reserva::query()
                    ->where(
                        'atendimento_id',
                        $this->atendimento_id
                    )
                    ->exists();


            if ($jaPossuiReserva) {

                $this->addError(
                    'data_evento',
                    'Este atendimento já possui uma reserva.'
                );

                return;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | BUSCAR ESPAÇO
        |--------------------------------------------------------------------------
        */

        $espaco =
            Espaco::find(
                $this->espaco_id
            );


        /*
        |--------------------------------------------------------------------------
        | VALIDAR CAPACIDADE
        |--------------------------------------------------------------------------
        */

        if (
            $espaco
            &&
            $espaco->capacidade_maxima
            &&
            $this->quantidade_convidados
            &&
            $this->quantidade_convidados
                >
                $espaco->capacidade_maxima
        ) {

            $this->addError(
                'quantidade_convidados',
                'A quantidade de convidados ultrapassa a capacidade máxima de '
                . $espaco->capacidade_maxima
                . ' pessoas do espaço '
                . $espaco->nome
                . '.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | VERIFICAR DISPONIBILIDADE
        |--------------------------------------------------------------------------
        */

        $espacoOcupado =
            Reserva::query()

                ->where(
                    'espaco_id',
                    $this->espaco_id
                )

                ->whereDate(
                    'data_evento',
                    $this->data_evento
                )

                ->whereIn(
                    'status',
                    [
                        'pre_reserva',
                        'confirmada',
                    ]
                )

                ->exists();


        if (
            $espacoOcupado
            &&
            in_array(
                $this->status,
                [
                    'pre_reserva',
                    'confirmada',
                ]
            )
        ) {

            $this->addError(
                'data_evento',
                'O espaço '
                . (
                    $espaco
                        ? $espaco->nome
                        : 'selecionado'
                )
                . ' já possui uma reserva ou pré-reserva nesta data.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | CRIAR RESERVA
        |--------------------------------------------------------------------------
        */

        $reserva =
            Reserva::create(
                $dados
            );


        /*
        |--------------------------------------------------------------------------
        | FECHAR ATENDIMENTO
        |--------------------------------------------------------------------------
        */

        if ($this->atendimento_id) {

            $atendimento =
                Atendimento::find(
                    $this->atendimento_id
                );


            if ($atendimento) {

                $atendimento->update([
                    'status' =>
                        'fechado',

                    'ultimo_contato' =>
                        now(),
                ]);
            }
        }


        session()->flash(
            'success',
            'Reserva cadastrada com sucesso!'
        );


        return redirect()
            ->route(
                'reservas.show',
                $reserva->id
            );
    }


    public function render()
    {
        $clientes =
            Cliente::query()
                ->orderBy('nome')
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
            'livewire.reserva.reserva-create',
            compact(
                'clientes',
                'espacos'
            )
        );
    }
}