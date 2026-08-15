<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    protected $fillable = [
        'cliente_id',
        'origem',
        'tipo_evento',
        'data_evento',
        'status',
        'ultimo_contato',
        'observacoes',
        'motivo_perda',
    ];

    protected $casts = [
        'data_evento' => 'date',
        'ultimo_contato' => 'datetime',
    ];

   public function cliente()
{
    return $this->belongsTo(
        Cliente::class
    );
}

public function lembretes()
{
    return $this->hasMany(
        Lembrete::class
    );
}

public function reserva()
{
    return $this->hasOne(
        Reserva::class
    );
}
}