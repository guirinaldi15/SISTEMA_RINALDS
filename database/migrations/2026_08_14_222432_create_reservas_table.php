<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->cascadeOnDelete();

            $table->date('data_evento');

            $table->string('tipo_evento', 100);

            $table->integer('quantidade_convidados')
                ->nullable();

            $table->time('horario_inicio')
                ->nullable();

            $table->time('horario_fim')
                ->nullable();

            $table->decimal('valor_total', 10, 2)
                ->nullable();

            $table->enum('status', [
                'pre_reserva',
                'confirmada',
                'cancelada',
                'realizada'
            ])->default('pre_reserva');

            $table->text('observacoes')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};