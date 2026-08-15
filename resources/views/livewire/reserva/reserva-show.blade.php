<div class="container-fluid py-4 px-4">

    {{-- ====================================================== --}}
    {{-- CABEÇALHO --}}
    {{-- ====================================================== --}}

    <div
        class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4"
    >

        <div>

            <a
                href="{{ route('reservas.index') }}"
                class="text-decoration-none"
            >
                ← Voltar para Reservas
            </a>


            <h2 class="fw-bold mt-3 mb-1">

                {{ $reserva->tipo_evento }}

                -

                {{ $reserva->cliente->nome }}

            </h2>


            <p class="text-muted mb-0">

                {{ $reserva
                    ->data_evento
                    ->format('d/m/Y') }}

            </p>

        </div>


        <div class="d-flex gap-2 flex-wrap">

            {{-- CLIENTE --}}
            <a
                href="{{ route(
                    'clientes.show',
                    $reserva->cliente->id
                ) }}"
                class="btn btn-outline-secondary"
            >
                👤 Cliente
            </a>


            {{-- NOVO PAGAMENTO --}}
            @if(
                $reserva->status
                !== 'cancelada'
            )

                <a
                    href="{{ route(
                        'pagamentos.create',
                        [
                            'reserva' =>
                                $reserva->id
                        ]
                    ) }}"
                    class="btn btn-success"
                >
                    💳 Novo Pagamento
                </a>

            @endif


            {{-- EDITAR --}}
            <a
                href="{{ route(
                    'reservas.edit',
                    $reserva->id
                ) }}"
                class="btn btn-outline-primary"
            >
                ✏️ Editar Reserva
            </a>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- STATUS --}}
    {{-- ====================================================== --}}

    <div class="mb-4">

        @switch($reserva->status)

            @case('pre_reserva')

                <span
                    class="badge bg-warning text-dark fs-6"
                >
                    Pré-reserva
                </span>

            @break


            @case('confirmada')

                <span
                    class="badge bg-success fs-6"
                >
                    Confirmada
                </span>

            @break


            @case('cancelada')

                <span
                    class="badge bg-danger fs-6"
                >
                    Cancelada
                </span>

            @break


            @case('realizada')

                <span
                    class="badge bg-secondary fs-6"
                >
                    Realizada
                </span>

            @break

        @endswitch

    </div>


    {{-- ====================================================== --}}
    {{-- CARDS FINANCEIROS --}}
    {{-- ====================================================== --}}

    <div class="row g-3 mb-4">


        {{-- VALOR TOTAL --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small
                        class="text-muted text-uppercase fw-semibold"
                    >
                        Valor da Reserva
                    </small>


                    <h3 class="fw-bold mt-2 mb-0">

                        R$

                        {{ number_format(
                            (float) $reserva->valor_total,
                            2,
                            ',',
                            '.'
                        ) }}

                    </h3>

                </div>

            </div>

        </div>


        {{-- TOTAL PAGO --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small
                        class="text-muted text-uppercase fw-semibold"
                    >
                        Total Recebido
                    </small>


                    <h3
                        class="fw-bold text-success mt-2 mb-0"
                    >

                        R$

                        {{ number_format(
                            $totalPago,
                            2,
                            ',',
                            '.'
                        ) }}

                    </h3>

                </div>

            </div>

        </div>


        {{-- SALDO --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small
                        class="text-muted text-uppercase fw-semibold"
                    >
                        Saldo Restante
                    </small>


                    <h3
                        class="fw-bold
                        {{
                            $saldoRestante > 0
                            ? 'text-danger'
                            : 'text-success'
                        }}
                        mt-2 mb-0"
                    >

                        R$

                        {{ number_format(
                            $saldoRestante,
                            2,
                            ',',
                            '.'
                        ) }}

                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- SITUAÇÃO FINANCEIRA --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <div
                class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3"
            >

                <div>

                    <h5 class="fw-bold mb-1">
                        Situação Financeira
                    </h5>

                    <small class="text-muted">
                        Acompanhamento do pagamento da reserva
                    </small>

                </div>


                <div>

                    @switch(
                        $situacaoFinanceira
                    )

                        @case('quitada')

                            <span
                                class="badge bg-success fs-6"
                            >
                                ✅ Quitada
                            </span>

                        @break


                        @case('atrasada')

                            <span
                                class="badge bg-danger fs-6"
                            >
                                🔴 Possui pagamento atrasado
                            </span>

                        @break


                        @case('parcial')

                            <span
                                class="badge bg-warning text-dark fs-6"
                            >
                                🟡 Parcialmente paga
                            </span>

                        @break


                        @case('pendente')

                            <span
                                class="badge bg-secondary fs-6"
                            >
                                ⚪ Nenhum pagamento
                            </span>

                        @break


                        @default

                            <span
                                class="badge bg-secondary fs-6"
                            >
                                Valor não informado
                            </span>

                    @endswitch

                </div>

            </div>


            <div
                class="d-flex justify-content-between mb-2"
            >

                <span>
                    Progresso
                </span>

                <strong>
                    {{ number_format(
                        $percentualPago,
                        0,
                        ',',
                        '.'
                    ) }}%
                </strong>

            </div>


            <div
                class="progress"
                style="height: 14px;"
            >

                <div
                    class="progress-bar bg-success"
                    role="progressbar"
                    style="
                        width:
                        {{ $percentualPago }}%;
                    "
                    aria-valuenow="{{ $percentualPago }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                >
                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- DADOS DA RESERVA --}}
    {{-- ====================================================== --}}

    <div class="row g-4 mb-4">


        {{-- EVENTO --}}
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        🎉 Dados do Evento
                    </h5>


                    <div class="row g-4">


                        <div class="col-md-6">

                            <small class="text-muted">
                                Cliente
                            </small>

                            <div class="fw-semibold">

                                {{ $reserva
                                    ->cliente
                                    ->nome }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Telefone
                            </small>

                            <div class="fw-semibold">

                                {{ $reserva
                                    ->cliente
                                    ->telefone }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Tipo do evento
                            </small>

                            <div class="fw-semibold">

                                {{ $reserva
                                    ->tipo_evento }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Data
                            </small>

                            <div class="fw-semibold">

                                {{ $reserva
                                    ->data_evento
                                    ->format('d/m/Y') }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Convidados
                            </small>

                            <div class="fw-semibold">

                                {{ $reserva
                                    ->quantidade_convidados
                                    ?? 'Não informado' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Horário de início
                            </small>

                            <div class="fw-semibold">

                                @if(
                                    $reserva->horario_inicio
                                )

                                    {{ substr(
                                        $reserva
                                            ->horario_inicio,
                                        0,
                                        5
                                    ) }}

                                @else

                                    Não informado

                                @endif

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Horário final
                            </small>

                            <div class="fw-semibold">

                                @if(
                                    $reserva->horario_fim
                                )

                                    {{ substr(
                                        $reserva
                                            ->horario_fim,
                                        0,
                                        5
                                    ) }}

                                @else

                                    Não informado

                                @endif

                            </div>

                        </div>


                        @if(
                            $reserva->observacoes
                        )

                            <div class="col-12">

                                <small class="text-muted">
                                    Observações
                                </small>

                                <div class="mt-1">

                                    {!! nl2br(
                                        e(
                                            $reserva
                                                ->observacoes
                                        )
                                    ) !!}

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- CLIENTE --}}
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        👤 Cliente
                    </h5>


                    <div class="mb-3">

                        <small class="text-muted">
                            Nome
                        </small>

                        <div class="fw-semibold">

                            {{ $reserva
                                ->cliente
                                ->nome }}

                        </div>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">
                            Telefone
                        </small>

                        <div class="fw-semibold">

                            {{ $reserva
                                ->cliente
                                ->telefone }}

                        </div>

                    </div>


                    @if(
                        $reserva
                            ->cliente
                            ->email
                    )

                        <div class="mb-3">

                            <small class="text-muted">
                                E-mail
                            </small>

                            <div>

                                {{ $reserva
                                    ->cliente
                                    ->email }}

                            </div>

                        </div>

                    @endif


                    <div class="d-grid gap-2 mt-4">

                        @php

                            $telefone =
                                preg_replace(
                                    '/\D/',
                                    '',
                                    $reserva
                                        ->cliente
                                        ->telefone
                                );

                        @endphp


                        <a
                            href="https://wa.me/55{{ $telefone }}"
                            target="_blank"
                            class="btn btn-success"
                        >
                            WhatsApp
                        </a>


                        <a
                            href="{{ route(
                                'clientes.show',
                                $reserva
                                    ->cliente
                                    ->id
                            ) }}"
                            class="btn btn-outline-secondary"
                        >
                            Ver ficha do cliente
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- PAGAMENTOS --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div
            class="card-header bg-white border-0 pt-4 px-4"
        >

            <div
                class="d-flex justify-content-between align-items-center flex-wrap gap-3"
            >

                <div>

                    <h5 class="fw-bold mb-1">
                        💳 Pagamentos
                    </h5>

                    <small class="text-muted">
                        Histórico financeiro desta reserva
                    </small>

                </div>


                @if(
                    $reserva->status
                    !== 'cancelada'
                )

                    <a
                        href="{{ route(
                            'pagamentos.create',
                            [
                                'reserva' =>
                                    $reserva->id
                            ]
                        ) }}"
                        class="btn btn-sm btn-success"
                    >
                        + Novo Pagamento
                    </a>

                @endif

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Descrição</th>
                            <th>Vencimento</th>
                            <th>Pagamento</th>
                            <th>Forma</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th class="text-end">
                                Ações
                            </th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse(
                            $pagamentos
                            as $pagamento
                        )

                            @php

                                $atrasado =
                                    $pagamento->status
                                        === 'pendente'
                                    &&
                                    $pagamento
                                        ->data_vencimento
                                        ->isPast();

                            @endphp


                            <tr
                                class="{{
                                    $atrasado
                                    ? 'table-danger'
                                    : ''
                                }}"
                            >

                                <td>

                                    <div class="fw-semibold">

                                        {{ $pagamento
                                            ->descricao }}

                                    </div>

                                </td>


                                <td>

                                    {{ $pagamento
                                        ->data_vencimento
                                        ->format('d/m/Y') }}

                                </td>


                                <td>

                                    @if(
                                        $pagamento
                                            ->data_pagamento
                                    )

                                        {{ $pagamento
                                            ->data_pagamento
                                            ->format('d/m/Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    @if(
                                        $pagamento
                                            ->forma_pagamento
                                    )

                                        {{ match(
                                            $pagamento
                                                ->forma_pagamento
                                        ) {
                                            'pix' =>
                                                'PIX',

                                            'dinheiro' =>
                                                'Dinheiro',

                                            'cartao_credito' =>
                                                'Cartão de crédito',

                                            'cartao_debito' =>
                                                'Cartão de débito',

                                            'transferencia' =>
                                                'Transferência',

                                            'boleto' =>
                                                'Boleto',

                                            default =>
                                                'Outro',
                                        } }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td class="fw-semibold">

                                    R$

                                    {{ number_format(
                                        $pagamento
                                            ->valor,
                                        2,
                                        ',',
                                        '.'
                                    ) }}

                                </td>


                                <td>

                                    @if($atrasado)

                                        <span
                                            class="badge bg-danger"
                                        >
                                            Atrasado
                                        </span>

                                    @elseif(
                                        $pagamento->status
                                        === 'pago'
                                    )

                                        <span
                                            class="badge bg-success"
                                        >
                                            Pago
                                        </span>

                                    @elseif(
                                        $pagamento->status
                                        === 'pendente'
                                    )

                                        <span
                                            class="badge bg-warning text-dark"
                                        >
                                            Pendente
                                        </span>

                                    @else

                                        <span
                                            class="badge bg-secondary"
                                        >
                                            Cancelado
                                        </span>

                                    @endif

                                </td>


                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'pagamentos.edit',
                                            $pagamento->id
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Editar
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >

                                    <div class="fs-1 mb-3">
                                        💳
                                    </div>

                                    <div class="fw-semibold">
                                        Nenhum pagamento registrado
                                    </div>

                                    <p class="text-muted mb-3">
                                        Cadastre o primeiro pagamento desta reserva.
                                    </p>


                                    @if(
                                        $reserva->status
                                        !== 'cancelada'
                                    )

                                        <a
                                            href="{{ route(
                                                'pagamentos.create',
                                                [
                                                    'reserva'
                                                    =>
                                                    $reserva->id
                                                ]
                                            ) }}"
                                            class="btn btn-success"
                                        >
                                            + Novo Pagamento
                                        </a>

                                    @endif

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- AÇÕES INFERIORES --}}
    {{-- ====================================================== --}}

    <div
        class="d-flex gap-2 flex-wrap mb-4"
    >

        <a
            href="{{ route(
                'reservas.edit',
                $reserva->id
            ) }}"
            class="btn btn-outline-primary"
        >
            Editar Reserva
        </a>


        <a
            href="{{ route('agenda.index') }}"
            class="btn btn-outline-success"
        >
            📅 Abrir Agenda
        </a>


        <a
            href="{{ route(
                'clientes.show',
                $reserva->cliente->id
            ) }}"
            class="btn btn-outline-secondary"
        >
            👤 Abrir Cliente
        </a>

    </div>

</div>