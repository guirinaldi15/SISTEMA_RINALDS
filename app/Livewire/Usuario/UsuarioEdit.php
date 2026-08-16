<?php

namespace App\Livewire\Usuario;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UsuarioEdit extends Component
{
    public User $usuario;

    public $name = '';

    public $email = '';

    public $perfil = '';

    public $ativo = true;

    public $password = '';

    public $password_confirmation = '';


    public function mount($id)
    {
        $this->usuario =
            User::findOrFail($id);

        $this->name =
            $this->usuario->name;

        $this->email =
            $this->usuario->email;

        $this->perfil =
            $this->usuario->perfil;

        $this->ativo =
            $this->usuario->ativo;
    }


    public function atualizar()
    {
        $dados = $this->validate([

            'name' =>
                'required|min:3|max:150',

            'email' => [
                'required',
                'email',
                'max:150',

                Rule::unique(
                    'users',
                    'email'
                )
                ->ignore(
                    $this->usuario->id
                ),
            ],

            'perfil' =>
                'required|in:administrador,atendente',

            'ativo' =>
                'boolean',

            'password' =>
                'nullable|min:8|confirmed',

        ]);


        $this->usuario->update([
            'name' =>
                $dados['name'],

            'email' =>
                strtolower(
                    trim(
                        $dados['email']
                    )
                ),

            'perfil' =>
                $dados['perfil'],

            'ativo' =>
                $dados['ativo'],
        ]);


        if ($this->password) {

            $this->usuario->update([
                'password' =>
                    $this->password,
            ]);

        }


        session()->flash(
            'success',
            'Usuário atualizado com sucesso.'
        );


        return redirect()
            ->route('usuarios.index');
    }


    public function render()
    {
        return view(
            'livewire.usuario.usuario-edit'
        );
    }
}