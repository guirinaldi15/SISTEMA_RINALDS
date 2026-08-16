<?php

namespace App\Livewire\Reserva;

use App\Models\Cliente;
use App\Models\Espaco;
use App\Models\Reserva;
use Livewire\Component;

class ReservaEdit extends Component
{
    public Reserva $reserva;

    public $cliente_id;

    public $espaco_id;

    public $data_evento;

    public $tipo_evento;

    public $quantidade_convidados;

    public $horario_inicio;

    public $horario_fim;

    public $valor_total;

    public $status;

    public $observacoes;


    public function mount(int $id): void
    {
        $this->reserva =
            Reserva::findOrFail($id);

        $this->cliente_id =
            $this->reserva->cliente_id;

        $this->espaco_id =
            $this->reserva->espaco_id;

        $this->data_evento =
            $this->reserva
                ->data_evento
                ->format('Y-m-d');

        $this->tipo_evento =
            $this->reserva->tipo_evento;

        $this->quantidade_convidados =
            $this->reserva
                ->quantidade_convidados;

        $this->horario_inicio =
            $this->reserva
                ->horario_inicio;

        $this->horario_fim =
            $this->reserva
                ->horario_fim;

        $this->valor_total =
            $this->reserva
                ->valor_total;

        $this->status =
            $this->reserva->status;

        $this->observacoes =
            $this->reserva->observacoes;
    }


    protected function rules(): array
    {
        return [

            'cliente_id' =>
                'required|exists:clientes,id',

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
            'O espaço selecionado não é válido.',

        'data_evento.required' =>
            'Informe a data do evento.',

        'tipo_evento.required' =>
            'Informe o tipo do evento.',
    ];


    public function atualizar()
    {
        $dados =
            $this->validate();


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
        | BLOQUEAR MESMO ESPAÇO NA MESMA DATA
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

                ->where(
                    'id',
                    '!=',
                    $this->reserva->id
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
        | ATUALIZAR
        |--------------------------------------------------------------------------
        */

        $this->reserva
            ->update($dados);


        session()->flash(
            'success',
            'Reserva atualizada com sucesso!'
        );


        return redirect()
            ->route(
                'reservas.index'
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


        /*
        |--------------------------------------------------------------------------
        | GARANTIR ESPAÇO INATIVO NA EDIÇÃO
        |--------------------------------------------------------------------------
        */

        if (
            $this->espaco_id
            &&
            !$espacos->contains(
                'id',
                $this->espaco_id
            )
        ) {

            $espacoAtual =
                Espaco::find(
                    $this->espaco_id
                );


            if ($espacoAtual) {

                $espacos->push(
                    $espacoAtual
                );
            }
        }


        return view(
            'livewire.reserva.reserva-edit',
            compact(
                'clientes',
                'espacos'
            )
        );
    }
}