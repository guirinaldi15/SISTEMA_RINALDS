<?php

namespace App\Livewire\Reserva;

use Livewire\Component;
use App\Models\Reserva;
use App\Models\Cliente;

class ReservaEdit extends Component
{
    public Reserva $reserva;

    public $cliente_id;
    public $data_evento;
    public $tipo_evento;
    public $quantidade_convidados;
    public $horario_inicio;
    public $horario_fim;
    public $valor_total;
    public $status;
    public $observacoes;

    public function mount($id)
    {
        $this->reserva =
            Reserva::findOrFail($id);

        $this->cliente_id =
            $this->reserva->cliente_id;

        $this->data_evento =
            $this->reserva->data_evento
                ->format('Y-m-d');

        $this->tipo_evento =
            $this->reserva->tipo_evento;

        $this->quantidade_convidados =
            $this->reserva->quantidade_convidados;

        $this->horario_inicio =
            $this->reserva->horario_inicio;

        $this->horario_fim =
            $this->reserva->horario_fim;

        $this->valor_total =
            $this->reserva->valor_total;

        $this->status =
            $this->reserva->status;

        $this->observacoes =
            $this->reserva->observacoes;
    }

    protected function rules()
    {
        return [
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
    }

    public function atualizar()
    {
        $dados = $this->validate();

        $dataOcupada = Reserva::where(
            'data_evento',
            $this->data_evento
        )
            ->where('id', '!=', $this->reserva->id)
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
                'Já existe outra reserva para esta data.'
            );

            return;
        }

        $this->reserva->update($dados);

        session()->flash(
            'success',
            'Reserva atualizada com sucesso!'
        );

        return redirect()
            ->route('reservas.index');
    }

    public function render()
    {
        $clientes =
            Cliente::orderBy('nome')->get();

        return view(
            'livewire.reserva.reserva-edit',
            compact('clientes')
        );
    }
}