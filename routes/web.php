<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// ============================================================
// AUTENTICAÇÃO
// ============================================================

use App\Livewire\Auth\Login;


// ============================================================
// DASHBOARD
// ============================================================

use App\Livewire\Dashboard\DashboardIndex;


// ============================================================
// CLIENTES
// ============================================================

use App\Livewire\Cliente\ClienteIndex;
use App\Livewire\Cliente\ClienteCreate;
use App\Livewire\Cliente\ClienteEdit;
use App\Livewire\Cliente\ClienteDelete;
use App\Livewire\Cliente\ClienteShow;


// ============================================================
// ATENDIMENTOS
// ============================================================

use App\Livewire\Atendimento\AtendimentoIndex;
use App\Livewire\Atendimento\AtendimentoCreate;
use App\Livewire\Atendimento\AtendimentoEdit;
use App\Livewire\Atendimento\AtendimentoDelete;


// ============================================================
// LEMBRETES
// ============================================================

use App\Livewire\Lembrete\LembreteIndex;
use App\Livewire\Lembrete\LembreteCreate;
use App\Livewire\Lembrete\LembreteEdit;
use App\Livewire\Lembrete\LembreteDelete;


// ============================================================
// AGENDA
// ============================================================

use App\Livewire\Agenda\AgendaIndex;


// ============================================================
// RESERVAS
// ============================================================

use App\Livewire\Reserva\ReservaIndex;
use App\Livewire\Reserva\ReservaCreate;
use App\Livewire\Reserva\ReservaEdit;
use App\Livewire\Reserva\ReservaDelete;
use App\Livewire\Reserva\ReservaShow;


// ============================================================
// ORÇAMENTOS
// ============================================================

use App\Livewire\Orcamento\OrcamentoIndex;
use App\Livewire\Orcamento\OrcamentoCreate;
use App\Livewire\Orcamento\OrcamentoEdit;
use App\Livewire\Orcamento\OrcamentoDelete;
use App\Livewire\Orcamento\OrcamentoShow;


// ============================================================
// PAGAMENTOS
// ============================================================

use App\Livewire\Pagamento\PagamentoIndex;
use App\Livewire\Pagamento\PagamentoCreate;
use App\Livewire\Pagamento\PagamentoEdit;
use App\Livewire\Pagamento\PagamentoDelete;


// ============================================================
// USUÁRIOS
// ============================================================

use App\Livewire\Usuario\UsuarioIndex;
use App\Livewire\Usuario\UsuarioCreate;
use App\Livewire\Usuario\UsuarioEdit;
use App\Livewire\Usuario\UsuarioDelete;



