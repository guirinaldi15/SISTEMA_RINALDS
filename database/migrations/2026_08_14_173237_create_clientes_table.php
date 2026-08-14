<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            $table->string('nome', 150);
            $table->string('telefone', 20);
            $table->string('email', 150)->nullable();
            $table->string('cpf_cnpj', 20)->nullable();

            $table->string('cep', 9)->nullable();

            $table->string('cidade', 100)->nullable();
            $table->string('estado', 2)->nullable();

            $table->text('observacoes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};