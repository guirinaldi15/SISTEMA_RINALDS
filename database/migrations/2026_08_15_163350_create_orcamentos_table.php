<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('atendimento_id')
                ->constrained('atendimentos')
                ->cascadeOnDelete();

            $table->string('numero', 20)
                ->unique();

            $table->date('validade')
                ->nullable();

            $table->integer('quantidade_convidados')
                ->nullable();

            $table->decimal('valor_locacao', 10, 2)
                ->default(0);

            $table->decimal('valor_adicionais', 10, 2)
                ->default(0);

            $table->decimal('desconto', 10, 2)
                ->default(0);

            $table->decimal('valor_total', 10, 2)
                ->default(0);

            $table->enum('status', [
                'rascunho',
                'enviado',
                'aceito',
                'recusado',
                'expirado'
            ])->default('rascunho');

            $table->text('observacoes')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};