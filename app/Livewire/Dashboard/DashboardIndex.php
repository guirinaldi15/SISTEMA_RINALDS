<?php

namespace App\Livewire\Dashboard;

use App\Models\Atendimento;
use App\Models\Cliente;
use App\Models\Espaco;
use App\Models\Lembrete;
use App\Models\Pagamento;
use App\Models\Reserva;
use Livewire\Component;

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

        $clientesNovosMes = Cliente::query()
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | ATENDIMENTOS
        |--------------------------------------------------------------------------
        */

        $atendimentosAtivos = Atendimento::query()
            ->whereNotIn('status', ['fechado', 'perdido'])
            ->count();

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

        $retornosHoje = Lembrete::with('atendimento.cliente')
            ->whereDate('lembrar_em', today())
            ->where('status', 'pendente')
            ->orderBy('lembrar_em')
            ->get();

        $totalRetornosHoje = $retornosHoje->count();

        $lembretesAtrasados = Lembrete::with(
            'atendimento.cliente'
        )
            ->where('lembrar_em', '<', now())
            ->where('status', 'pendente')
            ->orderBy('lembrar_em')
            ->get();

        $totalAtrasados = $lembretesAtrasados->count();

        /*
        |--------------------------------------------------------------------------
        | RESERVAS
        |--------------------------------------------------------------------------
        */

        $reservasMes = Reserva::query()
            ->whereYear('data_evento', now()->year)
            ->whereMonth('data_evento', now()->month)
            ->whereIn('status', [
                'pre_reserva',
                'confirmada',
                'realizada',
            ])
            ->count();

        $reservasConfirmadas = Reserva::where(
            'status',
            'confirmada'
        )->count();

        $proximosEventos = Reserva::with(['cliente', 'espaco'])
            ->whereDate('data_evento', '>=', today())
            ->whereIn('status', [
                'pre_reserva',
                'confirmada',
            ])
            ->orderBy('data_evento')
            ->limit(5)
            ->get();

        $proximoEvento = $proximosEventos->first();

        /*
        |--------------------------------------------------------------------------
        | FINANCEIRO - RECEBIDO NO MÊS
        |--------------------------------------------------------------------------
        */

        $recebidoMes = (float) Pagamento::query()
            ->where('status', 'pago')
            ->whereYear('data_pagamento', now()->year)
            ->whereMonth('data_pagamento', now()->month)
            ->sum('valor');

        /*
        |--------------------------------------------------------------------------
        | FINANCEIRO - PAGAMENTOS PENDENTES
        |--------------------------------------------------------------------------
        */

        $totalAReceber = (float) Pagamento::query()
            ->where('status', 'pendente')
            ->sum('valor');

        /*
        |--------------------------------------------------------------------------
        | FINANCEIRO - PAGAMENTOS ATRASADOS
        |--------------------------------------------------------------------------
        */

        $consultaAtrasados = Pagamento::query()
            ->where('status', 'pendente')
            ->whereDate('data_vencimento', '<', today());

        $valorAtrasado = (float) (clone $consultaAtrasados)
            ->sum('valor');

        $quantidadePagamentosAtrasados =
            (clone $consultaAtrasados)->count();

        /*
        |--------------------------------------------------------------------------
        | FINANCEIRO - RESERVAS VÁLIDAS
        |--------------------------------------------------------------------------
        |
        | Somente confirmadas e realizadas entram
        | no saldo devedor contratado.
        |
        */

        $reservasFinanceiras = Reserva::with([
            'pagamentos',
            'espaco',
        ])
            ->whereIn('status', [
                'confirmada',
                'realizada',
            ])
            ->get();

        $reservasQuitadas = $reservasFinanceiras
            ->filter(fn($reserva) => $reserva->quitada)
            ->count();

        $reservasComSaldoDevedor = $reservasFinanceiras
            ->filter(
                fn($reserva) =>
                $reserva->saldo_restante > 0
            )
            ->count();

        $saldoTotalReservas = round(
            $reservasFinanceiras->sum(
                fn($reserva) =>
                $reserva->saldo_restante
            ),
            2
        );

        /*
        |--------------------------------------------------------------------------
        | RESUMO FINANCEIRO POR ESPAÇO
        |--------------------------------------------------------------------------
        |
        | Primeiro criamos a coleção.
        | Depois adicionamos os espaços e reservas
        | que ainda estão sem espaço definido.
        |
        */

        $resumoEspacos = collect();

        $espacos = Espaco::query()
            ->orderBy('nome')
            ->get();

        foreach ($espacos as $espaco) {

            $reservasDoEspaco = $reservasFinanceiras
                ->where('espaco_id', $espaco->id);

            $recebido = $reservasDoEspaco->sum(
                fn($reserva) =>
                $reserva->pagamentos
                    ->where('status', 'pago')
                    ->sum('valor')
            );

            $saldo = $reservasDoEspaco->sum(
                fn($reserva) =>
                $reserva->saldo_restante
            );

            $resumoEspacos->push([
                'nome' => $espaco->nome,
                'reservas' => $reservasDoEspaco->count(),
                'recebido' => round((float) $recebido, 2),
                'saldo' => round((float) $saldo, 2),
                'sem_espaco' => false,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | RESERVAS SEM ESPAÇO
        |--------------------------------------------------------------------------
        */

        $reservasSemEspaco = $reservasFinanceiras
            ->filter(
                fn($reserva) =>
                $reserva->espaco_id === null
            );

        if ($reservasSemEspaco->isNotEmpty()) {

            $recebidoSemEspaco = $reservasSemEspaco->sum(
                fn($reserva) =>
                $reserva->pagamentos
                    ->where('status', 'pago')
                    ->sum('valor')
            );

            $saldoSemEspaco = $reservasSemEspaco->sum(
                fn($reserva) =>
                $reserva->saldo_restante
            );

            $resumoEspacos->push([
                'nome' => 'Sem espaço definido',
                'reservas' => $reservasSemEspaco->count(),
                'recebido' => round(
                    (float) $recebidoSemEspaco,
                    2
                ),
                'saldo' => round(
                    (float) $saldoSemEspaco,
                    2
                ),
                'sem_espaco' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FATURAMENTO DOS ÚLTIMOS 12 MESES
        |--------------------------------------------------------------------------
        */

        $inicioPeriodo = now()
            ->startOfMonth()
            ->subMonths(11);

        $pagamentosPeriodo = Pagamento::query()
            ->where('status', 'pago')
            ->whereNotNull('data_pagamento')
            ->whereDate(
                'data_pagamento',
                '>=',
                $inicioPeriodo->toDateString()
            )
            ->whereDate(
                'data_pagamento',
                '<=',
                today()->toDateString()
            )
            ->get(['valor', 'data_pagamento']);

        $faturamentoMensal = collect();

        for ($i = 0; $i < 12; $i++) {

            $data = $inicioPeriodo->copy()->addMonths($i);

            $totalMes = $pagamentosPeriodo
                ->filter(
                    fn($pagamento) =>
                    $pagamento->data_pagamento->year
                        === $data->year
                        &&
                        $pagamento->data_pagamento->month
                        === $data->month
                )
                ->sum('valor');

            $faturamentoMensal->push([
                'mes' => $data
                    ->locale('pt_BR')
                    ->translatedFormat('M/y'),
                'valor' => round((float) $totalMes, 2),
            ]);
        }

        $maiorFaturamento = max(
            1,
            (float) $faturamentoMensal->max('valor')
        );

        $totalPeriodo = round(
            $faturamentoMensal->sum('valor'),
            2
        );

        /*
        |--------------------------------------------------------------------------
        | PRÓXIMOS PAGAMENTOS
        |--------------------------------------------------------------------------
        */

        $proximosPagamentos = Pagamento::with(
            'reserva.cliente'
        )
            ->where('status', 'pendente')
            ->whereDate('data_vencimento', '>=', today())
            ->orderBy('data_vencimento')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PAGAMENTOS ATRASADOS
        |--------------------------------------------------------------------------
        */

        $pagamentosAtrasados = Pagamento::with(
            'reserva.cliente'
        )
            ->where('status', 'pendente')
            ->whereDate('data_vencimento', '<', today())
            ->orderBy('data_vencimento')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ATENDIMENTOS E CLIENTES RECENTES
        |--------------------------------------------------------------------------
        */

        $atendimentosRecentes = Atendimento::with('cliente')
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();

        $clientesRecentes = Cliente::query()
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ENVIAR DADOS PARA O BLADE
        |--------------------------------------------------------------------------
        */

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
                'reservasComSaldoDevedor',
                'saldoTotalReservas',
                'resumoEspacos',
                'faturamentoMensal',
                'maiorFaturamento',
                'totalPeriodo',
                'proximosPagamentos',
                'pagamentosAtrasados',
                'atendimentosRecentes',
                'clientesRecentes'
            )
        );
    }
}
