<?php

namespace App\Livewire\Lembrete;

use Livewire\Component;
use App\Models\Atendimento;
use App\Models\Lembrete;

class LembreteEdit extends Component
{
    public Lembrete $lembrete;

    public $atendimento_id;

    public $titulo;

    public $descricao;

    public $lembrar_em;

    public $status;


    public function mount($id)
    {
        $this->lembrete =
            Lembrete::findOrFail($id);

        $this->atendimento_id =
            $this->lembrete->atendimento_id;

        $this->titulo =
            $this->lembrete->titulo;

        $this->descricao =
            $this->lembrete->descricao;

        $this->lembrar_em =
            $this->lembrete
                ->lembrar_em
                ->format('Y-m-d\TH:i');

        $this->status =
            $this->lembrete->status;
    }


    protected function rules()
    {
        return [

            'atendimento_id' =>
                'required|exists:atendimentos,id',

            'titulo' =>
                'required|min:3|max:150',

            'descricao' =>
                'nullable|max:2000',

            'lembrar_em' =>
                'required|date',

            'status' =>
                'required|in:pendente,concluido,cancelado',

        ];
    }


    public function atualizar()
    {
        $dados = $this->validate();

        if ($this->status === 'concluido') {

            $dados['concluido_em'] =
                $this->lembrete->concluido_em
                ?? now();

        } else {

            $dados['concluido_em'] = null;

        }

        $this->lembrete->update($dados);

        session()->flash(
            'success',
            'Lembrete atualizado com sucesso!'
        );

        return redirect()
            ->route('lembretes.index');
    }


    public function render()
    {
        $atendimentos =
            Atendimento::with('cliente')
                ->latest()
                ->get();

        return view(
            'livewire.lembrete.lembrete-edit',
            compact('atendimentos')
        );
    }
}