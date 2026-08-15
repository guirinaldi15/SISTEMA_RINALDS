<div class="container-fluid py-4 px-4">

    {{-- ====================================================== --}}
    {{-- CABEÇALHO --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Reservas
            </h2>

            <p class="text-muted mb-0">
                Gerencie as reservas e eventos da Chácara Rinald's.
            </p>
        </div>

        <a
            href="{{ route('reservas.create') }}"
            class="btn btn-success"
        >
            + Nova Reserva
        </a>

    </div>


    {{-- ====================================================== --}}
    {{-- MENSAGENS --}}
    {{-- ====================================================== --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- FILTROS --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                {{-- PESQUISA --}}
                <div class="col-md-8">

                    <label class="form-label fw-semibold">
                        Pesquisar
                    </label>

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar pelo nome ou telefone do cliente..."
                    >

                </div>


                {{-- STATUS --}}
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Status
                    </label>

                    <select
                        wire:model.live="status"
                        class="form-select"
                    >

                        <option value="">
                            Todos os status
                        </option>

                        <option value="pre_reserva">
                            Pré-reserva
                        </option>

                        <option value="confirmada">
                            Confirmada
                        </option>

                        <option value="realizada">
                            Realizada
                        </option>

                        <option value="cancelada">
                            Cancelada
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- TABELA DE RESERVAS --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>
                                Cliente
                            </th>

                            <th>
                                Data
                            </th>

                            <th>
                                Evento
                            </th>

                            <th>
                                Convidados
                            </th>

                            <th>
                                Valor
                            </th>

                            <th>
                                Financeiro
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($reservas as $reserva)

                            @php

                                /*
                                |--------------------------------------------------------------------------
                                | FINANCEIRO
                                |--------------------------------------------------------------------------
                                */

                                $totalPago = $reserva
                                    ->pagamentos
                                    ->where('status', 'pago')
                                    ->sum('valor');


                                $valorTotal = (float) $reserva->valor_total;


                                $saldoRestante = max(
                                    0,
                                    $valorTotal - (float) $totalPago
                                );


                                /*
                                |--------------------------------------------------------------------------
                                | PAGAMENTO ATRASADO
                                |--------------------------------------------------------------------------
                                */

                                $possuiAtraso = $reserva
                                    ->pagamentos
                                    ->contains(function ($pagamento) {

                                        return
                                            $pagamento->status === 'pendente'
                                            &&
                                            $pagamento->data_vencimento
                                            &&
                                            $pagamento->data_vencimento->isPast();

                                    });


                                /*
                                |--------------------------------------------------------------------------
                                | SITUAÇÃO FINANCEIRA
                                |--------------------------------------------------------------------------
                                */

                                if ($valorTotal <= 0) {

                                    $situacaoFinanceira = 'sem_valor';

                                } elseif ($saldoRestante <= 0) {

                                    $situacaoFinanceira = 'quitada';

                                } elseif ($possuiAtraso) {

                                    $situacaoFinanceira = 'atrasada';

                                } elseif ($totalPago > 0) {

                                    $situacaoFinanceira = 'parcial';

                                } else {

                                    $situacaoFinanceira = 'pendente';

                                }

                            @endphp


                            <tr>

                                {{-- ====================================================== --}}
                                {{-- CLIENTE --}}
                                {{-- ====================================================== --}}

                                <td>

                                    <div class="fw-semibold">

                                        {{ $reserva->cliente->nome ?? 'Cliente não encontrado' }}

                                    </div>


                                    @if($reserva->cliente)

                                        <small class="text-muted">

                                            {{ $reserva->cliente->telefone ?? 'Sem telefone' }}

                                        </small>

                                    @endif

                                </td>


                                {{-- ====================================================== --}}
                                {{-- DATA --}}
                                {{-- ====================================================== --}}

                                <td>

                                    <div class="fw-semibold">

                                        {{ $reserva
                                            ->data_evento
                                            ->format('d/m/Y') }}

                                    </div>


                                    @if(
                                        $reserva->horario_inicio
                                        ||
                                        $reserva->horario_fim
                                    )

                                        <small class="text-muted">

                                            @if($reserva->horario_inicio)

                                                {{ substr(
                                                    $reserva->horario_inicio,
                                                    0,
                                                    5
                                                ) }}

                                            @endif


                                            @if(
                                                $reserva->horario_inicio
                                                &&
                                                $reserva->horario_fim
                                            )

                                                às

                                            @endif


                                            @if($reserva->horario_fim)

                                                {{ substr(
                                                    $reserva->horario_fim,
                                                    0,
                                                    5
                                                ) }}

                                            @endif

                                        </small>

                                    @endif

                                </td>


                                {{-- ====================================================== --}}
                                {{-- EVENTO --}}
                                {{-- ====================================================== --}}

                                <td>

                                    <div class="fw-semibold">

                                        {{ $reserva->tipo_evento }}

                                    </div>

                                </td>


                                {{-- ====================================================== --}}
                                {{-- CONVIDADOS --}}
                                {{-- ====================================================== --}}

                                <td>

                                    @if($reserva->quantidade_convidados)

                                        {{ $reserva->quantidade_convidados }}

                                        <small class="text-muted">
                                            pessoas
                                        </small>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- ====================================================== --}}
                                {{-- VALOR --}}
                                {{-- ====================================================== --}}

                                <td>

                                    @if($reserva->valor_total)

                                        <div class="fw-semibold">

                                            R$

                                            {{ number_format(
                                                $reserva->valor_total,
                                                2,
                                                ',',
                                                '.'
                                            ) }}

                                        </div>


                                        @if($totalPago > 0)

                                            <small class="text-success">

                                                R$

                                                {{ number_format(
                                                    $totalPago,
                                                    2,
                                                    ',',
                                                    '.'
                                                ) }}

                                                pago

                                            </small>

                                        @endif

                                    @else

                                        <span class="text-muted">
                                            Não informado
                                        </span>

                                    @endif

                                </td>


                                {{-- ====================================================== --}}
                                {{-- FINANCEIRO --}}
                                {{-- ====================================================== --}}

                                <td>

                                    @switch($situacaoFinanceira)


                                        {{-- QUITADA --}}
                                        @case('quitada')

                                            <span class="badge bg-success">

                                                ✓ Quitada

                                            </span>

                                        @break


                                        {{-- ATRASADA --}}
                                        @case('atrasada')

                                            <span class="badge bg-danger">

                                                Atrasada

                                            </span>

                                            <div class="mt-1">

                                                <small class="text-danger">

                                                    Saldo:

                                                    R$

                                                    {{ number_format(
                                                        $saldoRestante,
                                                        2,
                                                        ',',
                                                        '.'
                                                    ) }}

                                                </small>

                                            </div>

                                        @break


                                        {{-- PARCIAL --}}
                                        @case('parcial')

                                            <span class="badge bg-warning text-dark">

                                                Parcial

                                            </span>

                                            <div class="mt-1">

                                                <small class="text-muted">

                                                    Falta:

                                                    R$

                                                    {{ number_format(
                                                        $saldoRestante,
                                                        2,
                                                        ',',
                                                        '.'
                                                    ) }}

                                                </small>

                                            </div>

                                        @break


                                        {{-- PENDENTE --}}
                                        @case('pendente')

                                            <span class="badge bg-secondary">

                                                Pendente

                                            </span>

                                            <div class="mt-1">

                                                <small class="text-muted">

                                                    R$

                                                    {{ number_format(
                                                        $saldoRestante,
                                                        2,
                                                        ',',
                                                        '.'
                                                    ) }}

                                                </small>

                                            </div>

                                        @break


                                        {{-- SEM VALOR --}}
                                        @default

                                            <span class="badge bg-light text-dark">

                                                Sem valor

                                            </span>

                                    @endswitch

                                </td>


                                {{-- ====================================================== --}}
                                {{-- STATUS DA RESERVA --}}
                                {{-- ====================================================== --}}

                                <td>

                                    @switch($reserva->status)


                                        @case('pre_reserva')

                                            <span class="badge bg-warning text-dark">

                                                Pré-reserva

                                            </span>

                                        @break


                                        @case('confirmada')

                                            <span class="badge bg-success">

                                                Confirmada

                                            </span>

                                        @break


                                        @case('realizada')

                                            <span class="badge bg-secondary">

                                                Realizada

                                            </span>

                                        @break


                                        @case('cancelada')

                                            <span class="badge bg-danger">

                                                Cancelada

                                            </span>

                                        @break


                                        @default

                                            <span class="badge bg-light text-dark">

                                                {{ ucfirst($reserva->status) }}

                                            </span>

                                    @endswitch

                                </td>


                                {{-- ====================================================== --}}
                                {{-- AÇÕES --}}
                                {{-- ====================================================== --}}

                                <td class="text-end">

                                    <div class="d-flex justify-content-end gap-1 flex-wrap">


                                        {{-- VISUALIZAR --}}
                                        <a
                                            href="{{ route(
                                                'reservas.show',
                                                $reserva->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-secondary"
                                            title="Visualizar reserva"
                                        >
                                            Visualizar
                                        </a>


                                        {{-- PAGAMENTO --}}
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
                                                class="btn btn-sm btn-outline-success"
                                                title="Adicionar pagamento"
                                            >
                                                💳 Pagamento
                                            </a>

                                        @endif


                                        {{-- EDITAR --}}
                                        <a
                                            href="{{ route(
                                                'reservas.edit',
                                                $reserva->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Editar reserva"
                                        >
                                            Editar
                                        </a>


                                        {{-- EXCLUIR --}}
                                        <a
                                            href="{{ route(
                                                'reservas.delete',
                                                $reserva->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Excluir reserva"
                                        >
                                            Excluir
                                        </a>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            {{-- ====================================================== --}}
                            {{-- SEM RESERVAS --}}
                            {{-- ====================================================== --}}

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-5"
                                >

                                    <div class="fs-1 mb-3">
                                        🎉
                                    </div>


                                    <h5 class="fw-semibold">
                                        Nenhuma reserva encontrada
                                    </h5>


                                    @if(
                                        !empty($search)
                                        ||
                                        !empty($status)
                                    )

                                        <p class="text-muted mb-3">

                                            Nenhuma reserva corresponde aos filtros selecionados.

                                        </p>

                                    @else

                                        <p class="text-muted mb-3">

                                            Cadastre a primeira reserva da Chácara Rinald's.

                                        </p>

                                    @endif


                                    <a
                                        href="{{ route('reservas.create') }}"
                                        class="btn btn-success"
                                    >
                                        + Nova Reserva
                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- RODAPÉ --}}
    {{-- ====================================================== --}}

    @if($reservas->count() > 0)

        <div
            class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3"
        >

            <small class="text-muted">

                {{ $reservas->count() }}

                {{ $reservas->count() === 1
                    ? 'reserva encontrada'
                    : 'reservas encontradas'
                }}

            </small>


            <a
                href="{{ route('agenda.index') }}"
                class="btn btn-sm btn-outline-secondary"
            >
                📅 Visualizar na Agenda
            </a>

        </div>

    @endif

</div>