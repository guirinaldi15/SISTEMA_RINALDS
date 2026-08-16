<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espaco extends Model
{
    use HasFactory;

    protected $table = 'espacos';

    protected $fillable = [
        'nome',
        'descricao',
        'capacidade_maxima',
        'quantidade_mesas',
        'quantidade_cadeiras',
        'tipo_cadeira',

        'possui_cozinha',
        'possui_piscina',
        'possui_churrasqueira',
        'possui_bar_molhado',
        'possui_ar_condicionado',
        'possui_estacionamento',
        'possui_wifi',
        'possui_acomodacao',

        'capacidade_hospedes',

        'valor_base',

        'itens_inclusos',
        'itens_nao_inclusos',
        'observacoes',

        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'possui_cozinha' => 'boolean',
            'possui_piscina' => 'boolean',
            'possui_churrasqueira' => 'boolean',
            'possui_bar_molhado' => 'boolean',
            'possui_ar_condicionado' => 'boolean',
            'possui_estacionamento' => 'boolean',
            'possui_wifi' => 'boolean',
            'possui_acomodacao' => 'boolean',
            'ativo' => 'boolean',

            'valor_base' => 'decimal:2',
        ];
    }
}