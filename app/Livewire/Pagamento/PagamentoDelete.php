<?php

namespace App\Livewire\Pagamento;

use App\Models\Pagamento;
use App\Models\Reserva;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class PagamentoDelete extends Component
{
    public Pagamento $pagamento;

    public function mount($id): void
    {
        $this->pagamento = Pagamento::with(
            'reserva.cliente'
        )->findOrFail($id);
    }

    public function excluir()
    {
        DB::transaction(function () {

            // Bloquear a reserva antes da alteração,
            // seguindo a mesma estratégia usada
            // nos componentes financeiros.

            Reserva::query()
                ->whereKey($this->pagamento->reserva_id)
                ->lockForUpdate()
                ->firstOrFail();

            $pagamento = Pagamento::query()
                ->whereKey($this->pagamento->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Pagamentos recebidos devem permanecer
            // registrados no histórico financeiro.

            if ($pagamento->status === 'pago') {
                throw ValidationException::withMessages([
                    'exclusao' =>
                        'Este pagamento já foi recebido. ' .
                        'Não é permitido excluí-lo. ' .
                        'Um eventual estorno exige registro próprio.',
                ]);
            }

            $pagamento->delete();

        }, 3);

        session()->flash(
            'success',
            'Pagamento excluído com sucesso!'
        );

        return redirect()->route('pagamentos.index');
    }

    public function render()
    {
        return view('livewire.pagamento.pagamento-delete');
    }
}
