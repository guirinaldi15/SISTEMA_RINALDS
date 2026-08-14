<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use App\Models\Cliente;

class ClienteCreate extends Component
{
    public $nome;
    public $telefone;
    public $email;
    public $cpf_cnpj;
    public $cidade;
    public $estado = 'SP';
    public $observacoes;

    protected $rules = [
        'nome' => 'required|min:3|max:150',
        'telefone' => 'required|max:20',
        'email' => 'nullable|email|max:150',
        'cpf_cnpj' => 'nullable|max:20',
        'cidade' => 'nullable|max:100',
        'estado' => 'nullable|max:2',
        'observacoes' => 'nullable|max:1000',
    ];

    protected $messages = [
        'nome.required' => 'Informe o nome do cliente.',
        'nome.min' => 'O nome precisa ter pelo menos 3 caracteres.',
        'telefone.required' => 'Informe o telefone.',
        'email.email' => 'Informe um e-mail válido.',
    ];

    public function salvar()
    {
        $dados = $this->validate();

        Cliente::create($dados);

        session()->flash('success', 'Cliente cadastrado com sucesso!');

        return redirect()->route('clientes.index');
    }

    public function render()
    {
        return view('livewire.cliente.cliente-create');
    }
}