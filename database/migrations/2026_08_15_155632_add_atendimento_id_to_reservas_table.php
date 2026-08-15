<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservas', function (Blueprint $table) {

            $table->foreignId('atendimento_id')
                ->nullable()
                ->after('cliente_id')
                ->constrained('atendimentos')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {

            $table->dropForeign([
                'atendimento_id'
            ]);

            $table->dropColumn(
                'atendimento_id'
            );

        });
    }
};