<?php

namespace App\Livewire\Orcamento;

use Livewire\Component;
use App\Models\Orcamento;

class OrcamentoDelete extends Component
{
    public Orcamento $orcamento;


    public function mount($id)
    {
        $this->orcamento =
            Orcamento::with([
                'atendimento.cliente'
            ])
            ->findOrFail($id);
    }


    public function excluir()
    {
        $this->orcamento->delete();

        session()->flash(
            'success',
            'Orçamento excluído com sucesso!'
        );

        return redirect()
            ->route('orcamentos.index');
    }


    public function render()
    {
        return view(
            'livewire.orcamento.orcamento-delete'
        );
    }
}