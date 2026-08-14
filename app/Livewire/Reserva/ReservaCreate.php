<?php

namespace App\Livewire\Reserva;

use Livewire\Component;
use App\Models\Reserva;
use App\Models\Cliente;

class ReservaCreate extends Component
{
    public $cliente_id;

    public $data_evento;

    public $tipo_evento;

    public $quantidade_convidados;

    public $horario_inicio;

    public $horario_fim;

    public $valor_total;

    public $status = 'pre_reserva';

    public $observacoes;

    protected $rules = [
        'cliente_id' =>
            'required|exists:clientes,id',

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

    protected $messages = [
        'cliente_id.required' =>
            'Selecione um cliente.',

        'data_evento.required' =>
            'Informe a data do evento.',

        'tipo_evento.required' =>
            'Informe o tipo do evento.',

        'quantidade_convidados.integer' =>
            'Informe uma quantidade válida.',
    ];

    public function salvar()
    {
        $dados = $this->validate();

        /*
        |--------------------------------------------------------------------------
        | Bloqueio de data
        |--------------------------------------------------------------------------
        |
        | Uma data fica ocupada quando existe:
        | - pré-reserva
        | - reserva confirmada
        |
        */

        $dataOcupada = Reserva::where(
            'data_evento',
            $this->data_evento
        )
            ->whereIn('status', [
                'pre_reserva',
                'confirmada'
            ])
            ->exists();

        if (
            $dataOcupada &&
            in_array(
                $this->status,
                ['pre_reserva', 'confirmada']
            )
        ) {

            $this->addError(
                'data_evento',
                'Já existe uma reserva ou pré-reserva para esta data.'
            );

            return;
        }

        Reserva::create($dados);

        session()->flash(
            'success',
            'Reserva cadastrada com sucesso!'
        );

        return redirect()
            ->route('reservas.index');
    }

    public function render()
    {
        $clientes = Cliente::orderBy('nome')
            ->get();

        return view(
            'livewire.reserva.reserva-create',
            compact('clientes')
        );
    }
}