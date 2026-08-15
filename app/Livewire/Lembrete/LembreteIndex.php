<?php

namespace App\Livewire\Lembrete;

use Livewire\Component;
use App\Models\Lembrete;

class LembreteIndex extends Component
{
    public $search = '';
    public $status = '';
    public $periodo = '';

    public function concluir($id)
    {
        $lembrete = Lembrete::findOrFail($id);

        $lembrete->update([
            'status' => 'concluido',
            'concluido_em' => now(),
        ]);

        session()->flash(
            'success',
            'Lembrete concluído com sucesso!'
        );
    }

    public function reabrir($id)
    {
        $lembrete = Lembrete::findOrFail($id);

        $lembrete->update([
            'status' => 'pendente',
            'concluido_em' => null,
        ]);

        session()->flash(
            'success',
            'Lembrete reaberto!'
        );
    }

    public function render()
    {
        $lembretes = Lembrete::query()
            ->with([
                'atendimento.cliente'
            ])

            ->when($this->search, function ($query) {

                $query->whereHas(
                    'atendimento.cliente',
                    function ($q) {

                        $q->where(
                            'nome',
                            'like',
                            '%' . $this->search . '%'
                        )
                        ->orWhere(
                            'telefone',
                            'like',
                            '%' . $this->search . '%'
                        );

                    }
                );

            })

            ->when($this->status, function ($query) {

                $query->where(
                    'status',
                    $this->status
                );

            })

            ->when($this->periodo === 'hoje', function ($query) {

                $query->whereDate(
                    'lembrar_em',
                    today()
                );

            })

            ->when($this->periodo === 'atrasados', function ($query) {

                $query
                    ->where(
                        'lembrar_em',
                        '<',
                        now()
                    )
                    ->where(
                        'status',
                        'pendente'
                    );

            })

            ->when($this->periodo === 'futuros', function ($query) {

                $query->where(
                    'lembrar_em',
                    '>',
                    now()
                );

            })

            ->orderBy('lembrar_em')
            ->get();

        return view(
            'livewire.lembrete.lembrete-index',
            compact('lembretes')
        );
    }
}