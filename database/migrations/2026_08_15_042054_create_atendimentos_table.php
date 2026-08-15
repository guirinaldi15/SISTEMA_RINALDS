<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->cascadeOnDelete();

            $table->string('origem', 50)
                ->default('WhatsApp');

            $table->string('tipo_evento', 100)
                ->nullable();

            $table->date('data_evento')
                ->nullable();

            $table->enum('status', [
                'novo',
                'aguardando_data',
                'orcamento_enviado',
                'aguardando_cliente',
                'negociacao',
                'fechado',
                'perdido'
            ])->default('novo');

            $table->dateTime('ultimo_contato')
                ->nullable();

            $table->text('observacoes')
                ->nullable();

            $table->text('motivo_perda')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atendimentos');
    }
};