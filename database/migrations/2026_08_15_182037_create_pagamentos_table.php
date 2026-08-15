<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reserva_id')
                ->constrained('reservas')
                ->cascadeOnDelete();

            $table->string('descricao', 150);

            $table->decimal('valor', 10, 2);

            $table->date('data_vencimento');

            $table->date('data_pagamento')
                ->nullable();

            $table->enum('forma_pagamento', [
                'pix',
                'dinheiro',
                'cartao_credito',
                'cartao_debito',
                'transferencia',
                'boleto',
                'outro'
            ])->nullable();

            $table->enum('status', [
                'pendente',
                'pago',
                'cancelado'
            ])->default('pendente');

            $table->text('observacoes')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};