<?php

namespace App\Livewire\Atendimento;

use Livewire\Component;
use App\Models\Atendimento;

class AtendimentoDelete extends Component
{
    public Atendimento $atendimento;

    public function mount($id)
    {
        $this->atendimento =
            Atendimento::with('cliente')
                ->findOrFail($id);
    }

    public function excluir()
    {
        $this->atendimento->delete();

        session()->flash(
            'success',
            'Atendimento excluído com sucesso!'
        );

        return redirect()
            ->route('atendimentos.index');
    }

    public function render()
    {
        return view(
            'livewire.atendimento.atendimento-delete'
        );
    }
}