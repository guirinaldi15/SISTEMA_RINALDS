<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    protected $fillable = [
        'atendimento_id',
        'espaco_id',
        'numero',
        'validade',
        'quantidade_convidados',
        'valor_locacao',
        'valor_adicionais',
        'desconto',
        'valor_total',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'validade' => 'date',

        'valor_locacao' => 'decimal:2',
        'valor_adicionais' => 'decimal:2',
        'desconto' => 'decimal:2',
        'valor_total' => 'decimal:2',
    ];

    public function atendimento()
    {
        return $this->belongsTo(
            Atendimento::class
        );
    }

    public function espaco()
    {
        return $this->belongsTo(
            Espaco::class
        );
    }
}