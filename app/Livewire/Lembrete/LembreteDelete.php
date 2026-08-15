<?php

namespace App\Livewire\Lembrete;

use Livewire\Component;
use App\Models\Lembrete;

class LembreteDelete extends Component
{
    public Lembrete $lembrete;


    public function mount($id)
    {
        $this->lembrete =
            Lembrete::with([
                'atendimento.cliente'
            ])
            ->findOrFail($id);
    }


    public function excluir()
    {
        $this->lembrete->delete();

        session()->flash(
            'success',
            'Lembrete excluído com sucesso!'
        );

        return redirect()
            ->route('lembretes.index');
    }


    public function render()
    {
        return view(
            'livewire.lembrete.lembrete-delete'
        );
    }
}