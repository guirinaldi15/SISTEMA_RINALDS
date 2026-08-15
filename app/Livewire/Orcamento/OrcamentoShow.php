<?php

namespace App\Livewire\Orcamento;

use Livewire\Component;
use App\Models\Orcamento;

class OrcamentoShow extends Component
{
    public Orcamento $orcamento;

    public function mount($id)
    {
        $this->orcamento = Orcamento::with([
            'atendimento.cliente'
        ])->findOrFail($id);
    }

    public function render()
    {
        return view(
            'livewire.orcamento.orcamento-show'
        );
    }
}