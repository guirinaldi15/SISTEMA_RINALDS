<?php

namespace App\Livewire\Reserva;

use Livewire\Component;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Atendimento;

class ReservaCreate extends Component
{
    public $cliente_id;

    public $atendimento_id;

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

        if (request()->has('atendimento')) {

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


            if ($atendimento->data_evento) {

                $this->data_evento =
                    $atendimento
                        ->data_evento
                        ->format('Y-m-d');

            }


            $this->tipo_evento =
                $atendimento->tipo_evento;


            if ($atendimento->observacoes) {

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

        'data_evento.required' =>
            'Informe a data do evento.',

        'tipo_evento.required' =>
            'Informe o tipo do evento.',

    ];


    public function salvar()
    {
        $dados =
            $this->validate();


        /*
        |--------------------------------------------------------------------------
        | Evitar duas reservas para o mesmo atendimento
        |--------------------------------------------------------------------------
        */

        if ($this->atendimento_id) {

            $jaPossuiReserva =
                Reserva::where(
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
        | Bloqueio de data
        |--------------------------------------------------------------------------
        */

        $dataOcupada =
            Reserva::where(
                'data_evento',
                $this->data_evento
            )
            ->whereIn(
                'status',
                [
                    'pre_reserva',
                    'confirmada'
                ]
            )
            ->exists();


        if (
            $dataOcupada
            &&
            in_array(
                $this->status,
                [
                    'pre_reserva',
                    'confirmada'
                ]
            )
        ) {

            $this->addError(
                'data_evento',
                'Esta data já possui uma reserva ou pré-reserva.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Criação da reserva
        |--------------------------------------------------------------------------
        */

        $reserva =
            Reserva::create($dados);


        /*
        |--------------------------------------------------------------------------
        | Fecha automaticamente o atendimento
        |--------------------------------------------------------------------------
        */

        if ($this->atendimento_id) {

            $atendimento =
                Atendimento::find(
                    $this->atendimento_id
                );


            if ($atendimento) {

                $atendimento->update([
                    'status' => 'fechado',
                    'ultimo_contato' => now(),
                ]);

            }

        }


        session()->flash(
            'success',
            'Reserva cadastrada com sucesso!'
        );


        return redirect()
            ->route('reservas.index');
    }


    public function render()
    {
        $clientes =
            Cliente::orderBy('nome')
                ->get();


        return view(
            'livewire.reserva.reserva-create',
            compact('clientes')
        );
    }
}