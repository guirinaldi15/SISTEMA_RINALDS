<?php

namespace App\Livewire\Lembrete;

use Livewire\Component;
use App\Models\Atendimento;
use App\Models\Lembrete;

class LembreteCreate extends Component
{
    public $atendimento_id;

    public $titulo = 'Retornar cliente';

    public $descricao;

    public $lembrar_em;

    public $status = 'pendente';


    public function mount()
    {
        /*
        |--------------------------------------------------------------------------
        | Atendimento vindo pela URL
        |--------------------------------------------------------------------------
        |
        | Permite abrir:
        |
        | /lembretes/novo?atendimento=3
        |
        */

        if (request()->has('atendimento')) {

            $this->atendimento_id =
                request()->get('atendimento');

        }
    }


    protected $rules = [

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


    protected $messages = [

        'atendimento_id.required' =>
            'Selecione um atendimento.',

        'titulo.required' =>
            'Informe o título do lembrete.',

        'lembrar_em.required' =>
            'Informe quando deseja receber o lembrete.',

    ];


    public function salvar()
    {
        $dados = $this->validate();

        Lembrete::create($dados);

        session()->flash(
            'success',
            'Lembrete criado com sucesso!'
        );

        return redirect()
            ->route('lembretes.index');
    }


    public function render()
    {
        $atendimentos =
            Atendimento::with('cliente')
                ->whereNotIn(
                    'status',
                    [
                        'fechado',
                        'perdido'
                    ]
                )
                ->latest()
                ->get();

        return view(
            'livewire.lembrete.lembrete-create',
            compact('atendimentos')
        );
    }
}