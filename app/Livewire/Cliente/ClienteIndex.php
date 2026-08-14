<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use App\Models\Cliente;

class ClienteIndex extends Component
{
    public $search = '';

    public function render()
    {
        $clientes = Cliente::where('nome', 'like', '%' . $this->search . '%')
            ->orWhere('telefone', 'like', '%' . $this->search . '%')
            ->orderBy('nome')
            ->get();

        return view('livewire.cliente.cliente-index', compact('clientes'));
    }
}