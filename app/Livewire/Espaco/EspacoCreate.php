<?php

namespace App\Livewire\Espaco;

use App\Models\Espaco;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title("Novo Espaço | Rinald's Gestão")]
class EspacoCreate extends Component
{
    public string $nome = '';

    public ?string $descricao = null;

    public ?int $capacidade_maxima = null;

    public int $quantidade_mesas = 0;

    public int $quantidade_cadeiras = 0;

    public ?string $tipo_cadeira = null;

    public bool $possui_cozinha = false;

    public bool $possui_piscina = false;

    public bool $possui_churrasqueira = false;

    public bool $possui_bar_molhado = false;

    public bool $possui_ar_condicionado = false;

    public bool $possui_estacionamento = false;

    public bool $possui_wifi = false;

    public bool $possui_acomodacao = false;

    public ?int $capacidade_hospedes = null;

    public $valor_base = null;

    public ?string $itens_inclusos = null;

    public ?string $itens_nao_inclusos = null;

    public ?string $observacoes = null;

    public bool $ativo = true;


    protected function rules(): array
    {
        return [

            'nome' =>
                'required|min:3|max:150',

            'descricao' =>
                'nullable|string',

            'capacidade_maxima' =>
                'nullable|integer|min:1',

            'quantidade_mesas' =>
                'required|integer|min:0',

            'quantidade_cadeiras' =>
                'required|integer|min:0',

            'tipo_cadeira' =>
                'nullable|max:100',

            'possui_cozinha' =>
                'boolean',

            'possui_piscina' =>
                'boolean',

            'possui_churrasqueira' =>
                'boolean',

            'possui_bar_molhado' =>
                'boolean',

            'possui_ar_condicionado' =>
                'boolean',

            'possui_estacionamento' =>
                'boolean',

            'possui_wifi' =>
                'boolean',

            'possui_acomodacao' =>
                'boolean',

            'capacidade_hospedes' =>
                'nullable|integer|min:0',

            'valor_base' =>
                'nullable|numeric|min:0',

            'itens_inclusos' =>
                'nullable|string',

            'itens_nao_inclusos' =>
                'nullable|string',

            'observacoes' =>
                'nullable|string',

            'ativo' =>
                'boolean',
        ];
    }


    public function salvar()
    {
        $dados = $this->validate();

        Espaco::create($dados);

        session()->flash(
            'success',
            'Espaço cadastrado com sucesso.'
        );

        return redirect()
            ->route('espacos.index');
    }


    public function render()
    {
        return view(
            'livewire.espaco.espaco-create'
        );
    }
}