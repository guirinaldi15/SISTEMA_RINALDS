<?php

namespace App\Livewire\Usuario;

use App\Models\User;
use Livewire\Component;

class UsuarioCreate extends Component
{
    public $name = '';

    public $email = '';

    public $password = '';

    public $password_confirmation = '';

    public $perfil = 'atendente';

    public $ativo = true;


    protected function rules()
    {
        return [

            'name' =>
                'required|min:3|max:150',

            'email' =>
                'required|email|max:150|unique:users,email',

            'password' =>
                'required|min:8|confirmed',

            'perfil' =>
                'required|in:administrador,atendente',

            'ativo' =>
                'boolean',

        ];
    }


    protected function messages()
    {
        return [

            'name.required' =>
                'Informe o nome.',

            'email.required' =>
                'Informe o e-mail.',

            'email.email' =>
                'Informe um e-mail válido.',

            'email.unique' =>
                'Este e-mail já está cadastrado.',

            'password.required' =>
                'Informe uma senha.',

            'password.min' =>
                'A senha deve ter no mínimo 8 caracteres.',

            'password.confirmed' =>
                'A confirmação da senha não confere.',

        ];
    }


    public function salvar()
    {
        $dados = $this->validate();

        User::create([
            'name' =>
                $dados['name'],

            'email' =>
                strtolower(
                    trim(
                        $dados['email']
                    )
                ),

            'password' =>
                $dados['password'],

            'perfil' =>
                $dados['perfil'],

            'ativo' =>
                $dados['ativo'],
        ]);


        session()->flash(
            'success',
            'Usuário criado com sucesso.'
        );


        return redirect()
            ->route('usuarios.index');
    }


    public function render()
    {
        return view(
            'livewire.usuario.usuario-create'
        );
    }
}