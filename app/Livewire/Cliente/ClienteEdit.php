<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use App\Models\Cliente;

class ClienteEdit extends Component
{
    public Cliente $cliente;

    public $nome;
    public $telefone;
    public $email;
    public $cpf_cnpj;
    public $cep;
    public $cidade;
    public $estado;
    public $observacoes;

    public function mount($id)
    {
        $this->cliente =
            Cliente::findOrFail($id);

        $this->nome =
            $this->cliente->nome;

        $this->telefone =
            $this->cliente->telefone;

        $this->email =
            $this->cliente->email;

        $this->cpf_cnpj =
            $this->cliente->cpf_cnpj;

        $this->cep =
            $this->cliente->cep;

        $this->cidade =
            $this->cliente->cidade;

        $this->estado =
            $this->cliente->estado;

        $this->observacoes =
            $this->cliente->observacoes;
    }

    protected function rules()
    {
        return [
            'nome' => 'required|min:3|max:150',
            'telefone' => 'required|max:20',
            'email' => 'nullable|email|max:150',
            'cpf_cnpj' => 'nullable|max:20',
            'cep' => 'nullable|max:9',
            'cidade' => 'nullable|max:100',
            'estado' => 'nullable|max:2',
            'observacoes' => 'nullable|max:1000',
        ];
    }

    public function atualizar()
    {
        $dados =
            $this->validate();

        $this->cliente->update(
            $dados
        );

        session()->flash(
            'success',
            'Cliente atualizado com sucesso!'
        );

        return redirect()
            ->route('clientes.index');
    }

    public function render()
    {
        return view(
            'livewire.cliente.cliente-edit'
        );
    }
}