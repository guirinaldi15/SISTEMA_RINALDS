<div class="container-fluid py-4 px-4">

    {{-- CABEÇALHO --}}
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

                {{
                    $reserva
                        ->cliente
                        ->nome
                }}

            </h2>


            <p class="text-muted mb-0">

                {{
                    $reserva
                        ->data_evento
                        ->format(
                            'd/m/Y'
                        )
                }}

                @if($reserva->espaco)

                    •

                    {{
                        $reserva
                            ->espaco
                            ->nome
                    }}

                @endif

            </p>

        </div>


        <div class="d-flex gap-2 flex-wrap">

            <a
                href="{{
                    route(
                        'clientes.show',
                        $reserva
                            ->cliente
                            ->id
                    )
                }}"
                class="btn btn-outline-secondary"
            >
                👤 Cliente
            </a>


            @if(
                $reserva->status
                !==
                'cancelada'
            )

                <a
                    href="{{
                        route(
                            'pagamentos.create',
                            [
                                'reserva'
                                =>
                                $reserva->id
                            ]
                        )
                    }}"
                    class="btn btn-success"
                >
                    💳 Novo Pagamento
                </a>

            @endif


            <a
                href="{{
                    route(
                        'reservas.edit',
                        $reserva->id
                    )
                }}"
                class="btn btn-outline-primary"
            >
                ✏️ Editar Reserva
            </a>

        </div>

    </div>


    {{-- STATUS --}}
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


    {{-- CARDS --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div
                class="card border-0 shadow-sm h-100"
            >

                <div class="card-body">

                    <small
                        class="text-muted text-uppercase fw-semibold"
                    >
                        Valor da Reserva
                    </small>


                    <h3 class="fw-bold mt-2 mb-0">

                        R$

                        {{
                            number_format(
                                (float)
                                $reserva
                                    ->valor_total,
                                2,
                                ',',
                                '.'
                            )
                        }}

                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div
                class="card border-0 shadow-sm h-100"
            >

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

                        {{
                            number_format(
                                $totalPago,
                                2,
                                ',',
                                '.'
                            )
                        }}

                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div
                class="card border-0 shadow-sm h-100"
            >

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
                            ?
                            'text-danger'
                            :
                            'text-success'
                        }}
                        mt-2 mb-0"
                    >

                        R$

                        {{
                            number_format(
                                $saldoRestante,
                                2,
                                ',',
                                '.'
                            )
                        }}

                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- FINANCEIRO --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <div
                class="d-flex justify-content-between align-items-center mb-3"
            >

                <div>

                    <h5 class="fw-bold mb-1">
                        Situação Financeira
                    </h5>

                    <small class="text-muted">
                        Acompanhamento da reserva
                    </small>

                </div>


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
                            🔴 Pagamento atrasado
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
                            ⚪ Pendente
                        </span>

                    @break


                    @default

                        <span
                            class="badge bg-secondary fs-6"
                        >
                            Sem valor
                        </span>

                @endswitch

            </div>


            <div
                class="d-flex justify-content-between mb-2"
            >

                <span>
                    Progresso
                </span>

                <strong>
                    {{
                        number_format(
                            $percentualPago,
                            0,
                            ',',
                            '.'
                        )
                    }}%
                </strong>

            </div>


            <div
                class="progress"
                style="height:14px;"
            >

                <div
                    class="progress-bar bg-success"
                    style="
                        width:
                        {{ $percentualPago }}%;
                    "
                ></div>

            </div>

        </div>

    </div>


    {{-- DADOS --}}
    <div class="row g-4 mb-4">


        <div class="col-lg-8">

            <div
                class="card border-0 shadow-sm h-100"
            >

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

                                {{
                                    $reserva
                                        ->cliente
                                        ->nome
                                }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Telefone
                            </small>

                            <div class="fw-semibold">

                                {{
                                    $reserva
                                        ->cliente
                                        ->telefone
                                    ??
                                    'Não informado'
                                }}

                            </div>

                        </div>


                        {{-- ESPAÇO --}}
                        <div class="col-md-6">

                            <small class="text-muted">
                                Espaço
                            </small>

                            <div class="fw-semibold">

                                {{
                                    $reserva
                                        ->espaco
                                        ?->nome
                                    ??
                                    'Não informado'
                                }}

                            </div>


                            @if(
                                $reserva->espaco
                                &&
                                $reserva
                                    ->espaco
                                    ->capacidade_maxima
                            )

                                <small class="text-muted">

                                    Capacidade máxima:

                                    {{
                                        $reserva
                                            ->espaco
                                            ->capacidade_maxima
                                    }}

                                    pessoas

                                </small>

                            @endif

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Tipo do evento
                            </small>

                            <div class="fw-semibold">

                                {{
                                    $reserva
                                        ->tipo_evento
                                }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Data
                            </small>

                            <div class="fw-semibold">

                                {{
                                    $reserva
                                        ->data_evento
                                        ->format(
                                            'd/m/Y'
                                        )
                                }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Convidados
                            </small>

                            <div class="fw-semibold">

                                {{
                                    $reserva
                                        ->quantidade_convidados
                                    ??
                                    'Não informado'
                                }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Status
                            </small>

                            <div class="fw-semibold">

                                {{
                                    ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $reserva
                                                ->status
                                        )
                                    )
                                }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Horário de início
                            </small>

                            <div class="fw-semibold">

                                @if(
                                    $reserva
                                        ->horario_inicio
                                )

                                    {{
                                        substr(
                                            $reserva
                                                ->horario_inicio,
                                            0,
                                            5
                                        )
                                    }}

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
                                    $reserva
                                        ->horario_fim
                                )

                                    {{
                                        substr(
                                            $reserva
                                                ->horario_fim,
                                            0,
                                            5
                                        )
                                    }}

                                @else

                                    Não informado

                                @endif

                            </div>

                        </div>


                        @if(
                            $reserva
                                ->observacoes
                        )

                            <div class="col-12">

                                <small class="text-muted">
                                    Observações
                                </small>

                                <div class="mt-1">

                                    {!!
                                        nl2br(
                                            e(
                                                $reserva
                                                    ->observacoes
                                            )
                                        )
                                    !!}

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- ESPAÇO --}}
        <div class="col-lg-4">

            <div
                class="card border-0 shadow-sm h-100"
            >

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        🏡 Espaço
                    </h5>


                    @if(
                        $reserva->espaco
                    )

                        <h4 class="fw-bold">

                            {{
                                $reserva
                                    ->espaco
                                    ->nome
                            }}

                        </h4>


                        <p class="text-muted">

                            {{
                                $reserva
                                    ->espaco
                                    ->descricao
                                ??
                                'Sem descrição.'
                            }}

                        </p>


                        <hr>


                        <div class="mb-2">

                            <strong>
                                Capacidade:
                            </strong>

                            {{
                                $reserva
                                    ->espaco
                                    ->capacidade_maxima
                                ??
                                'Não informada'
                            }}

                        </div>


                        <div class="mb-2">

                            <strong>
                                Mesas:
                            </strong>

                            {{
                                $reserva
                                    ->espaco
                                    ->quantidade_mesas
                            }}

                        </div>


                        <div class="mb-2">

                            <strong>
                                Cadeiras:
                            </strong>

                            {{
                                $reserva
                                    ->espaco
                                    ->quantidade_cadeiras
                            }}

                        </div>


                        <a
                            href="{{
                                route(
                                    'espacos.show',
                                    $reserva
                                        ->espaco
                                        ->id
                                )
                            }}"
                            class="btn btn-outline-secondary w-100 mt-3"
                        >
                            Ver Espaço
                        </a>

                    @else

                        <p class="text-muted">
                            Nenhum espaço vinculado.
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- PAGAMENTOS --}}
    <div class="card border-0 shadow-sm">

        <div
            class="card-header bg-white border-0 pt-4 px-4"
        >

            <div
                class="d-flex justify-content-between align-items-center"
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
                    $reserva
                        ->status
                    !==
                    'cancelada'
                )

                    <a
                        href="{{
                            route(
                                'pagamentos.create',
                                [
                                    'reserva'
                                    =>
                                    $reserva->id
                                ]
                            )
                        }}"
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

                            <th>
                                Descrição
                            </th>

                            <th>
                                Vencimento
                            </th>

                            <th>
                                Pagamento
                            </th>

                            <th>
                                Forma
                            </th>

                            <th>
                                Valor
                            </th>

                            <th>
                                Status
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
                                    $pagamento
                                        ->status
                                    ===
                                    'pendente'

                                    &&

                                    $pagamento
                                        ->data_vencimento

                                    &&

                                    $pagamento
                                        ->data_vencimento
                                        ->isPast();

                            @endphp


                            <tr
                                class="{{
                                    $atrasado
                                    ?
                                    'table-danger'
                                    :
                                    ''
                                }}"
                            >

                                <td>

                                    {{
                                        $pagamento
                                            ->descricao
                                    }}

                                </td>


                                <td>

                                    @if(
                                        $pagamento
                                            ->data_vencimento
                                    )

                                        {{
                                            $pagamento
                                                ->data_vencimento
                                                ->format(
                                                    'd/m/Y'
                                                )
                                        }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    @if(
                                        $pagamento
                                            ->data_pagamento
                                    )

                                        {{
                                            $pagamento
                                                ->data_pagamento
                                                ->format(
                                                    'd/m/Y'
                                                )
                                        }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    {{
                                        $pagamento
                                            ->forma_pagamento
                                        ??
                                        '-'
                                    }}

                                </td>


                                <td>

                                    R$

                                    {{
                                        number_format(
                                            $pagamento
                                                ->valor,
                                            2,
                                            ',',
                                            '.'
                                        )
                                    }}

                                </td>


                                <td>

                                    @if(
                                        $pagamento
                                            ->status
                                        ===
                                        'pago'
                                    )

                                        <span
                                            class="badge bg-success"
                                        >
                                            Pago
                                        </span>

                                    @elseif($atrasado)

                                        <span
                                            class="badge bg-danger"
                                        >
                                            Atrasado
                                        </span>

                                    @else

                                        <span
                                            class="badge bg-warning text-dark"
                                        >
                                            Pendente
                                        </span>

                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-4 text-muted"
                                >

                                    Nenhum pagamento cadastrado.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>