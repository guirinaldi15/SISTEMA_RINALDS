<?php

namespace App\Livewire\Espaco;

use App\Models\Espaco;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title("Espaços | Rinald's Gestão")]
class EspacoIndex extends Component
{
    public string $search = '';

    public string $status = '';

    public function render()
    {
        $espacos = Espaco::query()

            ->when(
                $this->search,
                function ($query) {

                    $query->where(
                        function ($q) {

                            $q
                                ->where(
                                    'nome',
                                    'like',
                                    '%' . $this->search . '%'
                                )

                                ->orWhere(
                                    'descricao',
                                    'like',
                                    '%' . $this->search . '%'
                                );
                        }
                    );
                }
            )

            ->when(
                $this->status !== '',
                function ($query) {

                    $query->where(
                        'ativo',
                        $this->status
                    );
                }
            )

            ->orderBy('nome')

            ->get();

        return view(
            'livewire.espaco.espaco-index',
            compact('espacos')
        );
    }
}