<?php

namespace App\Livewire\Espaco;

use App\Models\Espaco;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title("Editar Espaço | Rinald's Gestão")]
class EspacoEdit extends Component
{
    public Espaco $espaco;

    public $nome;
    public $descricao;
    public $capacidade_maxima;
    public $quantidade_mesas;
    public $quantidade_cadeiras;
    public $tipo_cadeira;

    public $possui_cozinha;
    public $possui_piscina;
    public $possui_churrasqueira;
    public $possui_bar_molhado;
    public $possui_ar_condicionado;
    public $possui_estacionamento;
    public $possui_wifi;
    public $possui_acomodacao;

    public $capacidade_hospedes;
    public $valor_base;

    public $itens_inclusos;
    public $itens_nao_inclusos;
    public $observacoes;

    public $ativo;


    public function mount(int $id): void
    {
        $this->espaco =
            Espaco::findOrFail($id);

        foreach (
            $this->espaco->getAttributes()
            as $campo => $valor
        ) {

            if (
                property_exists(
                    $this,
                    $campo
                )
            ) {

                $this->{$campo} =
                    $this->espaco->{$campo};
            }
        }
    }


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


    public function atualizar()
    {
        $dados = $this->validate();

        $this->espaco
            ->update($dados);

        session()->flash(
            'success',
            'Espaço atualizado com sucesso.'
        );

        return redirect()
            ->route('espacos.index');
    }


    public function render()
    {
        return view(
            'livewire.espaco.espaco-edit'
        );
    }
}