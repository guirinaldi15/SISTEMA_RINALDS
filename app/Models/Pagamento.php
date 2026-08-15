<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable = [
        'reserva_id',
        'descricao',
        'valor',
        'data_vencimento',
        'data_pagamento',
        'forma_pagamento',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
    ];

    public function reserva()
    {
        return $this->belongsTo(
            Reserva::class
        );
    }

    public function getAtrasadoAttribute()
    {
        return
            $this->status === 'pendente'
            && $this->data_vencimento
            && $this->data_vencimento->isPast();
    }
}