<?php

namespace App\Livewire\Usuario;

use App\Models\User;
use Livewire\Component;

class UsuarioIndex extends Component
{
    public $search = '';

    public $perfil = '';

    public function render()
    {
        $usuarios = User::query()

            ->when(
                $this->search,
                function ($query) {

                    $query->where(
                        function ($q) {

                            $q
                                ->where(
                                    'name',
                                    'like',
                                    '%' . $this->search . '%'
                                )

                                ->orWhere(
                                    'email',
                                    'like',
                                    '%' . $this->search . '%'
                                );

                        }
                    );

                }
            )

            ->when(
                $this->perfil,
                function ($query) {

                    $query->where(
                        'perfil',
                        $this->perfil
                    );

                }
            )

            ->orderBy('name')

            ->get();

        return view(
            'livewire.usuario.usuario-index',
            compact('usuarios')
        );
    }
}