/*
|--------------------------------------------------------------------------
| SITE PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    function () {

        return view('site.home');
    }
)
    ->name('site.home');



/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')
    ->group(function () {

        Route::get(
            '/login',
            Login::class
        )
            ->name('login');
    });



/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post(
    '/logout',
    function (Request $request) {

        Auth::logout();

        $request
            ->session()
            ->invalidate();

        $request
            ->session()
            ->regenerateToken();

        return redirect()
            ->route('login');
    }
)
    ->middleware('auth')
    ->name('logout');



/*
|--------------------------------------------------------------------------
| ÁREA ADMINISTRATIVA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            DashboardIndex::class
        )
            ->name('dashboard.index');



        /*
        |--------------------------------------------------------------------------
        | CLIENTES
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/clientes',
            ClienteIndex::class
        )
            ->name('clientes.index');


        Route::get(
            '/clientes/novo',
            ClienteCreate::class
        )
            ->name('clientes.create');


        Route::get(
            '/clientes/{id}/editar',
            ClienteEdit::class
        )
            ->name('clientes.edit');


        Route::get(
            '/clientes/{id}/excluir',
            ClienteDelete::class
        )
            ->name('clientes.delete');


        Route::get(
            '/clientes/{id}',
            ClienteShow::class
        )
            ->name('clientes.show');



        /*
        |--------------------------------------------------------------------------
        | ATENDIMENTOS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/atendimentos',
            AtendimentoIndex::class
        )
            ->name('atendimentos.index');


        Route::get(
            '/atendimentos/novo',
            AtendimentoCreate::class
        )
            ->name('atendimentos.create');


        Route::get(
            '/atendimentos/{id}/editar',
            AtendimentoEdit::class
        )
            ->name('atendimentos.edit');


        Route::get(
            '/atendimentos/{id}/excluir',
            AtendimentoDelete::class
        )
            ->name('atendimentos.delete');



        /*
        |--------------------------------------------------------------------------
        | LEMBRETES
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/lembretes',
            LembreteIndex::class
        )
            ->name('lembretes.index');


        Route::get(
            '/lembretes/novo',
            LembreteCreate::class
        )
            ->name('lembretes.create');


        Route::get(
            '/lembretes/{id}/editar',
            LembreteEdit::class
        )
            ->name('lembretes.edit');


        Route::get(
            '/lembretes/{id}/excluir',
            LembreteDelete::class
        )
            ->name('lembretes.delete');



        /*
        |--------------------------------------------------------------------------
        | AGENDA
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/agenda',
            AgendaIndex::class
        )
            ->name('agenda.index');



        /*
        |--------------------------------------------------------------------------
        | RESERVAS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reservas',
            ReservaIndex::class
        )
            ->name('reservas.index');


        Route::get(
            '/reservas/nova',
            ReservaCreate::class
        )
            ->name('reservas.create');


        Route::get(
            '/reservas/{id}/editar',
            ReservaEdit::class
        )
            ->name('reservas.edit');


        Route::get(
            '/reservas/{id}/excluir',
            ReservaDelete::class
        )
            ->name('reservas.delete');


        Route::get(
            '/reservas/{id}',
            ReservaShow::class
        )
            ->name('reservas.show');



        /*
        |--------------------------------------------------------------------------
        | ORÇAMENTOS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orcamentos',
            OrcamentoIndex::class
        )
            ->name('orcamentos.index');


        Route::get(
            '/orcamentos/novo',
            OrcamentoCreate::class
        )
            ->name('orcamentos.create');


        Route::get(
            '/orcamentos/{id}/editar',
            OrcamentoEdit::class
        )
            ->name('orcamentos.edit');


        Route::get(
            '/orcamentos/{id}/excluir',
            OrcamentoDelete::class
        )
            ->name('orcamentos.delete');


        Route::get(
            '/orcamentos/{id}',
            OrcamentoShow::class
        )
            ->name('orcamentos.show');



        /*
        |--------------------------------------------------------------------------
        | SOMENTE ADMINISTRADOR
        |--------------------------------------------------------------------------
        */

        Route::middleware('admin')
            ->group(function () {


                /*
                |--------------------------------------------------------------------------
                | FINANCEIRO
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/financeiro',
                    PagamentoIndex::class
                )
                    ->name('pagamentos.index');


                Route::get(
                    '/financeiro/novo',
                    PagamentoCreate::class
                )
                    ->name('pagamentos.create');


                Route::get(
                    '/financeiro/{id}/editar',
                    PagamentoEdit::class
                )
                    ->name('pagamentos.edit');


                Route::get(
                    '/financeiro/{id}/excluir',
                    PagamentoDelete::class
                )
                    ->name('pagamentos.delete');



                /*
                |--------------------------------------------------------------------------
                | USUÁRIOS
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/usuarios',
                    UsuarioIndex::class
                )
                    ->name('usuarios.index');


                Route::get(
                    '/usuarios/novo',
                    UsuarioCreate::class
                )
                    ->name('usuarios.create');


                Route::get(
                    '/usuarios/{id}/editar',
                    UsuarioEdit::class
                )
                    ->name('usuarios.edit');


                Route::get(
                    '/usuarios/{id}/excluir',
                    UsuarioDelete::class
                )
                    ->name('usuarios.delete');
            });
    });