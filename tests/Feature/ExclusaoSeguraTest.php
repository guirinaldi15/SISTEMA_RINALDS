<?php

namespace Tests\Feature;

use App\Livewire\Reserva\ReservaDelete;
use App\Livewire\Pagamento\PagamentoDelete;
use App\Models\Cliente;
use App\Models\Espaco;
use App\Models\Pagamento;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class ExclusaoSeguraTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Cliente $cliente;
    private Espaco $espaco;

    protected function setUp(): void
    {
        parent::setUp();

        /*
        |--------------------------------------------------------------------------
        | PROTEÇÃO DO BANCO PRINCIPAL
        |--------------------------------------------------------------------------
        */

        $this->assertSame(
            'testing',
            app()->environment(),
            'Os testes devem executar no ambiente testing.'
        );

        $this->assertSame(
            'sistema_rinalds_test',
            DB::connection()->getDatabaseName(),
            'Banco incorreto! Testes interrompidos.'
        );

        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR
        |--------------------------------------------------------------------------
        */

        $this->admin = User::create([
            'name' => 'Administrador Teste',
            'email' => 'admin.exclusao@example.com',
            'password' => 'SenhaTeste@123',
            'perfil' => 'administrador',
            'ativo' => true,
        ]);

        $this->actingAs($this->admin);

        /*
        |--------------------------------------------------------------------------
        | CLIENTE
        |--------------------------------------------------------------------------
        */

        $this->cliente = Cliente::create([
            'nome' => 'Cliente Teste Exclusão',
            'telefone' => '18999999999',
            'email' => 'cliente.exclusao@example.com',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ESPAÇO
        |--------------------------------------------------------------------------
        */

        $this->espaco = Espaco::create([
            'nome' => 'Salão Social Teste',
            'capacidade_maxima' => 200,
            'quantidade_mesas' => 22,
            'quantidade_cadeiras' => 150,
            'ativo' => true,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODO AUXILIAR - CRIAR RESERVA
    |--------------------------------------------------------------------------
    */

    private function criarReserva(
        string $status = 'pre_reserva'
    ): Reserva {
        return Reserva::create([
            'cliente_id' => $this->cliente->id,
            'espaco_id' => $this->espaco->id,
            'data_evento' => '2027-09-15',
            'tipo_evento' => 'Aniversário',
            'quantidade_convidados' => 100,
            'valor_total' => 3000,
            'status' => $status,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODO AUXILIAR - CRIAR PAGAMENTO
    |--------------------------------------------------------------------------
    */

    private function criarPagamento(
        Reserva $reserva,
        string $status = 'pendente'
    ): Pagamento {
        return Pagamento::create([
            'reserva_id' => $reserva->id,
            'descricao' => 'Pagamento Teste',
            'valor' => 1000,
            'data_vencimento' => '2027-09-01',
            'data_pagamento' =>
                $status === 'pago'
                    ? '2027-08-20'
                    : null,
            'forma_pagamento' => 'pix',
            'status' => $status,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 1 - NÃO EXCLUIR RESERVA COM PAGAMENTO
    |--------------------------------------------------------------------------
    */

    public function test_nao_exclui_reserva_com_pagamento(): void
    {
        $reserva = $this->criarReserva();

        $pagamento = $this->criarPagamento(
            $reserva,
            'pago'
        );

        Livewire::test(ReservaDelete::class, [
            'id' => $reserva->id,
        ])
            ->call('excluir')
            ->assertHasErrors(['exclusao']);

        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
        ]);

        $this->assertDatabaseHas('pagamentos', [
            'id' => $pagamento->id,
            'reserva_id' => $reserva->id,
            'status' => 'pago',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 2 - NÃO EXCLUIR RESERVA CONFIRMADA
    |--------------------------------------------------------------------------
    */

    public function test_nao_exclui_reserva_confirmada(): void
    {
        $reserva = $this->criarReserva('confirmada');

        Livewire::test(ReservaDelete::class, [
            'id' => $reserva->id,
        ])
            ->call('excluir')
            ->assertHasErrors(['exclusao']);

        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'status' => 'confirmada',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 3 - NÃO EXCLUIR RESERVA REALIZADA
    |--------------------------------------------------------------------------
    */

    public function test_nao_exclui_reserva_realizada(): void
    {
        $reserva = $this->criarReserva('realizada');

        Livewire::test(ReservaDelete::class, [
            'id' => $reserva->id,
        ])
            ->call('excluir')
            ->assertHasErrors(['exclusao']);

        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'status' => 'realizada',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 4 - EXCLUIR PRÉ-RESERVA SEM PAGAMENTO
    |--------------------------------------------------------------------------
    */

    public function test_exclui_pre_reserva_sem_pagamento(): void
    {
        $reserva = $this->criarReserva('pre_reserva');

        Livewire::test(ReservaDelete::class, [
            'id' => $reserva->id,
        ])
            ->call('excluir')
            ->assertHasNoErrors()
            ->assertRedirect(route('reservas.index'));

        $this->assertDatabaseMissing('reservas', [
            'id' => $reserva->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 5 - NÃO EXCLUIR PAGAMENTO RECEBIDO
    |--------------------------------------------------------------------------
    */

    public function test_nao_exclui_pagamento_recebido(): void
    {
        $reserva = $this->criarReserva('confirmada');

        $pagamento = $this->criarPagamento(
            $reserva,
            'pago'
        );

        Livewire::test(PagamentoDelete::class, [
            'id' => $pagamento->id,
        ])
            ->call('excluir')
            ->assertHasErrors(['exclusao']);

        $this->assertDatabaseHas('pagamentos', [
            'id' => $pagamento->id,
            'status' => 'pago',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 6 - EXCLUIR PAGAMENTO PENDENTE
    |--------------------------------------------------------------------------
    */

    public function test_exclui_pagamento_pendente(): void
    {
        $reserva = $this->criarReserva('confirmada');

        $pagamento = $this->criarPagamento(
            $reserva,
            'pendente'
        );

        Livewire::test(PagamentoDelete::class, [
            'id' => $pagamento->id,
        ])
            ->call('excluir')
            ->assertHasNoErrors()
            ->assertRedirect(route('pagamentos.index'));

        $this->assertDatabaseMissing('pagamentos', [
            'id' => $pagamento->id,
        ]);

        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 7 - EXCLUIR PAGAMENTO CANCELADO
    |--------------------------------------------------------------------------
    */

    public function test_exclui_pagamento_cancelado(): void
    {
        $reserva = $this->criarReserva('confirmada');

        $pagamento = $this->criarPagamento(
            $reserva,
            'cancelado'
        );

        Livewire::test(PagamentoDelete::class, [
            'id' => $pagamento->id,
        ])
            ->call('excluir')
            ->assertHasNoErrors()
            ->assertRedirect(route('pagamentos.index'));

        $this->assertDatabaseMissing('pagamentos', [
            'id' => $pagamento->id,
        ]);
    }
}
