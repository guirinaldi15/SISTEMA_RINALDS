<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('espacos', function (Blueprint $table) {

            $table->id();

            $table->string('nome', 150);

            $table->text('descricao')->nullable();

            $table
                ->unsignedInteger('capacidade_maxima')
                ->nullable();

            $table
                ->unsignedInteger('quantidade_mesas')
                ->default(0);

            $table
                ->unsignedInteger('quantidade_cadeiras')
                ->default(0);

            $table
                ->string('tipo_cadeira', 100)
                ->nullable();

            $table
                ->boolean('possui_cozinha')
                ->default(false);

            $table
                ->boolean('possui_piscina')
                ->default(false);

            $table
                ->boolean('possui_churrasqueira')
                ->default(false);

            $table
                ->boolean('possui_bar_molhado')
                ->default(false);

            $table
                ->boolean('possui_ar_condicionado')
                ->default(false);

            $table
                ->boolean('possui_estacionamento')
                ->default(false);

            $table
                ->boolean('possui_wifi')
                ->default(false);

            $table
                ->boolean('possui_acomodacao')
                ->default(false);

            $table
                ->unsignedInteger('capacidade_hospedes')
                ->nullable();

            $table
                ->decimal(
                    'valor_base',
                    10,
                    2
                )
                ->nullable();

            $table
                ->text('itens_inclusos')
                ->nullable();

            $table
                ->text('itens_nao_inclusos')
                ->nullable();

            $table
                ->text('observacoes')
                ->nullable();

            $table
                ->boolean('ativo')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('espacos');
    }
};