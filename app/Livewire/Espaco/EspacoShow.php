<?php

namespace App\Livewire\Espaco;

use App\Models\Espaco;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title("Detalhes do Espaço | Rinald's Gestão")]
class EspacoShow extends Component
{
    public Espaco $espaco;


    public function mount(int $id): void
    {
        $this->espaco =
            Espaco::findOrFail($id);
    }


    public function render()
    {
        return view(
            'livewire.espaco.espaco-show'
        );
    }
}