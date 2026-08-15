<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\Atendimento;
use App\Models\Lembrete;

class DashboardIndex extends Component
{
    public function render()
    {
        /*
        |--------------------------------------------------------------------------
        | CLIENTES
        |--------------------------------------------------------------------------
        */

        $totalClientes = Cliente::count();

        $clientesNovosMes = Cliente::whereYear(
            'created_at',
            now()->year
        )
            ->whereMonth(
                'created_at',
                now()->month
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | ATENDIMENTOS
        |--------------------------------------------------------------------------
        */

        $atendimentosAtivos = Atendimento::whereNotIn(
            'status',
            [
                'fechado',
                'perdido'
            ]
        )->count();


        $novosAtendimentos = Atendimento::where(
            'status',
            'novo'
        )->count();


        $emNegociacao = Atendimento::where(
            'status',
            'negociacao'
        )->count();


        $aguardandoCliente = Atendimento::where(
            'status',
            'aguardando_cliente'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | LEMBRETES
        |--------------------------------------------------------------------------
        */

        $retornosHoje = Lembrete::with(
            'atendimento.cliente'
        )
            ->whereDate(
                'lembrar_em',
                today()
            )
            ->where(
                'status',
                'pendente'
            )
            ->orderBy('lembrar_em')
            ->get();


        $totalRetornosHoje =
            $retornosHoje->count();


        $lembretesAtrasados = Lembrete::with(
            'atendimento.cliente'
        )
            ->where(
                'lembrar_em',
                '<',
                now()
            )
            ->where(
                'status',
                'pendente'
            )
            ->orderBy('lembrar_em')
            ->get();


        $totalAtrasados =
            $lembretesAtrasados->count();


        /*
        |--------------------------------------------------------------------------
        | RESERVAS
        |--------------------------------------------------------------------------
        */

        $reservasMes = Reserva::whereYear(
            'data_evento',
            now()->year
        )
            ->whereMonth(
                'data_evento',
                now()->month
            )
            ->whereIn(
                'status',
                [
                    'pre_reserva',
                    'confirmada',
                    'realizada'
                ]
            )
            ->count();


        $reservasConfirmadas = Reserva::where(
            'status',
            'confirmada'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | PRÓXIMOS EVENTOS
        |--------------------------------------------------------------------------
        */

        $proximosEventos = Reserva::with('cliente')
            ->whereDate(
                'data_evento',
                '>=',
                today()
            )
            ->whereIn(
                'status',
                [
                    'pre_reserva',
                    'confirmada'
                ]
            )
            ->orderBy('data_evento')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PRÓXIMO EVENTO
        |--------------------------------------------------------------------------
        */

        $proximoEvento = Reserva::with('cliente')
            ->whereDate(
                'data_evento',
                '>=',
                today()
            )
            ->whereIn(
                'status',
                [
                    'pre_reserva',
                    'confirmada'
                ]
            )
            ->orderBy('data_evento')
            ->first();


        /*
        |--------------------------------------------------------------------------
        | FINANCEIRO BÁSICO
        |--------------------------------------------------------------------------
        |
        | Aqui ainda não temos tabela de pagamentos.
        | Portanto usamos o valor das reservas.
        |
        */

        $valorReservasMes = Reserva::whereYear(
            'data_evento',
            now()->year
        )
            ->whereMonth(
                'data_evento',
                now()->month
            )
            ->whereIn(
                'status',
                [
                    'confirmada',
                    'realizada'
                ]
            )
            ->sum('valor_total');


        /*
        |--------------------------------------------------------------------------
        | ATENDIMENTOS RECENTES
        |--------------------------------------------------------------------------
        */

        $atendimentosRecentes = Atendimento::with(
            'cliente'
        )
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CLIENTES RECENTES
        |--------------------------------------------------------------------------
        */

        $clientesRecentes = Cliente::orderByDesc(
            'created_at'
        )
            ->limit(5)
            ->get();


        return view(
            'livewire.dashboard.dashboard-index',
            compact(
                'totalClientes',
                'clientesNovosMes',
                'atendimentosAtivos',
                'novosAtendimentos',
                'emNegociacao',
                'aguardandoCliente',
                'retornosHoje',
                'totalRetornosHoje',
                'lembretesAtrasados',
                'totalAtrasados',
                'reservasMes',
                'reservasConfirmadas',
                'proximosEventos',
                'proximoEvento',
                'valorReservasMes',
                'atendimentosRecentes',
                'clientesRecentes'
            )
        );
    }
}