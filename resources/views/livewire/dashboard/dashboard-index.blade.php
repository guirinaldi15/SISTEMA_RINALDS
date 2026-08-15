<div class="container-fluid py-4 px-4">

    {{-- ========================================================= --}}
    {{-- CABEÇALHO --}}
    {{-- ========================================================= --}}

    <div
        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
    >

        <div>

            <h2 class="fw-bold mb-1">
                Dashboard
            </h2>

            <p class="text-muted mb-0">
                Visão geral da Chácara Rinald's
            </p>

        </div>


        <div class="d-flex gap-2">

            <a
                href="{{ route('atendimentos.create') }}"
                class="btn btn-outline-success"
            >
                + Atendimento
            </a>

            <a
                href="{{ route('reservas.create') }}"
                class="btn btn-success"
            >
                + Nova Reserva
            </a>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ALERTA DE LEMBRETES ATRASADOS --}}
    {{-- ========================================================= --}}

    @if($totalAtrasados > 0)

        <div
            class="alert alert-danger d-flex justify-content-between align-items-center"
        >

            <div>

                <strong>
                    ⚠️ Você tem {{ $totalAtrasados }}
                    {{ $totalAtrasados == 1 ? 'retorno atrasado' : 'retornos atrasados' }}
                </strong>

                <div class="small">
                    Existem clientes aguardando seu retorno.
                </div>

            </div>

            <a
                href="{{ route('lembretes.index') }}"
                class="btn btn-danger btn-sm"
            >
                Ver lembretes
            </a>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- CARDS PRINCIPAIS --}}
    {{-- ========================================================= --}}

    <div class="row g-3 mb-4">


        {{-- Clientes --}}
        <div class="col-12 col-sm-6 col-xl">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div
                        class="d-flex justify-content-between align-items-start"
                    >

                        <div>

                            <small
                                class="text-muted text-uppercase fw-semibold"
                            >
                                Clientes
                            </small>

                            <h2 class="fw-bold mt-2 mb-1">
                                {{ $totalClientes }}
                            </h2>

                            <small class="text-success">

                                +{{ $clientesNovosMes }}
                                neste mês

                            </small>

                        </div>

                        <span class="fs-3">
                            👥
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- Atendimentos --}}
        <div class="col-12 col-sm-6 col-xl">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div
                        class="d-flex justify-content-between align-items-start"
                    >

                        <div>

                            <small
                                class="text-muted text-uppercase fw-semibold"
                            >
                                Atendimentos ativos
                            </small>

                            <h2 class="fw-bold mt-2 mb-1">
                                {{ $atendimentosAtivos }}
                            </h2>

                            <small class="text-muted">

                                {{ $novosAtendimentos }}
                                novos

                            </small>

                        </div>

                        <span class="fs-3">
                            💬
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- Retornos --}}
        <div class="col-12 col-sm-6 col-xl">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div
                        class="d-flex justify-content-between align-items-start"
                    >

                        <div>

                            <small
                                class="text-muted text-uppercase fw-semibold"
                            >
                                Retornos hoje
                            </small>

                            <h2 class="fw-bold mt-2 mb-1">
                                {{ $totalRetornosHoje }}
                            </h2>

                            @if($totalAtrasados > 0)

                                <small class="text-danger">

                                    {{ $totalAtrasados }}
                                    atrasados

                                </small>

                            @else

                                <small class="text-success">
                                    Nenhum atrasado
                                </small>

                            @endif

                        </div>

                        <span class="fs-3">
                            🔔
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- Reservas --}}
        <div class="col-12 col-sm-6 col-xl">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div
                        class="d-flex justify-content-between align-items-start"
                    >

                        <div>

                            <small
                                class="text-muted text-uppercase fw-semibold"
                            >
                                Reservas no mês
                            </small>

                            <h2 class="fw-bold mt-2 mb-1">
                                {{ $reservasMes }}
                            </h2>

                            <small class="text-muted">

                                {{ $reservasConfirmadas }}
                                confirmadas

                            </small>

                        </div>

                        <span class="fs-3">
                            📅
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- Valor --}}
        <div class="col-12 col-sm-6 col-xl">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div
                        class="d-flex justify-content-between align-items-start"
                    >

                        <div>

                            <small
                                class="text-muted text-uppercase fw-semibold"
                            >
                                Valor do mês
                            </small>

                            <h4 class="fw-bold mt-2 mb-1">

                                R$

                                {{ number_format(
                                    $valorReservasMes,
                                    2,
                                    ',',
                                    '.'
                                ) }}

                            </h4>

                            <small class="text-muted">
                                Reservas confirmadas
                            </small>

                        </div>

                        <span class="fs-3">
                            💰
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- RETORNOS + PRÓXIMO EVENTO --}}
    {{-- ========================================================= --}}

    <div class="row g-4 mb-4">


        {{-- RETORNOS DE HOJE --}}

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm h-100">

                <div
                    class="card-header bg-white border-0 pt-4 px-4"
                >

                    <div
                        class="d-flex justify-content-between align-items-center"
                    >

                        <div>

                            <h5 class="fw-bold mb-1">
                                🔔 Retornos de hoje
                            </h5>

                            <small class="text-muted">
                                Clientes que precisam de atendimento
                            </small>

                        </div>

                        <a
                            href="{{ route('lembretes.index') }}"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            Ver todos
                        </a>

                    </div>

                </div>


                <div class="card-body px-4">

                    @forelse($retornosHoje as $lembrete)

                        @php

                            $telefone = preg_replace(
                                '/\D/',
                                '',
                                $lembrete
                                    ->atendimento
                                    ->cliente
                                    ->telefone
                            );

                        @endphp


                        <div
                            class="d-flex justify-content-between align-items-center border-bottom py-3"
                        >

                            <div>

                                <div class="fw-semibold">

                                    {{ $lembrete
                                        ->atendimento
                                        ->cliente
                                        ->nome }}

                                </div>


                                <small class="text-muted">

                                    {{ $lembrete->titulo }}

                                </small>


                                @if($lembrete->descricao)

                                    <div>

                                        <small class="text-muted">

                                            {{ \Illuminate\Support\Str::limit(
                                                $lembrete->descricao,
                                                70
                                            ) }}

                                        </small>

                                    </div>

                                @endif

                            </div>


                            <div
                                class="d-flex align-items-center gap-3"
                            >

                                <span class="fw-bold">

                                    {{ $lembrete
                                        ->lembrar_em
                                        ->format('H:i') }}

                                </span>


                                <a
                                    href="https://wa.me/55{{ $telefone }}"
                                    target="_blank"
                                    class="btn btn-sm btn-success"
                                >
                                    WhatsApp
                                </a>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-5">

                            <div class="fs-2 mb-2">
                                ✅
                            </div>

                            <div class="fw-semibold">
                                Nenhum retorno para hoje
                            </div>

                            <small class="text-muted">
                                Seus atendimentos estão em dia.
                            </small>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- PRÓXIMO EVENTO --}}

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold">
                        🎉 Próximo evento
                    </h5>

                    <hr>

                    @if($proximoEvento)

                        <div class="text-center py-3">

                            <div
                                class="display-5 fw-bold text-success"
                            >
                                {{ $proximoEvento
                                    ->data_evento
                                    ->format('d') }}
                            </div>

                            <div
                                class="text-uppercase text-muted"
                            >

                                {{ $proximoEvento
                                    ->data_evento
                                    ->locale('pt_BR')
                                    ->translatedFormat('F Y') }}

                            </div>

                        </div>


                        <div class="mb-2">

                            <small class="text-muted">
                                Evento
                            </small>

                            <div class="fw-semibold">
                                {{ $proximoEvento->tipo_evento }}
                            </div>

                        </div>


                        <div class="mb-2">

                            <small class="text-muted">
                                Cliente
                            </small>

                            <div class="fw-semibold">
                                {{ $proximoEvento->cliente->nome }}
                            </div>

                        </div>


                        @if($proximoEvento->quantidade_convidados)

                            <div class="mb-2">

                                <small class="text-muted">
                                    Convidados
                                </small>

                                <div class="fw-semibold">
                                    {{ $proximoEvento->quantidade_convidados }}
                                </div>

                            </div>

                        @endif


                        <div class="mb-3">

                            <small class="text-muted">
                                Status
                            </small>

                            <div>

                                @if(
                                    $proximoEvento->status
                                    === 'confirmada'
                                )

                                    <span class="badge bg-success">
                                        Confirmada
                                    </span>

                                @else

                                    <span
                                        class="badge bg-warning text-dark"
                                    >
                                        Pré-reserva
                                    </span>

                                @endif

                            </div>

                        </div>


                        <a
                            href="{{ route('agenda.index') }}"
                            class="btn btn-outline-success w-100"
                        >
                            Abrir Agenda
                        </a>

                    @else

                        <div class="text-center py-5">

                            <div class="fs-2">
                                📅
                            </div>

                            <p class="text-muted mt-2">
                                Nenhum próximo evento.
                            </p>

                            <a
                                href="{{ route('reservas.create') }}"
                                class="btn btn-success"
                            >
                                Nova Reserva
                            </a>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ATENDIMENTOS --}}
    {{-- ========================================================= --}}

    <div class="row g-4 mb-4">


        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                <div
                    class="card-header bg-white border-0 pt-4 px-4"
                >

                    <div
                        class="d-flex justify-content-between align-items-center"
                    >

                        <div>

                            <h5 class="fw-bold mb-1">
                                💬 Atendimentos recentes
                            </h5>

                            <small class="text-muted">
                                Últimos contatos atualizados
                            </small>

                        </div>

                        <a
                            href="{{ route('atendimentos.index') }}"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            Ver todos
                        </a>

                    </div>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>

                                <tr>
                                    <th>Cliente</th>
                                    <th>Evento</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse(
                                    $atendimentosRecentes
                                    as $atendimento
                                )

                                    <tr>

                                        <td>

                                            <div class="fw-semibold">
                                                {{ $atendimento
                                                    ->cliente
                                                    ->nome }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $atendimento
                                                    ->cliente
                                                    ->telefone }}
                                            </small>

                                        </td>


                                        <td>

                                            {{ $atendimento
                                                ->tipo_evento
                                                ?? '-' }}

                                        </td>


                                        <td>

                                            @switch($atendimento->status)

                                                @case('novo')

                                                    <span
                                                        class="badge bg-primary"
                                                    >
                                                        Novo
                                                    </span>

                                                @break


                                                @case('aguardando_data')

                                                    <span
                                                        class="badge bg-info text-dark"
                                                    >
                                                        Aguardando data
                                                    </span>

                                                @break


                                                @case('orcamento_enviado')

                                                    <span
                                                        class="badge bg-warning text-dark"
                                                    >
                                                        Orçamento enviado
                                                    </span>

                                                @break


                                                @case('aguardando_cliente')

                                                    <span
                                                        class="badge bg-warning text-dark"
                                                    >
                                                        Aguardando cliente
                                                    </span>

                                                @break


                                                @case('negociacao')

                                                    <span
                                                        class="badge bg-secondary"
                                                    >
                                                        Negociação
                                                    </span>

                                                @break


                                                @case('fechado')

                                                    <span
                                                        class="badge bg-success"
                                                    >
                                                        Fechado
                                                    </span>

                                                @break


                                                @case('perdido')

                                                    <span
                                                        class="badge bg-danger"
                                                    >
                                                        Perdido
                                                    </span>

                                                @break

                                            @endswitch

                                        </td>


                                        <td class="text-end">

                                            <a
                                                href="{{ route(
                                                    'atendimentos.edit',
                                                    $atendimento->id
                                                ) }}"
                                                class="btn btn-sm btn-outline-primary"
                                            >
                                                Abrir
                                            </a>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="4"
                                            class="text-center text-muted py-4"
                                        >
                                            Nenhum atendimento.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        {{-- FUNIL --}}

        <div class="col-lg-5">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        📊 Funil de atendimento
                    </h5>


                    <div class="mb-4">

                        <div
                            class="d-flex justify-content-between mb-2"
                        >
                            <span>
                                Novos
                            </span>

                            <strong>
                                {{ $novosAtendimentos }}
                            </strong>
                        </div>

                        <div
                            class="progress"
                            style="height: 8px;"
                        >

                            <div
                                class="progress-bar"
                                style="width:
                                {{
                                    $atendimentosAtivos > 0
                                    ? ($novosAtendimentos
                                        / $atendimentosAtivos)
                                        * 100
                                    : 0
                                }}%"
                            >
                            </div>

                        </div>

                    </div>


                    <div class="mb-4">

                        <div
                            class="d-flex justify-content-between mb-2"
                        >
                            <span>
                                Aguardando cliente
                            </span>

                            <strong>
                                {{ $aguardandoCliente }}
                            </strong>
                        </div>

                        <div
                            class="progress"
                            style="height: 8px;"
                        >

                            <div
                                class="progress-bar bg-warning"
                                style="width:
                                {{
                                    $atendimentosAtivos > 0
                                    ? ($aguardandoCliente
                                        / $atendimentosAtivos)
                                        * 100
                                    : 0
                                }}%"
                            >
                            </div>

                        </div>

                    </div>


                    <div class="mb-4">

                        <div
                            class="d-flex justify-content-between mb-2"
                        >
                            <span>
                                Em negociação
                            </span>

                            <strong>
                                {{ $emNegociacao }}
                            </strong>
                        </div>

                        <div
                            class="progress"
                            style="height: 8px;"
                        >

                            <div
                                class="progress-bar bg-success"
                                style="width:
                                {{
                                    $atendimentosAtivos > 0
                                    ? ($emNegociacao
                                        / $atendimentosAtivos)
                                        * 100
                                    : 0
                                }}%"
                            >
                            </div>

                        </div>

                    </div>


                    <a
                        href="{{ route('atendimentos.index') }}"
                        class="btn btn-outline-secondary w-100"
                    >
                        Ver funil completo
                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PRÓXIMOS EVENTOS --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-sm mb-4">

        <div
            class="card-header bg-white border-0 pt-4 px-4"
        >

            <div
                class="d-flex justify-content-between align-items-center"
            >

                <div>

                    <h5 class="fw-bold mb-1">
                        📅 Próximos eventos
                    </h5>

                    <small class="text-muted">
                        Próximas datas reservadas
                    </small>

                </div>

                <a
                    href="{{ route('agenda.index') }}"
                    class="btn btn-sm btn-outline-secondary"
                >
                    Ver agenda
                </a>

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Evento</th>
                            <th>Convidados</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($proximosEventos as $reserva)

                            <tr>

                                <td class="fw-semibold">

                                    {{ $reserva
                                        ->data_evento
                                        ->format('d/m/Y') }}

                                </td>


                                <td>
                                    {{ $reserva->cliente->nome }}
                                </td>


                                <td>
                                    {{ $reserva->tipo_evento }}
                                </td>


                                <td>
                                    {{ $reserva
                                        ->quantidade_convidados
                                        ?? '-' }}
                                </td>


                                <td>

                                    @if($reserva->valor_total)

                                        R$

                                        {{ number_format(
                                            $reserva->valor_total,
                                            2,
                                            ',',
                                            '.'
                                        ) }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    @if(
                                        $reserva->status
                                        === 'confirmada'
                                    )

                                        <span
                                            class="badge bg-success"
                                        >
                                            Confirmada
                                        </span>

                                    @else

                                        <span
                                            class="badge bg-warning text-dark"
                                        >
                                            Pré-reserva
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center text-muted py-4"
                                >
                                    Nenhum próximo evento.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ACESSO RÁPIDO --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">
                Acesso rápido
            </h5>


            <div class="row g-3">

                <div class="col-md-3">

                    <a
                        href="{{ route('clientes.index') }}"
                        class="btn btn-outline-secondary w-100 py-3"
                    >
                        👥 Clientes
                    </a>

                </div>


                <div class="col-md-3">

                    <a
                        href="{{ route('atendimentos.index') }}"
                        class="btn btn-outline-secondary w-100 py-3"
                    >
                        💬 Atendimentos
                    </a>

                </div>


                <div class="col-md-3">

                    <a
                        href="{{ route('agenda.index') }}"
                        class="btn btn-outline-secondary w-100 py-3"
                    >
                        📅 Agenda
                    </a>

                </div>


                <div class="col-md-3">

                    <a
                        href="{{ route('lembretes.index') }}"
                        class="btn btn-outline-secondary w-100 py-3"
                    >
                        🔔 Lembretes
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>