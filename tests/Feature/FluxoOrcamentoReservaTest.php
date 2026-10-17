<?php

namespace Tests\Feature;

use App\Livewire\Reserva\ReservaCreate;
use App\Models\Atendimento;
use App\Models\Cliente;
use App\Models\Espaco;
use App\Models\Orcamento;
use App\Models\Reserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;

class FluxoOrcamentoReservaTest extends TestCase
{
    use RefreshDatabase;

    private Cliente $cliente;
    private Espaco $espaco;
    private Atendimento $atendimento;
    private Orcamento $orcamento;

    protected function setUp(): void
    {
        parent::setUp();



/*
|--------------------------------------------------------------------------
| AUTENTICAR ADMINISTRADOR DE TESTE
|--------------------------------------------------------------------------
*/

$admin = new \App\Models\User();

$admin->name = 'Administrador Teste';
$admin->email = 'admin.teste@rinalds.com';
$admin->password = 'SenhaTeste@123';
$admin->perfil = 'administrador';
$admin->ativo = true;

$admin->save();

$this->actingAs($admin);



        /*
        |--------------------------------------------------------------------------
        | PROTEGER O BANCO PRINCIPAL
        |--------------------------------------------------------------------------
        */

        $this->assertSame(
            'testing',
            app()->environment(),
            'Os testes devem rodar no ambiente testing.'
        );

        $this->assertSame(
            'sistema_rinalds_test',
            DB::connection()->getDatabaseName(),
            'Banco incorreto! Testes interrompidos.'
        );

        /*
        |--------------------------------------------------------------------------
        | CRIAR CLIENTE
        |--------------------------------------------------------------------------
        */

        $this->cliente = Cliente::create([
            'nome' => 'Cliente Teste Orçamento',
            'telefone' => '18999999999',
            'email' => 'cliente.orcamento@example.com',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CRIAR ESPAÇO
        |--------------------------------------------------------------------------
        */

        $this->espaco = Espaco::create([
            'nome' => 'Salão Social',
            'capacidade_maxima' => 200,
            'quantidade_mesas' => 22,
            'quantidade_cadeiras' => 150,
            'ativo' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | CRIAR ATENDIMENTO
        |--------------------------------------------------------------------------
        */

        $this->atendimento = Atendimento::create([
            'cliente_id' => $this->cliente->id,
            'origem' => 'WhatsApp',
            'tipo_evento' => 'Casamento',
            'data_evento' => '2026-12-20',
            'status' => 'negociacao',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CRIAR ORÇAMENTO ACEITO
        |--------------------------------------------------------------------------
        */

        $this->orcamento = Orcamento::create([
            'atendimento_id' => $this->atendimento->id,
            'espaco_id' => $this->espaco->id,
            'numero' => 'ORC-TESTE-001',
            'validade' => '2026-12-01',
            'quantidade_convidados' => 150,
            'valor_locacao' => 5000,
            'valor_adicionais' => 500,
            'desconto' => 500,
            'valor_total' => 5000,
            'status' => 'aceito',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DADOS UTILIZADOS NO CADASTRO
    |--------------------------------------------------------------------------
    */

    private function dadosReserva(): array
    {
        return [
            'cliente_id' => $this->cliente->id,
            'atendimento_id' => $this->atendimento->id,
            'espaco_id' => $this->espaco->id,
            'data_evento' => '2026-12-20',
            'tipo_evento' => 'Casamento',
            'quantidade_convidados' => 150,
            'valor_total' => 5000,
            'status' => 'confirmada',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 1 - RELACIONAMENTO ATENDIMENTO E CLIENTE
    |--------------------------------------------------------------------------
    */

    public function test_atendimento_pertence_ao_cliente(): void
    {
        $this->assertEquals(
            $this->cliente->id,
            $this->atendimento->cliente->id
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 2 - ORÇAMENTO ASSOCIADO AO ATENDIMENTO
    |--------------------------------------------------------------------------
    */

    public function test_orcamento_pertence_ao_atendimento(): void
    {
        $this->assertEquals(
            $this->atendimento->id,
            $this->orcamento->atendimento->id
        );

        $this->assertEquals(
            $this->espaco->id,
            $this->orcamento->espaco->id
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 3 - PREENCHIMENTO AUTOMÁTICO DA RESERVA
    |--------------------------------------------------------------------------
    */

    public function test_orcamento_aceito_preenche_dados_da_reserva(): void
    {
        $this->get(
            route('reservas.create', [
                'orcamento' => $this->orcamento->id,
            ])
        )
            ->assertOk()
            ->assertSee('Casamento')
            ->assertSee('2026-12-20');
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 4 - CRIAR RESERVA DO ORÇAMENTO ACEITO
    |--------------------------------------------------------------------------
    */

    public function test_orcamento_aceito_pode_gerar_reserva(): void
    {
        $this->app['request']->query->set(
            'orcamento',
            $this->orcamento->id
        );

        Livewire::test(ReservaCreate::class)
            ->set($this->dadosReserva())
            ->call('salvar')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('reservas', [
            'cliente_id' => $this->cliente->id,
            'atendimento_id' => $this->atendimento->id,
            'espaco_id' => $this->espaco->id,
            'data_evento' => '2026-12-20',
            'status' => 'confirmada',
        ]);

        $this->assertDatabaseHas('atendimentos', [
            'id' => $this->atendimento->id,
            'status' => 'fechado',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 5 - BLOQUEAR RESERVA DUPLICADA
    |--------------------------------------------------------------------------
    */

    public function test_impede_duas_reservas_para_mesmo_atendimento(): void
    {
        Reserva::create($this->dadosReserva());

        Livewire::test(ReservaCreate::class)
            ->set($this->dadosReserva())
            ->call('salvar')
            ->assertHasErrors(['data_evento']);

        $this->assertDatabaseCount('reservas', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 6 - ORÇAMENTO NÃO ACEITO
    |--------------------------------------------------------------------------
    */


    public function test_orcamento_nao_aceito_nao_pode_gerar_reserva(): void
    {
        $this->orcamento->update([
            'status' => 'enviado',
        ]);

        $this->get(
            route('reservas.create', [
                'orcamento' => $this->orcamento->id,
            ])
        )->assertRedirect(
            route(
                'orcamentos.show',
                $this->orcamento->id
            )
        );

        $this->assertDatabaseCount('reservas', 0);
    }


    /*
    |--------------------------------------------------------------------------
    | TESTE 7 - ALTERAÇÃO INDEVIDA DO ESPAÇO
    |--------------------------------------------------------------------------
    */


    public function test_impede_alterar_espaco_do_orcamento_aceito(): void
    {
        $outroEspaco = Espaco::create([
            'nome' => "Refúgio Rinald's",
            'capacidade_maxima' => 250,
            'quantidade_mesas' => 0,
            'quantidade_cadeiras' => 0,
            'ativo' => true,
        ]);

        Livewire::test(ReservaCreate::class)
            ->set('orcamento_id', $this->orcamento->id)
            ->set(
                array_merge(
                    $this->dadosReserva(),
                    [
                        'espaco_id' => $outroEspaco->id,
                    ]
                )
            )
            ->call('salvar')
            ->assertHasErrors(['espaco_id']);

        $this->assertDatabaseCount('reservas', 0);
    }
}
