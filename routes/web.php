<?php

use App\Livewire\Agenda\AgendaIndex;
use App\Livewire\Atendimento\AtendimentoCreate;
use App\Livewire\Atendimento\AtendimentoDelete;
use App\Livewire\Atendimento\AtendimentoEdit;
use App\Livewire\Atendimento\AtendimentoIndex;
use Illuminate\Support\Facades\Route;

use App\Livewire\Cliente\ClienteIndex;
use App\Livewire\Cliente\ClienteCreate;
use App\Livewire\Cliente\ClienteEdit;
use App\Livewire\Cliente\ClienteDelete;
use App\Livewire\Lembrete\LembreteCreate;
use App\Livewire\Lembrete\LembreteDelete;
use App\Livewire\Lembrete\LembreteEdit;
use App\Livewire\Lembrete\LembreteIndex;
use App\Livewire\Reserva\ReservaIndex;
use App\Livewire\Reserva\ReservaCreate;
use App\Livewire\Reserva\ReservaEdit;
use App\Livewire\Reserva\ReservaDelete;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Cliente\ClienteShow;
use App\Livewire\Orcamento\OrcamentoIndex;
use App\Livewire\Orcamento\OrcamentoCreate;
use App\Livewire\Orcamento\OrcamentoEdit;
use App\Livewire\Orcamento\OrcamentoDelete;
use App\Livewire\Orcamento\OrcamentoShow;
use App\Livewire\Pagamento\PagamentoIndex;
use App\Livewire\Pagamento\PagamentoCreate;
use App\Livewire\Pagamento\PagamentoEdit;
use App\Livewire\Pagamento\PagamentoDelete;
use App\Livewire\Reserva\ReservaShow;

// =============================
// INÍCIO
// =============================

Route::get(
    '/',
    DashboardIndex::class
)->name('dashboard');

Route::get(
    '/dashboard',
    DashboardIndex::class
)->name('dashboard.index');




// =============================
// RESERVAS
// =============================

Route::get(
    '/reservas',
    ReservaIndex::class
)->name('reservas.index');


Route::get(
    '/reservas/nova',
    ReservaCreate::class
)->name('reservas.create');


Route::get(
    '/reservas/{id}/editar',
    ReservaEdit::class
)->name('reservas.edit');


Route::get(
    '/reservas/{id}/excluir',
    ReservaDelete::class
)->name('reservas.delete');
Route::get(
    '/reservas/{id}',
    ReservaShow::class
)->name('reservas.show');




Route::get(
    '/agenda',
    AgendaIndex::class
)->name('agenda.index');

// =============================
// ATENDIMENTOS
// =============================

Route::get(
    '/atendimentos',
    AtendimentoIndex::class
)->name('atendimentos.index');


Route::get(
    '/atendimentos/novo',
    AtendimentoCreate::class
)->name('atendimentos.create');


Route::get(
    '/atendimentos/{id}/editar',
    AtendimentoEdit::class
)->name('atendimentos.edit');


Route::get(
    '/atendimentos/{id}/excluir',
    AtendimentoDelete::class
)->name('atendimentos.delete');

// =============================
// LEMBRETES
// =============================

Route::get(
    '/lembretes',
    LembreteIndex::class
)->name('lembretes.index');


Route::get(
    '/lembretes/novo',
    LembreteCreate::class
)->name('lembretes.create');


Route::get(
    '/lembretes/{id}/editar',
    LembreteEdit::class
)->name('lembretes.edit');


Route::get(
    '/lembretes/{id}/excluir',
    LembreteDelete::class
)->name('lembretes.delete');


// =============================
// CLIENTES
// =============================

Route::get(
    '/clientes',
    ClienteIndex::class
)->name('clientes.index');


Route::get(
    '/clientes/novo',
    ClienteCreate::class
)->name('clientes.create');


Route::get(
    '/clientes/{id}/editar',
    ClienteEdit::class
)->name('clientes.edit');


Route::get(
    '/clientes/{id}/excluir',
    ClienteDelete::class
)->name('clientes.delete');


Route::get(
    '/clientes/{id}',
    ClienteShow::class
)->name('clientes.show');


// =============================
// ORÇAMENTOS
// =============================

Route::get(
    '/orcamentos',
    OrcamentoIndex::class
)->name('orcamentos.index');


Route::get(
    '/orcamentos/novo',
    OrcamentoCreate::class
)->name('orcamentos.create');


Route::get(
    '/orcamentos/{id}/editar',
    OrcamentoEdit::class
)->name('orcamentos.edit');


Route::get(
    '/orcamentos/{id}/excluir',
    OrcamentoDelete::class
)->name('orcamentos.delete');

Route::get(
    '/orcamentos/{id}',
    OrcamentoShow::class
)->name('orcamentos.show');

// =============================
// FINANCEIRO / PAGAMENTOS
// =============================

Route::get(
    '/financeiro',
    PagamentoIndex::class
)->name('pagamentos.index');


Route::get(
    '/financeiro/novo',
    PagamentoCreate::class
)->name('pagamentos.create');


Route::get(
    '/financeiro/{id}/editar',
    PagamentoEdit::class
)->name('pagamentos.edit');


Route::get(
    '/financeiro/{id}/excluir',
    PagamentoDelete::class
)->name('pagamentos.delete');