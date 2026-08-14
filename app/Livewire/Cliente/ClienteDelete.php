<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use App\Models\Cliente;

class ClienteDelete extends Component
{
    public Cliente $cliente;

    public function mount($id)
    {
        $this->cliente = Cliente::findOrFail($id);
    }

    public function excluir()
    {
        $this->cliente->delete();

        session()->flash('success', 'Cliente excluído com sucesso!');

        return redirect()->route('clientes.index');
    }

    public function render()
    {
        return view('livewire.cliente.cliente-delete');
    }
}