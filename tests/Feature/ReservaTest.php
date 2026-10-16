<?php

namespace Tests\Feature;

use App\Livewire\Reserva\ReservaCreate;
use App\Livewire\Reserva\ReservaEdit;
use App\Models\Cliente;
use App\Models\Espaco;
use App\Models\Reserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class ReservaTest extends TestCase
{
    use RefreshDatabase;

    private Cliente $cliente;
    private Espaco $salao;
    private Espaco $refugio;

    protected function setUp(): void
    {
        parent::setUp();

        $this->assertSame(
            'testing',
            app()->environment(),
            'Os testes devem usar o ambiente testing.'
        );

        $this->assertSame(
            'sistema_rinalds_test',
            DB::connection()->getDatabaseName(),
            'Banco incorreto! Interrompa os testes.'
        );

        $this->cliente = Cliente::create([
            'nome' => 'Cliente de Teste',
            'telefone' => '18999999999',
            'email' => 'teste@example.com',
        ]);

        $this->salao = Espaco::create([
            'nome' => 'Salão Social',
            'capacidade_maxima' => 200,
            'quantidade_mesas' => 22,
            'quantidade_cadeiras' => 150,
            'ativo' => true,
        ]);

        $this->refugio = Espaco::create([
            'nome' => "Refúgio Rinald's",
            'capacidade_maxima' => 250,
            'quantidade_mesas' => 0,
            'quantidade_cadeiras' => 0,
            'ativo' => true,
        ]);
    }

    private function dadosReserva(
        int $espacoId,
        string $data = '2026-12-20',
        int $convidados = 100
    ): array {
        return [
            'cliente_id' => $this->cliente->id,
            'espaco_id' => $espacoId,
            'data_evento' => $data,
            'tipo_evento' => 'Aniversário',
            'quantidade_convidados' => $convidados,
            'valor_total' => 2500,
            'status' => 'confirmada',
        ];
    }

    private function criarReserva(
        int $espacoId,
        string $data = '2026-12-20'
    ): Reserva {
        return Reserva::create(
            $this->dadosReserva($espacoId, $data)
        );
    }

    public function test_pode_criar_reserva_em_data_livre(): void
    {
        Livewire::test(ReservaCreate::class)
            ->set(
                $this->dadosReserva($this->salao->id)
            )
            ->call('salvar')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('reservas', [
            'espaco_id' => $this->salao->id,
            'data_evento' => '2026-12-20',
            'status' => 'confirmada',
        ]);
    }

    public function test_impede_duas_reservas_no_mesmo_espaco_e_data(): void
    {
        $this->criarReserva($this->salao->id);

        Livewire::test(ReservaCreate::class)
            ->set(
                $this->dadosReserva($this->salao->id)
            )
            ->call('salvar')
            ->assertHasErrors(['data_evento']);

        $this->assertDatabaseCount('reservas', 1);
    }

    public function test_permite_reservas_em_espacos_diferentes_no_mesmo_dia(): void
    {
        $this->criarReserva($this->salao->id);

        Livewire::test(ReservaCreate::class)
            ->set(
                $this->dadosReserva($this->refugio->id)
            )
            ->call('salvar')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('reservas', 2);
    }

    public function test_impede_reserva_acima_da_capacidade(): void
    {
        Livewire::test(ReservaCreate::class)
            ->set(
                $this->dadosReserva(
                    $this->salao->id,
                    '2026-12-20',
                    250
                )
            )
            ->call('salvar')
            ->assertHasErrors([
                'quantidade_convidados',
            ]);

        $this->assertDatabaseCount('reservas', 0);
    }

    public function test_impede_reserva_em_espaco_inativo(): void
    {
        $this->salao->update([
            'ativo' => false,
        ]);

        Livewire::test(ReservaCreate::class)
            ->set(
                $this->dadosReserva($this->salao->id)
            )
            ->call('salvar')
            ->assertHasErrors(['espaco_id']);

        $this->assertDatabaseCount('reservas', 0);
    }

    public function test_impede_edicao_para_data_ocupada(): void
    {
        $this->criarReserva(
            $this->salao->id,
            '2026-12-20'
        );

        $segundaReserva = $this->criarReserva(
            $this->salao->id,
            '2026-12-21'
        );

        Livewire::test(
            ReservaEdit::class,
            ['id' => $segundaReserva->id]
        )
            ->set('data_evento', '2026-12-20')
            ->call('atualizar')
            ->assertHasErrors(['data_evento']);

        $this->assertDatabaseHas('reservas', [
            'id' => $segundaReserva->id,
            'data_evento' => '2026-12-21',
        ]);
    }

    public function test_permite_editar_reserva_sem_conflito(): void
    {
        $reserva = $this->criarReserva(
            $this->salao->id,
            '2026-12-20'
        );

        Livewire::test(
            ReservaEdit::class,
            ['id' => $reserva->id]
        )
            ->set('data_evento', '2026-12-22')
            ->call('atualizar')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'data_evento' => '2026-12-22',
        ]);
    }
}
