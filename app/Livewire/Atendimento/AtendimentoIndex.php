<?php

namespace App\Livewire\Atendimento;

use Livewire\Component;
use App\Models\Atendimento;

class AtendimentoIndex extends Component
{
    public $search = '';
    public $status = '';

    public function render()
    {
        $atendimentos = Atendimento::with('cliente')

            ->when($this->search, function ($query) {

                $query->whereHas('cliente', function ($q) {

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

                });

            })

            ->when($this->status, function ($query) {

                $query->where(
                    'status',
                    $this->status
                );

            })

            ->latest()
            ->get();

        return view(
            'livewire.atendimento.atendimento-index',
            compact('atendimentos')
        );
    }
}