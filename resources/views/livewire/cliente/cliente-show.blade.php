<div class="container-fluid py-4 px-4">

    {{-- ====================================================== --}}
    {{-- CABEÇALHO --}}
    {{-- ====================================================== --}}

    <div
        class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4"
    >

        <div>

            <a
                href="{{ route('clientes.index') }}"
                class="text-decoration-none"
            >
                ← Voltar para clientes
            </a>

            <h2 class="fw-bold mt-3 mb-1">
                {{ $cliente->nome }}
            </h2>

            <div class="text-muted">
                {{ $cliente->telefone }}
            </div>

            @if($cliente->email)

                <div class="text-muted">
                    {{ $cliente->email }}
                </div>

            @endif

        </div>


        {{-- Botões principais --}}
        <div class="d-flex gap-2 flex-wrap">

            @php

                $telefone = preg_replace(
                    '/\D/',
                    '',
                    $cliente->telefone
                );

            @endphp


            {{-- WhatsApp --}}
            <a
                href="https://wa.me/55{{ $telefone }}"
                target="_blank"
                class="btn btn-success"
            >
                WhatsApp
            </a>


            {{-- Novo Atendimento --}}
            <a
                href="{{ route(
                    'atendimentos.create',
                    ['cliente' => $cliente->id]
                ) }}"
                class="btn btn-primary"
            >
                + Novo Atendimento
            </a>


            {{-- Editar --}}
            <a
                href="{{ route(
                    'clientes.edit',
                    $cliente->id
                ) }}"
                class="btn btn-outline-secondary"
            >
                Editar Cliente
            </a>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- CARDS --}}
    {{-- ====================================================== --}}

    <div class="row g-3 mb-4">


        {{-- Atendimentos --}}
        <div class="col-md-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small
                        class="text-muted text-uppercase fw-semibold"
                    >
                        Atendimentos
                    </small>

                    <div
                        class="d-flex justify-content-between align-items-center mt-2"
                    >

                        <h2 class="fw-bold mb-0">
                            {{ $totalAtendimentos }}
                        </h2>

                        <span class="fs-3">
                            💬
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- Lembretes --}}
        <div class="col-md-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small
                        class="text-muted text-uppercase fw-semibold"
                    >
                        Lembretes pendentes
                    </small>

                    <div
                        class="d-flex justify-content-between align-items-center mt-2"
                    >

                        <h2 class="fw-bold mb-0">
                            {{ $lembretesPendentes->count() }}
                        </h2>

                        <span class="fs-3">
                            🔔
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- Reservas --}}
        <div class="col-md-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small
                        class="text-muted text-uppercase fw-semibold"
                    >
                        Reservas
                    </small>

                    <div
                        class="d-flex justify-content-between align-items-center mt-2"
                    >

                        <h2 class="fw-bold mb-0">
                            {{ $totalReservas }}
                        </h2>

                        <span class="fs-3">
                            📅
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- Confirmadas --}}
        <div class="col-md-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small
                        class="text-muted text-uppercase fw-semibold"
                    >
                        Confirmadas
                    </small>

                    <div
                        class="d-flex justify-content-between align-items-center mt-2"
                    >

                        <h2 class="fw-bold mb-0">
                            {{ $reservasConfirmadas }}
                        </h2>

                        <span class="fs-3">
                            ✅
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- DADOS + PRÓXIMA RESERVA --}}
    {{-- ====================================================== --}}

    <div class="row g-4 mb-4">


        {{-- DADOS DO CLIENTE --}}
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        👤 Dados do Cliente
                    </h5>


                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted">
                                Nome
                            </small>

                            <div class="fw-semibold">
                                {{ $cliente->nome }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Telefone
                            </small>

                            <div class="fw-semibold">
                                {{ $cliente->telefone }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                E-mail
                            </small>

                            <div class="fw-semibold">

                                {{ $cliente->email ?? 'Não informado' }}

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                CPF / CNPJ
                            </small>

                            <div class="fw-semibold">

                                {{ $cliente->cpf_cnpj ?? 'Não informado' }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                CEP
                            </small>

                            <div class="fw-semibold">

                                {{ $cliente->cep ?? 'Não informado' }}

                            </div>

                        </div>


                        <div class="col-md-5">

                            <small class="text-muted">
                                Cidade
                            </small>

                            <div class="fw-semibold">

                                {{ $cliente->cidade ?? 'Não informada' }}

                            </div>

                        </div>


                        <div class="col-md-3">

                            <small class="text-muted">
                                Estado
                            </small>

                            <div class="fw-semibold">

                                {{ $cliente->estado ?? '-' }}

                            </div>

                        </div>


                        @if($cliente->observacoes)

                            <div class="col-12">

                                <small class="text-muted">
                                    Observações
                                </small>

                                <div class="mt-1">

                                    {{ $cliente->observacoes }}

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- PRÓXIMA RESERVA --}}
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        🎉 Próximo Evento
                    </h5>

                    @if($proximaReserva)

                        <div class="text-center py-3">

                            <div
                                class="display-5 fw-bold text-success"
                            >

                                {{ $proximaReserva
                                    ->data_evento
                                    ->format('d') }}

                            </div>

                            <div
                                class="text-uppercase text-muted"
                            >

                                {{ $proximaReserva
                                    ->data_evento
                                    ->locale('pt_BR')
                                    ->translatedFormat('F Y') }}

                            </div>

                        </div>


                        <hr>


                        <div class="mb-3">

                            <small class="text-muted">
                                Evento
                            </small>

                            <div class="fw-semibold">

                                {{ $proximaReserva->tipo_evento }}

                            </div>

                        </div>


                        @if($proximaReserva->quantidade_convidados)

                            <div class="mb-3">

                                <small class="text-muted">
                                    Convidados
                                </small>

                                <div class="fw-semibold">

                                    {{ $proximaReserva
                                        ->quantidade_convidados }}

                                </div>

                            </div>

                        @endif


                        <div class="mb-3">

                            <small class="text-muted">
                                Valor
                            </small>

                            <div class="fw-semibold">

                                @if($proximaReserva->valor_total)

                                    R$
                                    {{ number_format(
                                        $proximaReserva->valor_total,
                                        2,
                                        ',',
                                        '.'
                                    ) }}

                                @else

                                    Não informado

                                @endif

                            </div>

                        </div>


                        <div>

                            @if(
                                $proximaReserva->status
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

                    @else

                        <div class="text-center py-5">

                            <div class="fs-1">
                                📅
                            </div>

                            <p class="text-muted mt-3">
                                Este cliente não possui próximo evento.
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- ATENDIMENTOS --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div
            class="card-header bg-white border-0 pt-4 px-4"
        >

            <div
                class="d-flex justify-content-between align-items-center"
            >

                <div>

                    <h5 class="fw-bold mb-1">
                        💬 Histórico de Atendimentos
                    </h5>

                    <small class="text-muted">
                        Histórico comercial deste cliente
                    </small>

                </div>


                <a
                    href="{{ route(
                        'atendimentos.create',
                        ['cliente' => $cliente->id]
                    ) }}"
                    class="btn btn-sm btn-primary"
                >
                    + Atendimento
                </a>

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Evento</th>
                            <th>Data</th>
                            <th>Origem</th>
                            <th>Status</th>
                            <th>Último contato</th>
                            <th></th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse(
                            $cliente->atendimentos
                            as $atendimento
                        )

                            <tr>

                                <td>

                                    {{ $atendimento
                                        ->tipo_evento
                                        ?? '-' }}

                                </td>


                                <td>

                                    @if($atendimento->data_evento)

                                        {{ $atendimento
                                            ->data_evento
                                            ->format('d/m/Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>
                                    {{ $atendimento->origem }}
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


                                <td>

                                    @if($atendimento->ultimo_contato)

                                        {{ $atendimento
                                            ->ultimo_contato
                                            ->format('d/m/Y H:i') }}

                                    @else

                                        -

                                    @endif

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
                                    colspan="6"
                                    class="text-center text-muted py-4"
                                >
                                    Nenhum atendimento registrado.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- LEMBRETES --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div
            class="card-header bg-white border-0 pt-4 px-4"
        >

            <h5 class="fw-bold mb-1">
                🔔 Lembretes
            </h5>

            <small class="text-muted">
                Retornos relacionados aos atendimentos
            </small>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Lembrete</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th></th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($lembretes as $lembrete)

                            @php

                                $atrasado =
                                    $lembrete->status === 'pendente'
                                    && $lembrete
                                        ->lembrar_em
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
                                        {{ $lembrete->titulo }}
                                    </div>

                                    @if($lembrete->descricao)

                                        <small class="text-muted">

                                            {{ \Illuminate\Support\Str::limit(
                                                $lembrete->descricao,
                                                100
                                            ) }}

                                        </small>

                                    @endif

                                </td>


                                <td>

                                    {{ $lembrete
                                        ->lembrar_em
                                        ->format('d/m/Y H:i') }}

                                    @if($atrasado)

                                        <div>

                                            <span
                                                class="badge bg-danger"
                                            >
                                                Atrasado
                                            </span>

                                        </div>

                                    @endif

                                </td>


                                <td>

                                    @if(
                                        $lembrete->status
                                        === 'pendente'
                                    )

                                        <span
                                            class="badge bg-warning text-dark"
                                        >
                                            Pendente
                                        </span>

                                    @elseif(
                                        $lembrete->status
                                        === 'concluido'
                                    )

                                        <span
                                            class="badge bg-success"
                                        >
                                            Concluído
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
                                            'lembretes.edit',
                                            $lembrete->id
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
                                    Nenhum lembrete para este cliente.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- RESERVAS --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm">

        <div
            class="card-header bg-white border-0 pt-4 px-4"
        >

            <h5 class="fw-bold mb-1">
                🎉 Histórico de Reservas
            </h5>

            <small class="text-muted">
                Eventos vinculados a este cliente
            </small>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Data</th>
                            <th>Evento</th>
                            <th>Convidados</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th></th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse(
                            $cliente->reservas
                            as $reserva
                        )

                            <tr>

                                <td class="fw-semibold">

                                    {{ $reserva
                                        ->data_evento
                                        ->format('d/m/Y') }}

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

                                    @switch($reserva->status)

                                        @case('pre_reserva')

                                            <span
                                                class="badge bg-warning text-dark"
                                            >
                                                Pré-reserva
                                            </span>

                                        @break


                                        @case('confirmada')

                                            <span
                                                class="badge bg-success"
                                            >
                                                Confirmada
                                            </span>

                                        @break


                                        @case('cancelada')

                                            <span
                                                class="badge bg-danger"
                                            >
                                                Cancelada
                                            </span>

                                        @break


                                        @case('realizada')

                                            <span
                                                class="badge bg-secondary"
                                            >
                                                Realizada
                                            </span>

                                        @break

                                    @endswitch

                                </td>


                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'reservas.edit',
                                            $reserva->id
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
                                    colspan="6"
                                    class="text-center text-muted py-4"
                                >
                                    Nenhuma reserva registrada.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>