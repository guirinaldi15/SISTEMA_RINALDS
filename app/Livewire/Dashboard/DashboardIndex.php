<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\Atendimento;
use App\Models\Lembrete;
use App\Models\Pagamento;

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
        | FINANCEIRO - RECEBIDO NO MÊS
        |--------------------------------------------------------------------------
        */

        $recebidoMes = Pagamento::where(
            'status',
            'pago'
        )
        ->whereNotNull(
            'data_pagamento'
        )
        ->whereYear(
            'data_pagamento',
            now()->year
        )
        ->whereMonth(
            'data_pagamento',
            now()->month
        )
        ->sum('valor');


        /*
        |--------------------------------------------------------------------------
        | FINANCEIRO - TOTAL A RECEBER
        |--------------------------------------------------------------------------
        */

        $totalAReceber = Pagamento::where(
            'status',
            'pendente'
        )
        ->sum('valor');


        /*
        |--------------------------------------------------------------------------
        | FINANCEIRO - TOTAL ATRASADO
        |--------------------------------------------------------------------------
        */

        $valorAtrasado = Pagamento::where(
            'status',
            'pendente'
        )
        ->whereDate(
            'data_vencimento',
            '<',
            today()
        )
        ->sum('valor');


        /*
        |--------------------------------------------------------------------------
        | QUANTIDADE DE PAGAMENTOS ATRASADOS
        |--------------------------------------------------------------------------
        */

        $quantidadePagamentosAtrasados =
            Pagamento::where(
                'status',
                'pendente'
            )
            ->whereDate(
                'data_vencimento',
                '<',
                today()
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RESERVAS QUITADAS
        |--------------------------------------------------------------------------
        |
        | Carregamos os pagamentos e calculamos usando os accessors
        | do model Reserva.
        |
        */

        $reservasFinanceiras = Reserva::with('pagamentos')
            ->whereIn(
                'status',
                [
                    'confirmada',
                    'realizada'
                ]
            )
            ->get();


        $reservasQuitadas =
            $reservasFinanceiras
                ->filter(function ($reserva) {
                    return $reserva->quitada;
                })
                ->count();


        /*
        |--------------------------------------------------------------------------
        | PRÓXIMOS PAGAMENTOS
        |--------------------------------------------------------------------------
        */

        $proximosPagamentos = Pagamento::with([
            'reserva.cliente'
        ])
        ->where(
            'status',
            'pendente'
        )
        ->whereDate(
            'data_vencimento',
            '>=',
            today()
        )
        ->orderBy(
            'data_vencimento'
        )
        ->limit(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | PAGAMENTOS ATRASADOS
        |--------------------------------------------------------------------------
        */

        $pagamentosAtrasados = Pagamento::with([
            'reserva.cliente'
        ])
        ->where(
            'status',
            'pendente'
        )
        ->whereDate(
            'data_vencimento',
            '<',
            today()
        )
        ->orderBy(
            'data_vencimento'
        )
        ->limit(5)
        ->get();


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
                'proximoEvento',
                'proximosEventos',

                'recebidoMes',
                'totalAReceber',
                'valorAtrasado',
                'quantidadePagamentosAtrasados',
                'reservasQuitadas',

                'proximosPagamentos',
                'pagamentosAtrasados',

                'atendimentosRecentes',
                'clientesRecentes'
            )
        );
    }
}