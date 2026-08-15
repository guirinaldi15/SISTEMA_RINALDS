<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'cliente_id',
        'atendimento_id',
        'data_evento',
        'tipo_evento',
        'quantidade_convidados',
        'horario_inicio',
        'horario_fim',
        'valor_total',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'data_evento' => 'date',
        'valor_total' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(
            Cliente::class
        );
    }

    public function atendimento()
    {
        return $this->belongsTo(
            Atendimento::class
        );
    }
}