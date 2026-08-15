<?php

namespace App\Livewire\Site;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Atendimento;

class SolicitarOrcamento extends Component
{
    public $nome = '';
    public $telefone = '';
    public $email = '';

    public $tipo_evento = '';
    public $data_evento = '';
    public $quantidade_convidados = '';

    public $mensagem = '';

    protected function rules()
    {
        return [
            'nome' =>
                'required|min:3|max:150',

            'telefone' =>
                'required|min:10|max:30',

            'email' =>
                'nullable|email|max:150',

            'tipo_evento' =>
                'required|max:100',

            'data_evento' =>
                'nullable|date|after_or_equal:today',

            'quantidade_convidados' =>
                'nullable|integer|min:1|max:1000',

            'mensagem' =>
                'nullable|max:2000',
        ];
    }

    protected $messages = [
        'nome.required' =>
            'Informe seu nome.',

        'nome.min' =>
            'Informe um nome válido.',

        'telefone.required' =>
            'Informe seu WhatsApp.',

        'telefone.min' =>
            'Informe um telefone válido.',

        'email.email' =>
            'Informe um e-mail válido.',

        'tipo_evento.required' =>
            'Selecione o tipo do evento.',

        'data_evento.after_or_equal' =>
            'A data do evento não pode ser anterior a hoje.',

        'quantidade_convidados.integer' =>
            'Informe uma quantidade válida de convidados.'
    ];

    public function enviar()
    {
        $this->validate();

        /*
        |--------------------------------------------------------------------------
        | LIMPAR TELEFONE
        |--------------------------------------------------------------------------
        */

        $telefoneLimpo =
            preg_replace(
                '/\D/',
                '',
                $this->telefone
            );


        /*
        |--------------------------------------------------------------------------
        | LOCALIZAR OU CRIAR CLIENTE
        |--------------------------------------------------------------------------
        |
        | O telefone será usado para evitar duplicar o mesmo cliente.
        |
        */

        $cliente =
            Cliente::where(
                'telefone',
                $telefoneLimpo
            )
            ->first();


        if (!$cliente) {

            $cliente = Cliente::create([
                'nome' =>
                    $this->nome,

                'telefone' =>
                    $telefoneLimpo,

                'email' =>
                    $this->email ?: null,

                'observacoes' =>
                    'Cliente cadastrado automaticamente pelo site.'
            ]);

        } else {

            /*
            |--------------------------------------------------------------------------
            | ATUALIZA DADOS BÁSICOS
            |--------------------------------------------------------------------------
            */

            $cliente->update([
                'nome' =>
                    $this->nome,

                'email' =>
                    $this->email
                    ?: $cliente->email,
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | OBSERVAÇÕES DO ATENDIMENTO
        |--------------------------------------------------------------------------
        */

        $observacoes = [];

        if ($this->quantidade_convidados) {

            $observacoes[] =
                'Quantidade estimada de convidados: '
                . $this->quantidade_convidados;

        }

        if ($this->mensagem) {

            $observacoes[] =
                'Mensagem enviada pelo cliente:'
                . PHP_EOL
                . $this->mensagem;

        }

        $observacoes[] =
            'Solicitação recebida através do site da Chácara Rinald\'s.';


        /*
        |--------------------------------------------------------------------------
        | CRIAR ATENDIMENTO
        |--------------------------------------------------------------------------
        */

        Atendimento::create([
            'cliente_id' =>
                $cliente->id,

            'origem' =>
                'Site',

            'tipo_evento' =>
                $this->tipo_evento,

            'data_evento' =>
                $this->data_evento ?: null,

            'status' =>
                'novo',

            'ultimo_contato' =>
                now(),

            'observacoes' =>
                implode(
                    PHP_EOL . PHP_EOL,
                    $observacoes
                ),
        ]);


        /*
        |--------------------------------------------------------------------------
        | LIMPAR FORMULÁRIO
        |--------------------------------------------------------------------------
        */

        $this->reset([
            'nome',
            'telefone',
            'email',
            'tipo_evento',
            'data_evento',
            'quantidade_convidados',
            'mensagem'
        ]);


        session()->flash(
            'site_success',
            'Solicitação enviada com sucesso! Nossa equipe entrará em contato pelo WhatsApp.'
        );
    }

    public function render()
    {
        return view(
            'livewire.site.solicitar-orcamento'
        );
    }
}