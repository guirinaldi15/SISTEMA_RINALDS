<?php

namespace App\Livewire\Reserva;

use App\Models\Atendimento;
use App\Models\Cliente;
use App\Models\Espaco;
use App\Models\Reserva;
use Livewire\Component;

class ReservaCreate extends Component
{
    public $cliente_id;

    public $atendimento_id;

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
        | Reserva criada através de um atendimento
        |--------------------------------------------------------------------------
        |
        | Exemplo:
        |
        | /reservas/nova?atendimento=3
        |
        */

        if (
            request()->has('atendimento')
        ) {

            $atendimento =
                Atendimento::with('cliente')
                    ->findOrFail(
                        request()->get(
                            'atendimento'
                        )
                    );


            $this->atendimento_id =
                $atendimento->id;


            $this->cliente_id =
                $atendimento->cliente_id;


            if (
                $atendimento->data_evento
            ) {

                $this->data_evento =
                    $atendimento
                        ->data_evento
                        ->format('Y-m-d');
            }


            $this->tipo_evento =
                $atendimento->tipo_evento;


            if (
                $atendimento->observacoes
            ) {

                $this->observacoes =
                    'Reserva criada a partir do atendimento. '
                    . $atendimento->observacoes;
            }
        }
    }


    protected function rules()
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


    /*
    |--------------------------------------------------------------------------
    | ESPAÇO SELECIONADO
    |--------------------------------------------------------------------------
    |
    | Ao selecionar o espaço, podemos preencher automaticamente o valor base.
    |
    */

    public function updatedEspacoId()
    {
        if (
            !$this->espaco_id
        ) {

            return;
        }


        $espaco =
            Espaco::find(
                $this->espaco_id
            );


        if (
            !$espaco
        ) {

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Preencher valor apenas se ainda estiver vazio
        |--------------------------------------------------------------------------
        */

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
        | Evitar duas reservas para o mesmo atendimento
        |--------------------------------------------------------------------------
        */

        if (
            $this->atendimento_id
        ) {

            $jaPossuiReserva =
                Reserva::where(
                    'atendimento_id',
                    $this->atendimento_id
                )
                    ->exists();


            if (
                $jaPossuiReserva
            ) {

                $this->addError(
                    'data_evento',
                    'Este atendimento já possui uma reserva.'
                );

                return;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Validar capacidade do espaço
        |--------------------------------------------------------------------------
        */

        $espaco =
            Espaco::find(
                $this->espaco_id
            );


        if (
            $espaco
            &&
            $espaco->capacidade_maxima
            &&
            $this->quantidade_convidados
            &&
            $this->quantidade_convidados
                > $espaco->capacidade_maxima
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
        | Bloqueio do mesmo espaço na mesma data
        |--------------------------------------------------------------------------
        |
        | Pré-reserva e reserva confirmada ocupam a data.
        |
        | Uma reserva cancelada ou realizada não bloqueia uma nova reserva.
        |
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

            $nomeEspaco =
                $espaco
                    ? $espaco->nome
                    : 'selecionado';


            $this->addError(
                'data_evento',
                'O espaço '
                . $nomeEspaco
                . ' já possui uma reserva ou pré-reserva nesta data.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Criação da reserva
        |--------------------------------------------------------------------------
        */

        Reserva::create(
            $dados
        );


        /*
        |--------------------------------------------------------------------------
        | Fecha automaticamente o atendimento
        |--------------------------------------------------------------------------
        */

        if (
            $this->atendimento_id
        ) {

            $atendimento =
                Atendimento::find(
                    $this->atendimento_id
                );


            if (
                $atendimento
            ) {

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
                'reservas.index'
            );
    }


    public function render()
    {
        /*
        |--------------------------------------------------------------------------
        | CLIENTES
        |--------------------------------------------------------------------------
        */

        $clientes =
            Cliente::query()
                ->orderBy('nome')
                ->get();


        /*
        |--------------------------------------------------------------------------
        | ESPAÇOS ATIVOS
        |--------------------------------------------------------------------------
        */

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