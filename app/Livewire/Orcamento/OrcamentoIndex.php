<?php

namespace App\Livewire\Orcamento;

use Livewire\Component;
use App\Models\Orcamento;

class OrcamentoIndex extends Component
{
    public $search = '';
    public $status = '';

    public function render()
    {
        $orcamentos =
            Orcamento::query()

            ->with([
                'atendimento.cliente'
            ])

            ->when(
                $this->search,
                function ($query) {

                    $query->where(
                        'numero',
                        'like',
                        '%' . $this->search . '%'
                    )

                    ->orWhereHas(
                        'atendimento.cliente',
                        function ($q) {

                            $q->where(
                                'nome',
                                'like',
                                '%' . $this->search . '%'
                            );

                        }
                    );

                }
            )

            ->when(
                $this->status,
                function ($query) {

                    $query->where(
                        'status',
                        $this->status
                    );

                }
            )

            ->orderByDesc('created_at')
            ->get();

        return view(
            'livewire.orcamento.orcamento-index',
            compact('orcamentos')
        );
    }
}