<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembrete extends Model
{
    protected $fillable = [
        'atendimento_id',
        'titulo',
        'descricao',
        'lembrar_em',
        'status',
        'concluido_em',
    ];

    protected $casts = [
        'lembrar_em' => 'datetime',
        'concluido_em' => 'datetime',
    ];

    public function atendimento()
    {
        return $this->belongsTo(Atendimento::class);
    }
}