<?php

namespace App\Livewire\Usuario;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UsuarioDelete extends Component
{
    public User $usuario;

    public function mount(int $id): void
    {
        $this->usuario =
            User::findOrFail($id);
    }

    public function excluir()
    {
        if (
            Auth::id()
            === $this->usuario->id
        ) {

            session()->flash(
                'error',
                'Você não pode excluir seu próprio usuário.'
            );

            return redirect()
                ->route('usuarios.index');
        }

        $this->usuario->delete();

        session()->flash(
            'success',
            'Usuário excluído com sucesso.'
        );

        return redirect()
            ->route('usuarios.index');
    }

    public function render()
    {
        return view(
            'livewire.usuario.usuario-delete'
        );
    }
}
