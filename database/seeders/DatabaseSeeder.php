<?php

namespace Database\Seeders;

use App\Models\Espaco;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
 public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ESPAÇO 1 - SALÃO SOCIAL
        |--------------------------------------------------------------------------
        */

        Espaco::firstOrCreate(
            [
                'nome' => 'Salão Social',
            ],
            [
                'descricao' => 'Salão para festas, casamentos, aniversários, formaturas e eventos.',
                'capacidade_maxima' => 200,
                'quantidade_mesas' => 22,
                'quantidade_cadeiras' => 150,
                'tipo_cadeira' => 'Tiffany',

                'possui_cozinha' => true,
                'possui_piscina' => false,
                'possui_churrasqueira' => false,
                'possui_bar_molhado' => false,
                'possui_ar_condicionado' => true,
                'possui_estacionamento' => true,
                'possui_wifi' => false,
                'possui_acomodacao' => false,

                'capacidade_hospedes' => null,
                'valor_base' => 0,
                'itens_inclusos' => '150 cadeiras Tiffany, 22 mesas, ar-condicionado, cozinha e estacionamento.',
                'itens_nao_inclusos' => null,
                'observacoes' => null,
                'ativo' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ESPAÇO 2 - REFÚGIO RINALD'S
        |--------------------------------------------------------------------------
        */

        Espaco::firstOrCreate(
            [
                'nome' => "Refúgio Rinald's",
            ],
            [
                'descricao' => 'Espaço para eventos com piscina, churrasqueira, bar molhado e acomodações.',
                'capacidade_maxima' => 250,
                'quantidade_mesas' => null,
                'quantidade_cadeiras' => null,
                'tipo_cadeira' => null,

                'possui_cozinha' => false,
                'possui_piscina' => true,
                'possui_churrasqueira' => true,
                'possui_bar_molhado' => true,
                'possui_ar_condicionado' => false,
                'possui_estacionamento' => false,
                'possui_wifi' => false,
                'possui_acomodacao' => true,

                'capacidade_hospedes' => 8,
                'valor_base' => 0,
                'itens_inclusos' => 'Piscina, churrasqueira, bar molhado e acomodação para até 8 hóspedes.',
                'itens_nao_inclusos' => null,
                'observacoes' => null,
                'ativo' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | USUÁRIO ADMINISTRADOR INICIAL
        |--------------------------------------------------------------------------
        |
        | Configure ADMIN_EMAIL e ADMIN_PASSWORD no .env.
        | Se o e-mail já existir, não altera o usuário.
        |
        */

        $email = env('ADMIN_EMAIL');
        $senha = env('ADMIN_PASSWORD');

        if ($email && $senha) {

            User::firstOrCreate(
                [
                    'email' => strtolower(trim($email)),
                ],
                [
                    'name' => 'Administrador',
                    'password' => $senha,
                    'perfil' => 'administrador',
                    'ativo' => true,
                ]
            );

            $this->command->info(
                'Administrador inicial verificado com sucesso.'
            );

        } else {

            $this->command->warn(
                'Administrador não criado: configure ADMIN_EMAIL e ADMIN_PASSWORD no .env.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FINALIZAÇÃO
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            "Espaços da Chácara Rinald's cadastrados/verificados!"
        );
    }
}
