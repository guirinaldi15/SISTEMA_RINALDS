<?php

use App\Livewire\Agenda\AgendaIndex;
use Illuminate\Support\Facades\Route;

use App\Livewire\Cliente\ClienteIndex;
use App\Livewire\Cliente\ClienteCreate;
use App\Livewire\Cliente\ClienteEdit;
use App\Livewire\Cliente\ClienteDelete;

use App\Livewire\Reserva\ReservaIndex;
use App\Livewire\Reserva\ReservaCreate;
use App\Livewire\Reserva\ReservaEdit;
use App\Livewire\Reserva\ReservaDelete;


// =============================
// INÍCIO
// =============================

Route::get('/', function () {
    return view('welcome');
});


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
    '/agenda',
    AgendaIndex::class
)->name('agenda.index');