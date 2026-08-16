<?php

namespace App\Livewire\Espaco;

use App\Models\Espaco;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title("Excluir Espaço | Rinald's Gestão")]
class EspacoDelete extends Component
{
    public Espaco $espaco;


    public function mount(int $id): void
    {
        $this->espaco =
            Espaco::findOrFail($id);
    }


    public function excluir()
    {
        $this->espaco->delete();

        session()->flash(
            'success',
            'Espaço excluído com sucesso.'
        );

        return redirect()
            ->route('espacos.index');
    }


    public function render()
    {
        return view(
            'livewire.espaco.espaco-delete'
        );
    }
}