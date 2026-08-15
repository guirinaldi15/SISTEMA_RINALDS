<?php

namespace App\Livewire\Pagamento;

use Livewire\Component;
use App\Models\Pagamento;

class PagamentoDelete extends Component
{
    public Pagamento $pagamento;


    public function mount($id)
    {
        $this->pagamento =
            Pagamento::with([
                'reserva.cliente'
            ])
            ->findOrFail($id);
    }


    public function excluir()
    {
        $this->pagamento->delete();


        session()->flash(
            'success',
            'Pagamento excluído com sucesso!'
        );


        return redirect()
            ->route('pagamentos.index');
    }


    public function render()
    {
        return view(
            'livewire.pagamento.pagamento-delete'
        );
    }
}