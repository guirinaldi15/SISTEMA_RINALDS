<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nome',
        'telefone',
        'email',
        'cpf_cnpj',
        'cep',
        'cidade',
        'estado',
        'observacoes',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}