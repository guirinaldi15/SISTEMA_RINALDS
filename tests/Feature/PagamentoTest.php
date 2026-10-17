<?php

namespace Tests\Feature;

use App\Livewire\Pagamento\PagamentoCreate;
use App\Models\Cliente;
use App\Models\Espaco;
use App\Models\Pagamento;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\Pagamento\PagamentoEdit;

class PagamentoTest extends TestCase
{
    use RefreshDatabase;

    private Reserva $reserva;

    protected function setUp(): void
    {
        parent::setUp();

        /*
        |--------------------------------------------------------------------------
        | PROTEGER O BANCO PRINCIPAL
        |--------------------------------------------------------------------------
        */

        $this->assertSame(
            'testing',
            app()->environment(),
            'O ambiente deve ser testing.'
        );

        $this->assertSame(
            'sistema_rinalds_test',
            DB::connection()->getDatabaseName(),
            'Banco incorreto. Testes interrompidos.'
        );

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR DE TESTE
        |--------------------------------------------------------------------------
        */

        $admin = new User();

        $admin->name = 'Administrador Teste';
        $admin->email = 'admin.pagamento@rinalds.com';
        $admin->password = 'SenhaTeste@123';
        $admin->perfil = 'administrador';
        $admin->ativo = true;

        $admin->save();

        $this->actingAs($admin);

        /*
        |--------------------------------------------------------------------------
        | CLIENTE
        |--------------------------------------------------------------------------
        */

        $cliente = Cliente::create([
            'nome' => 'Cliente Teste Pagamento',
            'telefone' => '18999999999',
            'email' => 'pagamento@example.com',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ESPAÇO
        |--------------------------------------------------------------------------
        */

        $espaco = Espaco::create([
            'nome' => 'Salão Social',
            'capacidade_maxima' => 200,
            'quantidade_mesas' => 22,
            'quantidade_cadeiras' => 150,
            'ativo' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | RESERVA DE R$ 5.000,00
        |--------------------------------------------------------------------------
        */

        $this->reserva = Reserva::create([
            'cliente_id' => $cliente->id,
            'espaco_id' => $espaco->id,
            'data_evento' => '2026-12-20',
            'tipo_evento' => 'Casamento',
            'quantidade_convidados' => 150,
            'valor_total' => 5000,
            'status' => 'confirmada',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAR PAGAMENTO PARA OS TESTES
    |--------------------------------------------------------------------------
    */

    private function criarPagamento(
        float $valor,
        string $status = 'pago'
    ): Pagamento {
        return Pagamento::create([
            'reserva_id' => $this->reserva->id,
            'descricao' => 'Pagamento de teste',
            'valor' => $valor,
            'data_vencimento' => '2026-12-01',
            'data_pagamento' => $status === 'pago'
                ? '2026-11-25'
                : null,
            'forma_pagamento' => 'pix',
            'status' => $status,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 1 - PAGAMENTO VINCULADO À RESERVA
    |--------------------------------------------------------------------------
    */

    public function test_pagamento_pertence_a_reserva(): void
    {
        $pagamento = $this->criarPagamento(1500);

        $this->assertEquals(
            $this->reserva->id,
            $pagamento->reserva->id
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 2 - CALCULAR PAGAMENTO PARCIAL
    |--------------------------------------------------------------------------
    */

    public function test_calcula_pagamento_parcial(): void
    {
        $this->criarPagamento(1500);

        $reserva = $this->reserva->fresh();

        $this->assertEquals(
            1500,
            $reserva->total_pago
        );

        $this->assertEquals(
            3500,
            $reserva->saldo_restante
        );

        $this->assertFalse($reserva->quitada);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 3 - RESERVA TOTALMENTE QUITADA
    |--------------------------------------------------------------------------
    */

    public function test_identifica_reserva_quitada(): void
    {
        $this->criarPagamento(2000);
        $this->criarPagamento(3000);

        $reserva = $this->reserva->fresh();

        $this->assertEquals(
            5000,
            $reserva->total_pago
        );

        $this->assertEquals(
            0,
            $reserva->saldo_restante
        );

        $this->assertTrue($reserva->quitada);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 4 - PAGAMENTO PENDENTE NÃO É RECEBIDO
    |--------------------------------------------------------------------------
    */

    public function test_pagamento_pendente_nao_soma_no_total_pago(): void
    {
        $this->criarPagamento(1500, 'pendente');

        $reserva = $this->reserva->fresh();

        $this->assertEquals(
            0,
            $reserva->total_pago
        );

        $this->assertEquals(
            5000,
            $reserva->saldo_restante
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 5 - PAGAMENTO CANCELADO NÃO É RECEBIDO
    |--------------------------------------------------------------------------
    */

    public function test_pagamento_cancelado_nao_soma_no_total_pago(): void
    {
        $this->criarPagamento(1500, 'cancelado');

        $reserva = $this->reserva->fresh();

        $this->assertEquals(
            0,
            $reserva->total_pago
        );

        $this->assertEquals(
            5000,
            $reserva->saldo_restante
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 6 - CADASTRAR PAGAMENTO PELO LIVEWIRE
    |--------------------------------------------------------------------------
    */

    public function test_cadastra_pagamento_pelo_livewire(): void
    {
        Livewire::test(PagamentoCreate::class)
            ->set('reserva_id', $this->reserva->id)
            ->set('descricao', 'Entrada do casamento')
            ->set('valor', 1500)
            ->set('data_vencimento', '2026-12-01')
            ->set('forma_pagamento', 'pix')
            ->set('status', 'pago')
            ->call('salvar')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('pagamentos', [
            'reserva_id' => $this->reserva->id,
            'descricao' => 'Entrada do casamento',
            'valor' => 1500,
            'status' => 'pago',
        ]);

        $pagamento = Pagamento::first();

        $this->assertNotNull(
            $pagamento->data_pagamento
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 7 - IMPEDIR PAGAMENTO NEGATIVO
    |--------------------------------------------------------------------------
    */

    public function test_impede_pagamento_com_valor_negativo(): void
    {
        Livewire::test(PagamentoCreate::class)
            ->set('reserva_id', $this->reserva->id)
            ->set('descricao', 'Pagamento inválido')
            ->set('valor', -100)
            ->set('data_vencimento', '2026-12-01')
            ->set('status', 'pago')
            ->call('salvar')
            ->assertHasErrors(['valor']);

        $this->assertDatabaseCount('pagamentos', 0);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 8 - IMPEDIR PAGAMENTO ACIMA DO SALDO
    |--------------------------------------------------------------------------
    */

    public function test_impede_pagamento_acima_do_saldo_restante(): void
    {
        $this->criarPagamento(4000);

        Livewire::test(PagamentoCreate::class)
            ->set('reserva_id', $this->reserva->id)
            ->set('descricao', 'Pagamento excedente')
            ->set('valor', 2000)
            ->set('data_vencimento', '2026-12-01')
            ->set('forma_pagamento', 'pix')
            ->set('status', 'pago')
            ->call('salvar')
            ->assertHasErrors(['valor']);

        $this->assertDatabaseCount('pagamentos', 1);
    }

    /*
|--------------------------------------------------------------------------
| TESTE 9 - EDITAR PAGAMENTO DENTRO DO SALDO
|--------------------------------------------------------------------------
*/

    public function test_permite_editar_pagamento_dentro_do_saldo(): void
    {
        $pagamento = $this->criarPagamento(1500);

        Livewire::test(PagamentoEdit::class, [
            'id' => $pagamento->id,
        ])
            ->set('valor', 2000)
            ->call('atualizar')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('pagamentos', [
            'id' => $pagamento->id,
            'valor' => 2000,
            'status' => 'pago',
        ]);

        $this->assertEquals(
            3000,
            $this->reserva->fresh()->saldo_restante
        );
    }

    /*
|--------------------------------------------------------------------------
| TESTE 10 - IMPEDIR EDIÇÃO ACIMA DO SALDO
|--------------------------------------------------------------------------
*/

    public function test_impede_editar_pagamento_acima_do_saldo(): void
    {
        $pagamento = $this->criarPagamento(1500);
        $this->criarPagamento(3000);

        Livewire::test(PagamentoEdit::class, [
            'id' => $pagamento->id,
        ])
            ->set('valor', 2500)
            ->call('atualizar')
            ->assertHasErrors(['valor']);

        $this->assertDatabaseHas('pagamentos', [
            'id' => $pagamento->id,
            'valor' => 1500,
        ]);
    }

    /*
|--------------------------------------------------------------------------
| TESTE 11 - MANTER O PRÓPRIO PAGAMENTO
|--------------------------------------------------------------------------
*/

    public function test_permite_salvar_pagamento_sem_alterar_valor(): void
    {
        $pagamento = $this->criarPagamento(2000);
        $this->criarPagamento(3000);

        Livewire::test(PagamentoEdit::class, [
            'id' => $pagamento->id,
        ])
            ->call('atualizar')
            ->assertHasNoErrors();

        $this->assertEquals(
            5000,
            $this->reserva->fresh()->total_pago
        );
    }

    /*
|--------------------------------------------------------------------------
| TESTE 12 - CONVERTER PENDENTE EM PAGO
|--------------------------------------------------------------------------
*/

    public function test_permite_converter_pendente_em_pago(): void
    {
        $pagamento = $this->criarPagamento(
            1500,
            'pendente'
        );

        Livewire::test(PagamentoEdit::class, [
            'id' => $pagamento->id,
        ])
            ->set('status', 'pago')
            ->call('atualizar')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('pagamentos', [
            'id' => $pagamento->id,
            'status' => 'pago',
        ]);

        $this->assertNotNull(
            $pagamento->fresh()->data_pagamento
        );

        $this->assertEquals(
            3500,
            $this->reserva->fresh()->saldo_restante
        );
    }

    /*
|--------------------------------------------------------------------------
| TESTE 13 - BLOQUEAR RESERVA CANCELADA
|--------------------------------------------------------------------------
*/

    public function test_impede_editar_pagamento_em_reserva_cancelada(): void
    {
        $pagamento = $this->criarPagamento(1500);

        $this->reserva->update([
            'status' => 'cancelada',
        ]);

        Livewire::test(PagamentoEdit::class, [
            'id' => $pagamento->id,
        ])
            ->set('valor', 2000)
            ->call('atualizar')
            ->assertHasErrors(['reserva_id']);

        $this->assertDatabaseHas('pagamentos', [
            'id' => $pagamento->id,
            'valor' => 1500,
        ]);
    }
}
