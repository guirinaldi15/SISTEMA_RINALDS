<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Cliente\ClienteIndex;
use App\Livewire\Cliente\ClienteCreate;
use App\Livewire\Cliente\ClienteEdit;
use App\Livewire\Cliente\ClienteDelete;


// Página inicial
Route::get('/', function () {
    return view('welcome');
});


// =============================
// CLIENTES
// =============================

// Listar clientes
Route::get('/clientes', ClienteIndex::class)
    ->name('clientes.index');


// Cadastrar cliente
Route::get('/clientes/novo', ClienteCreate::class)
    ->name('clientes.create');


// Editar cliente
Route::get('/clientes/{id}/editar', ClienteEdit::class)
    ->name('clientes.edit');


// Excluir cliente
Route::get('/clientes/{id}/excluir', ClienteDelete::class)
    ->name('clientes.delete');