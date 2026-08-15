<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lembretes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('atendimento_id')
                ->constrained('atendimentos')
                ->cascadeOnDelete();

            $table->string('titulo', 150);

            $table->text('descricao')
                ->nullable();

            $table->dateTime('lembrar_em');

            $table->enum('status', [
                'pendente',
                'concluido',
                'cancelado'
            ])->default('pendente');

            $table->dateTime('concluido_em')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lembretes');
    }
};