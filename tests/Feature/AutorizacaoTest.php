<?php

namespace Tests\Feature;

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class AutorizacaoTest extends TestCase
{
    use RefreshDatabase;

    private function criarUsuario(
        string $perfil,
        bool $ativo = true
    ): User {
        return User::create([
            'name' => 'Usuario Teste ' . $perfil,
            'email' => uniqid('teste_', true) . '@example.com',
            'password' => 'SenhaTeste@123',
            'perfil' => $perfil,
            'ativo' => $ativo,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 1 - ADMINISTRADOR ACESSA FINANCEIRO
    |--------------------------------------------------------------------------
    */

    public function test_administrador_ativo_acessa_financeiro(): void
    {
        $admin = $this->criarUsuario('administrador');

        $this->actingAs($admin)
            ->get(route('pagamentos.index'))
            ->assertOk();
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 2 - ADMINISTRADOR GERENCIA USUÁRIOS
    |--------------------------------------------------------------------------
    */

    public function test_administrador_ativo_acessa_usuarios(): void
    {
        $admin = $this->criarUsuario('administrador');

        $this->actingAs($admin)
            ->get(route('usuarios.index'))
            ->assertOk();
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 3 - ATENDENTE NÃO ACESSA FINANCEIRO
    |--------------------------------------------------------------------------
    */

    public function test_atendente_nao_acessa_financeiro(): void
    {
        $atendente = $this->criarUsuario('atendente');

        $this->actingAs($atendente)
            ->get(route('pagamentos.index'))
            ->assertForbidden();
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 4 - ATENDENTE NÃO GERENCIA USUÁRIOS
    |--------------------------------------------------------------------------
    */

    public function test_atendente_nao_acessa_usuarios(): void
    {
        $atendente = $this->criarUsuario('atendente');

        $this->actingAs($atendente)
            ->get(route('usuarios.index'))
            ->assertForbidden();
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 5 - ATENDENTE ACESSA DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function test_atendente_ativo_acessa_dashboard(): void
    {
        $atendente = $this->criarUsuario('atendente');

        $this->actingAs($atendente)
            ->get(route('dashboard.index'))
            ->assertOk();
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 6 - USUÁRIO INATIVO NÃO FAZ LOGIN
    |--------------------------------------------------------------------------
    */

    public function test_usuario_inativo_nao_consegue_logar(): void
    {
        $usuario = $this->criarUsuario(
            'atendente',
            false
        );

        Livewire::test(Login::class)
            ->set('email', $usuario->email)
            ->set('password', 'SenhaTeste@123')
            ->call('entrar')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 7 - USUÁRIO DESATIVADO PERDE A SESSÃO
    |--------------------------------------------------------------------------
    */

    public function test_usuario_desativado_perde_acesso(): void
    {
        $usuario = $this->criarUsuario('atendente');

        $this->actingAs($usuario)
            ->get(route('dashboard.index'))
            ->assertOk();

        // Administrador desativa a conta no banco.
        $usuario->update(['ativo' => false]);

        // Ao navegar novamente, o middleware deve
        // desconectar o usuário e redirecioná-lo.
        $this->get(route('dashboard.index'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 8 - VISITANTE NÃO ACESSA FINANCEIRO
    |--------------------------------------------------------------------------
    */

    public function test_visitante_nao_acessa_financeiro(): void
    {
        $this->get(route('pagamentos.index'))
            ->assertRedirect(route('login'));
    }

    /*
    |--------------------------------------------------------------------------
    | TESTE 9 - VISITANTE NÃO ACESSA DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function test_visitante_nao_acessa_dashboard(): void
    {
        $this->get(route('dashboard.index'))
            ->assertRedirect(route('login'));
    }
}
